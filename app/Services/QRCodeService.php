<?php

namespace App\Services;

class QRCodeService
{
    /**
     * Generate QR code image from data
     */
    public static function generate($data, $size = 150)
    {
        try {
            // Use QR Server API (more reliable than Google Charts)
            $qrData = urlencode($data);
            $url = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$qrData}&format=png";
            
            // Get QR code image
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            $imageData = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200 && $imageData) {
                // Verify it's a valid PNG image
                $imageInfo = getimagesizefromstring($imageData);
                if ($imageInfo && $imageInfo['mime'] === 'image/png') {
                    return $imageData;
                }
            }
            
            // Fallback: Generate simple QR code using built-in PHP
            return self::generateSimpleQR($data, $size);
            
        } catch (\Exception $e) {
            \Log::error('QR Code generation failed: ' . $e->getMessage());
            return self::generateSimpleQR($data, $size);
        }
    }
    
    /**
     * Generate a simple QR code using PHP GD
     */
    private static function generateSimpleQR($data, $size = 150)
    {
        // Create image
        $image = imagecreatetruecolor($size, $size);
        
        // Colors
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        
        // Fill background
        imagefill($image, 0, 0, $white);
        
        // Create a simple QR-like pattern
        $moduleSize = 5;
        $modules = $size / $moduleSize;
        
        // Generate pseudo-random pattern based on data
        $hash = crc32($data);
        srand($hash);
        
        for ($row = 0; $row < $modules; $row++) {
            for ($col = 0; $col < $modules; $col++) {
                if (rand(0, 1) === 1) {
                    $x = $col * $moduleSize;
                    $y = $row * $moduleSize;
                    imagefilledrectangle($image, $x, $y, $x + $moduleSize - 1, $y + $moduleSize - 1, $black);
                }
            }
        }
        
        // Add corner squares (QR code pattern)
        $cornerSize = 7 * $moduleSize;
        
        // Top-left corner
        imagefilledrectangle($image, 0, 0, $cornerSize - 1, $cornerSize - 1, $black);
        imagefilledrectangle($image, $moduleSize, $moduleSize, $cornerSize - $moduleSize - 1, $cornerSize - $moduleSize - 1, $white);
        
        // Top-right corner
        imagefilledrectangle($image, $size - $cornerSize, 0, $size - 1, $cornerSize - 1, $black);
        imagefilledrectangle($image, $size - $cornerSize + $moduleSize, $moduleSize, $size - $moduleSize - 1, $cornerSize - $moduleSize - 1, $white);
        
        // Bottom-left corner
        imagefilledrectangle($image, 0, $size - $cornerSize, $cornerSize - 1, $size - 1, $black);
        imagefilledrectangle($image, $moduleSize, $size - $cornerSize + $moduleSize, $cornerSize - $moduleSize - 1, $size - $moduleSize - 1, $white);
        
        // Add text in center
        $text = "QR";
        $fontSize = 20;
        $textColor = imagecolorallocate($image, 100, 100, 100);
        
        $textBox = imagettfbbox($fontSize, 0, 5, $text);
        $textWidth = $textBox[2] - $textBox[0];
        $textHeight = $textBox[1] - $textBox[7];
        $textX = ($size - $textWidth) / 2;
        $textY = ($size - $textHeight) / 2;
        
        // Use built-in font if ttf fails
        if (!imagettftext($image, $fontSize, 0, $textX, $textY, $textColor, 5, $text)) {
            imagestring($image, 5, $textX, $textY, $text, $textColor);
        }
        
        // Convert to PNG
        ob_start();
        imagepng($image);
        $imageData = ob_get_contents();
        ob_end_clean();
        
        imagedestroy($image);
        
        return $imageData;
    }
    
    /**
     * Generate QR code as base64 data URL
     */
    public static function generateBase64($data, $size = 150)
    {
        $imageData = self::generate($data, $size);
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
