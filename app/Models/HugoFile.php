<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;
use Symfony\Component\Yaml\Yaml;

class HugoFile
{
    private const FRONTMATTER = 1;

    private const CONTENT = 2;

    /**
     * @var string[]
     */
    private array $components;

    private function __construct(string $fileContent)
    {
        $this->components = explode('---', $fileContent);
    }

    public static function fromPath(string $path): HugoFile
    {
        $content = Storage::disk('content')->get($path);
        if ($content == null) {
            throw new NoFileException();
        }

        return new HugoFile($content);
    }

    public static function fromContent(string $content): HugoFile
    {
        return new HugoFile($content);
    }

    public function getContent(): string
    {
        return trim($this->components[self::CONTENT]);
    }

    public function getTitle(): string
    {
        return ''.$this->getFrontmatter()['title'];
    }

    /**
     * @return mixed[]
     */
    public function getFrontmatter(): array
    {
        return (array) Yaml::parse($this->components[self::FRONTMATTER]);
    }

    /**
     * @return array<string, string|array<string, string>>
     */
    public function getMenus(): array
    {
        $frontmatter = $this->getFrontmatter();
        if (array_key_exists('menu', $frontmatter)) {
            return (array) $frontmatter['menu'];
        } else {
            return [];
        }
    }
}
