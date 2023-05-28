<?php

namespace App\Console\Commands;

use App\Models\Post;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ContentRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $markdownFiles = $this->findMarkdownFiles();
        $this->deleteOutdatedPosts($markdownFiles);
        $this->createPostEntries($markdownFiles);
    }

    /**
     * @return array<string>
     */
    private
    function findMarkdownFiles(): array
    {
        $files = Storage::disk('content')->files(recursive: true);
        return array_filter($files, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) == 'md';
        });
    }

    /**
     * @param array<string> $markdownFiles
     * @return void
     */
    private function deleteOutdatedPosts(array $markdownFiles): void
    {
        $hashes = array_map(function ($file) {
            $path = Storage::disk('content')->path($file);
            return md5_file($path);
        }, $markdownFiles);
        Post::whereNotIn('checksum', $hashes)->delete();
    }

    /**
     * @param array<string> $files
     * @return void
     */
    private function createPostEntries(array $files): void
    {
        array_map(function ($file) {
            try {
                $fileContent = Storage::disk('content')->get($file);
                if ($fileContent == null) {
                    return;
                }
                $post = Post::fromHugo($fileContent);
                $post->save();
            } catch (Exception $exception) {
                ray($exception);
            }
        }, $files);
    }
}
