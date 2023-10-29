<?php

namespace App;

class Utils
{
    public static function sanitizePath(string $path): string
    {
        $noMdFileExtension = (string) preg_replace(pattern: '/\\.md$/', replacement: '', subject: $path);
        $noIndex = (string) preg_replace('/_index$/', '', $noMdFileExtension);
        $noStartingSlash = (string) preg_replace('/^\\//', '', $noIndex);

        $sanitized = (string) preg_replace('/\\/$/', '', $noStartingSlash);
        if ($sanitized == '') {
            $sanitized = '/';
        }

        return $sanitized;
    }
}
