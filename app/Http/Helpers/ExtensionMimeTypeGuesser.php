<?php

namespace App\Http\Helpers;

use Symfony\Component\Mime\MimeTypeGuesserInterface;

/**
 * Fallback MIME type guesser based on magic bytes, getimagesize, $_FILES, and file extension.
 * Used when php_fileinfo extension is not available on the server.
 * Registered in AppServiceProvider::register() and boot().
 */
class ExtensionMimeTypeGuesser implements MimeTypeGuesserInterface
{
    private static array $map = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'gif'  => 'image/gif',
        'webp' => 'image/webp',
        'svg'  => 'image/svg+xml',
        'bmp'  => 'image/bmp',
        'ico'  => 'image/x-icon',
        'pdf'  => 'application/pdf',
        'zip'  => 'application/zip',
        'mp4'  => 'video/mp4',
        'mp3'  => 'audio/mpeg',
        'txt'  => 'text/plain',
        'csv'  => 'text/csv',
        'json' => 'application/json',
    ];

    public function isGuesserSupported(): bool
    {
        return true;
    }

    public function guessMimeType(string $path): ?string
    {
        if (!is_file($path) || !is_readable($path)) {
            return null;
        }

        // 1. Try PHP core getimagesize (available with GD)
        if (function_exists('getimagesize')) {
            $size = @getimagesize($path);
            if (!empty($size['mime'])) {
                return $size['mime'];
            }
        }

        // 2. Try magic bytes
        $handle = @fopen($path, 'rb');
        if ($handle) {
            $bytes = fread($handle, 16);
            fclose($handle);
            if ($bytes !== false && strlen($bytes) >= 2) {
                if (str_starts_with($bytes, "\xFF\xD8\xFF")) {
                    return 'image/jpeg';
                }
                if (str_starts_with($bytes, "\x89PNG\r\n\x1a\n")) {
                    return 'image/png';
                }
                if (str_starts_with($bytes, 'GIF87a') || str_starts_with($bytes, 'GIF89a')) {
                    return 'image/gif';
                }
                if (str_starts_with($bytes, 'RIFF') && substr($bytes, 8, 4) === 'WEBP') {
                    return 'image/webp';
                }
                if (str_starts_with($bytes, 'BM')) {
                    return 'image/bmp';
                }
                if (str_starts_with($bytes, '%PDF')) {
                    return 'application/pdf';
                }
                if (str_starts_with($bytes, "PK\x03\x04")) {
                    return 'application/zip';
                }
            }
        }

        // 3. Try SVG detection
        $head = @file_get_contents($path, false, null, 0, 512);
        if ($head && (stripos($head, '<svg') !== false || (stripos($head, '<?xml') !== false && stripos($head, '<svg') !== false))) {
            return 'image/svg+xml';
        }

        // 4. Try matching with $_FILES (for uploaded temporary files like /tmp/phpXXXXXX)
        if (!empty($_FILES)) {
            foreach ($_FILES as $file) {
                if (is_array($file) && isset($file['tmp_name'])) {
                    if (is_string($file['tmp_name']) && $file['tmp_name'] === $path) {
                        if (!empty($file['type'])) {
                            return $file['type'];
                        }
                        if (!empty($file['name'])) {
                            $origExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                            if (!empty($origExt) && isset(self::$map[$origExt])) {
                                return self::$map[$origExt];
                            }
                        }
                    } elseif (is_array($file['tmp_name'])) {
                        foreach ($file['tmp_name'] as $idx => $tmpName) {
                            if ($tmpName === $path) {
                                if (!empty($file['type'][$idx])) {
                                    return $file['type'][$idx];
                                }
                                if (!empty($file['name'][$idx])) {
                                    $origExt = strtolower(pathinfo($file['name'][$idx], PATHINFO_EXTENSION));
                                    if (!empty($origExt) && isset(self::$map[$origExt])) {
                                        return self::$map[$origExt];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // 5. Try file extension from path
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!empty($ext) && isset(self::$map[$ext])) {
            return self::$map[$ext];
        }

        // 6. Safe image fallback for temporary uploaded files
        return 'image/jpeg';
    }
}
