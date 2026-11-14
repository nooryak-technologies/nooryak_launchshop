<?php

namespace App\Http\Helpers;

class Uploader
{
    /**
     * Upload an image and convert it automatically to .webp (quality 82, preserving transparency).
     * Preserves SVG, GIF, and ICO in their native format.
     */
    public static function upload_picture($directory, $img, $desiredBaseName = null, $maxWidth = null, $maxHeight = null, $quality = 82): string
    {
        return self::upload_webp($directory, $img, $desiredBaseName, $maxWidth, $maxHeight, $quality);
    }

    /**
     * Update an image: deletes the previous image and converts new upload automatically to .webp.
     */
    public static function update_picture($directory, $img, $old_img = null, $desiredBaseName = null, $maxWidth = null, $maxHeight = null, $quality = 82): string
    {
        if (!empty($old_img)) {
            $oldImgPath = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $old_img;
            if (file_exists($oldImgPath)) {
                @unlink($oldImgPath);
            }
        }
        return self::upload_webp($directory, $img, $desiredBaseName, $maxWidth, $maxHeight, $quality);
    }

    /**
     * Converts an uploaded image to .webp (quality 82, preserving PNG transparency)
     * If image is SVG, GIF, or ICO, or if WebP is unsupported, saves with original extension.
     */
    public static function upload_webp($directory, $img, $desiredBaseName = null, $maxWidth = null, $maxHeight = null, $quality = 82): string
    {
        @mkdir($directory, 0775, true);
        $ext = strtolower($img->getClientOriginalExtension());
        $base = $desiredBaseName ?: sha1(time() . rand());

        // SVG, GIF, and ICO are preserved as original vector / animated / icon formats
        if (in_array($ext, ['svg', 'gif', 'ico']) || !function_exists('imagewebp')) {
            $newFileName = $base . '.' . $ext;
            $img->move($directory, $newFileName);
            return $newFileName;
        }

        $sourcePath = $img->getRealPath();
        $newFileName = $base . '.webp';
        $destPath = rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . $newFileName;

        $converted = self::convertToWebp($sourcePath, $destPath, $maxWidth, $maxHeight, $quality);
        if ($converted) {
            return $newFileName;
        }

        // Fallback to original if conversion fails
        $fallbackName = $base . '.' . $ext;
        $img->move($directory, $fallbackName);
        return $fallbackName;
    }

    /**
     * Convert an image file on disk into a compressed WebP file with alpha transparency support.
     */
    public static function convertToWebp(string $sourcePath, string $destPath, ?int $maxWidth = null, ?int $maxHeight = null, int $quality = 82): bool
    {
        if (!function_exists('imagewebp') || !is_file($sourcePath)) {
            return false;
        }

        $data = @file_get_contents($sourcePath);
        if ($data === false) {
            return false;
        }

        $src = @imagecreatefromstring($data);
        if (!$src) {
            return false;
        }

        imagepalettetotruecolor($src);
        imagealphablending($src, true);
        imagesavealpha($src, true);

        $origWidth = imagesx($src);
        $origHeight = imagesy($src);

        if ($maxWidth && $maxHeight && ($origWidth > $maxWidth || $origHeight > $maxHeight)) {
            $ratio = min($maxWidth / $origWidth, $maxHeight / $origHeight);
            $newWidth = (int) max(1, round($origWidth * $ratio));
            $newHeight = (int) max(1, round($origHeight * $ratio));

            $dst = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefilledrectangle($dst, 0, 0, $newWidth, $newHeight, $transparent);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
            @imagedestroy($src);
            $src = $dst;
        }

        $dir = dirname($destPath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $saved = @imagewebp($src, $destPath, $quality);
        @imagedestroy($src);

        return $saved;
    }
}
