<?php

namespace App\Helpers;

class TextHelper
{
    public static function cleanSpanTags($content)
    {
        // Boş span etiketlerini kaldır
        $content = preg_replace('/<span[^>]*>([\s]*)<\/span>/', '', $content);
        
        // Sadece metin içeren span etiketlerini kaldır ve içeriğini koru
        $content = preg_replace('/<span[^>]*>(.*?)<\/span>/', '$1', $content);
        
        return $content;
    }
} 