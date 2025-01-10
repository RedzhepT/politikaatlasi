<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            
            // Dosya adını oluştur
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            
            // Dosyayı public/uploads/images klasörüne kaydet
            $file->move(public_path('uploads/images'), $fileName);
            
            // CKEditor'ün beklediği formatta yanıt döndür
            return response()->json([
                'url' => asset('uploads/images/' . $fileName)
            ]);
        }
        
        return response()->json([
            'error' => [
                'message' => 'Dosya yüklenemedi.'
            ]
        ], 400);
    }
} 