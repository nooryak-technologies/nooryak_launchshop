<?php

if (!defined('FILEINFO_NONE')) {
    define('FILEINFO_NONE', 0);
}
if (!defined('FILEINFO_MIME_TYPE')) {
    define('FILEINFO_MIME_TYPE', 16);
}

if (!class_exists('finfo', false)) {
    class finfo
    {
        public function __construct($flags = 0, $magic_file = null)
        {
        }

        public function file($filename, $flags = 0, $context = null)
        {
            if (class_exists(\App\Http\Helpers\ExtensionMimeTypeGuesser::class)) {
                $guesser = new \App\Http\Helpers\ExtensionMimeTypeGuesser();
                $mime = $guesser->guessMimeType($filename);
                if ($mime) {
                    return $mime;
                }
            }
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $map = [
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
            return $map[$ext] ?? 'application/octet-stream';
        }

        public function buffer($string, $flags = 0, $context = null)
        {
            if (function_exists('getimagesizefromstring')) {
                $size = @getimagesizefromstring($string);
                if (!empty($size['mime'])) {
                    return $size['mime'];
                }
            }
            if (is_string($string) && strlen($string) >= 4) {
                if (str_starts_with($string, "\xFF\xD8\xFF")) {
                    return 'image/jpeg';
                }
                if (str_starts_with($string, "\x89PNG\r\n\x1a\n")) {
                    return 'image/png';
                }
                if (str_starts_with($string, "GIF87a") || str_starts_with($string, "GIF89a")) {
                    return 'image/gif';
                }
                if (str_starts_with($string, "RIFF") && substr($string, 8, 4) === 'WEBP') {
                    return 'image/webp';
                }
                if (str_starts_with(trim($string), "<svg") || str_contains(substr($string, 0, 200), "<svg")) {
                    return 'image/svg+xml';
                }
            }
            return 'application/octet-stream';
        }
    }
}

if (!function_exists('finfo_open')) {
    function finfo_open($flags = 0, $magic_file = null)
    {
        return new \finfo($flags, $magic_file);
    }
}

if (!function_exists('finfo_file')) {
    function finfo_file($finfo, $filename)
    {
        return ($finfo instanceof \finfo) ? $finfo->file($filename) : 'application/octet-stream';
    }
}

if (!function_exists('finfo_buffer')) {
    function finfo_buffer($finfo, $string)
    {
        return ($finfo instanceof \finfo) ? $finfo->buffer($string) : 'application/octet-stream';
    }
}

if (!function_exists('finfo_close')) {
    function finfo_close($finfo)
    {
        return true;
    }
}

