<?php

namespace App\Models;

use App\Utils;
use Illuminate\Support\Facades\Storage;

class MenuEntries
{
    /**
     * @return MenuEntry[]
     */
    public static function fromFile(string $path): array
    {
        $fileContent = Storage::disk('content')->get($path);
        if ($fileContent == null) {
            return [];
        }

        $hugoHelper = HugoFile::fromContent($fileContent);
        $menus = $hugoHelper->getMenus();
        $entries = [];
        $sanitizedPath = Utils::sanitizePath($path);

        foreach ($menus as $menu) {
            $entries[] = new MenuEntry([
                'path' => $sanitizedPath,
                'menu' => $menu,
                'order' => 1,
                'text' => $hugoHelper->getTitle(),
                'checksum' => md5($fileContent),
            ]);
        }

        return $entries;
    }
}
