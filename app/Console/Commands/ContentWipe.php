<?php

namespace App\Console\Commands;

use App\Models\Link;
use App\Models\MenuEntry;
use App\Models\Post;
use Illuminate\Console\Command;

class ContentWipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:wipe {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all content from the database.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (!$this->option('force')) {
            $this->choice('Do you really want to delete all content?', ['no', 'yes']);
        }

        Link::truncate();
        Post::truncate();
        MenuEntry::truncate();
    }
}
