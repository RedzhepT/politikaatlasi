<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Process and store an uploaded image
     *
     * @param UploadedFile $file
     * @param string $path
     * @param array $sizes
     * @return array
     */
    public function processAndStore(UploadedFile $file, string $path, array $sizes = []): array
    {
        $filename = time() . '_' . $file->getClientOriginalName();
        $originalPath = $path . '/' . $filename;
        
        // Store original image
        Storage::putFileAs('public/' . $path, $file, $filename);
        
        $images = [
            'original' => $originalPath
        ];
        
        // Process different sizes if specified
        foreach ($sizes as $size => $dimensions) {
            $resizedFilename = time() . '_' . $size . '_' . $file->getClientOriginalName();
            $resizedPath = $path . '/' . $resizedFilename;
            
            $img = Image::make($file);
            $img->resize($dimensions['width'], $dimensions['height'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            Storage::put('public/' . $resizedPath, $img->encode());
            
            $images[$size] = $resizedPath;
        }
        
        return $images;
    }
    
    /**
     * Delete an image and its variations
     *
     * @param array $paths
     * @return bool
     */
    public function delete(array $paths): bool
    {
        foreach ($paths as $path) {
            if (Storage::exists('public/' . $path)) {
                Storage::delete('public/' . $path);
            }
        }
        
        return true;
    }
} 