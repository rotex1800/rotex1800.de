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
            $name = $menu;
            if (is_array($menu)) {
                $name = $menu['name'];
            }
            $entries[] = new MenuEntry([
                'menu' => $name,
                'order' => self::determineOrder($menu, $path),
                'path' => $sanitizedPath,
                'text' => $hugoHelper->getTitle(),
                'checksum' => md5($fileContent),
            ]);
        }

        return $entries;
    }

    /**
     * @param  string|array<string>  $menu
     */
    private static function determineOrder(string|array $menu, string $path): ?int
    {
        $order = null;
        if (is_array($menu) && array_key_exists('order', $menu)) {
            $order = intval($menu['order']);
        }

        if (
            (str_ends_with($path, '_index.md') && is_string($menu))
            ||
            (is_array($menu) && ! array_key_exists('order', $menu))) {
            $order = 0;
        }

        return $order;
    }
}
