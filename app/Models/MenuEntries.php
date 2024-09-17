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
        $entries = [];
        $sanitizedPath = Utils::sanitizePath($path);
        $entries = array_merge($entries, self::buildIndexMenuEntries($path, $sanitizedPath, $hugoHelper, $fileContent));
        $entries = array_merge($entries, self::buildFrontmatterMenuEntries($hugoHelper, $path, $sanitizedPath, $fileContent));
        return $entries;
    }

    /**
     * @param string $path
     * @param string $sanitizedPath
     * @param HugoFile $hugoHelper
     * @param string $fileContent
     * @return MenuEntry[]
     */
    private static function buildIndexMenuEntries(string $path, string $sanitizedPath, HugoFile $hugoHelper, string $fileContent): array
    {
        // Create main menu entry for _index.md files
        $entries = [];
        if (str_ends_with($path, '_index.md')) {
            $entries[] = new MenuEntry([
                    'menu' => 'main',
                    'order' => self::determineOrder('main', $path),
                    'path' => $sanitizedPath,
                    'text' => $hugoHelper->getTitle(),
                    'checksum' => md5($fileContent),]
            );
        }
        return $entries;
    }

    /**
     * @param string|array<string> $menu
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
            (is_array($menu) && !array_key_exists('order', $menu))) {
            $order = 0;
        }

        return $order;
    }

    /**
     * @param HugoFile $hugoHelper
     * @param string $path
     * @param string $sanitizedPath
     * @param string $fileContent
     * @return MenuEntry[]
     */
    private static function buildFrontmatterMenuEntries(HugoFile $hugoHelper, string $path, string $sanitizedPath, string $fileContent): array
    {
        $entries = [];
        $frontMatterMenus = $hugoHelper->getMenus();
        foreach ($frontMatterMenus as $menu) {
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
}
