<?php

namespace App\Http\Helpers;

class Uploader
{
    public static function upload_picture($directory, $img): string
    {
        $file_name = sha1(time() . rand());
        @mkdir($directory, 0777, true);
        $ext = $img->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        $img->move($directory, $newFileName);
        return $newFileName;
    }

    public static function update_picture($directory, $img, $old_img): string
    {
        $file_name = sha1(time() . rand());
        @mkdir($directory, 0777, true);
        $ext = $img->getClientOriginalExtension();
        $newFileName = $file_name . "." . $ext;
        $oldImgPath = $directory . '/' . $old_img;
        if (file_exists($oldImgPath)) @unlink($oldImgPath);
        $img->move($directory, $newFileName);
        return $newFileName;
    }

    /**
     * Converts an uploaded image to .webp (quality 82, preserving PNG transparency)
     * If image is SVG or GIF, or if WebP is unsupported, saves with original extension.
     */
    public static function upload_webp($directory, $img, $desiredBaseName = null, $maxWidth = null, $maxHeight = null, $quality = 82): string
    {
        @mkdir($directory, 0775, true);
        $ext = strtolower($img->getClientOriginalExtension());
        $base = $desiredBaseName ?: sha1(time() . rand());

        // SVG and GIF are preserved as original vector / animated formats
        if (in_array($ext, ['svg', 'gif']) || !function_exists('imagewebp')) {
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
