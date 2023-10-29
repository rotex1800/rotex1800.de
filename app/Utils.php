<?php

namespace App;

class Utils
{

    public static function sanitizePath(string $path): string
    {
        $noMdFileExtension = preg_replace(pattern: '/\\.md$/', replacement: '', subject: $path);
        $noIndex = preg_replace('/_index$/', '', $noMdFileExtension);
        $noStartingSlash = preg_replace('/^\\//', '', $noIndex);

        $sanitized = preg_replace('/\\/$/', '', $noStartingSlash);
        if ($sanitized == '') {
            $sanitized = '/';
        }
        return $sanitized;
    }
}
