<?php

use App\Livewire\SecondaryMenu;
use Sinnbeck\DomAssertions\Asserts\AssertElement;
use Tests\TestData\FileContents;

test('Storage facade')
    ->expect('Illuminate\Support\Facades\Storage')
    ->not->toBeUsedIn('App\Http\Controllers\ContentController');

it('serves markdown file matching the request path', function () {
    Storage::fake('content');
    Storage::disk('content')->put('example.md', FileContents::EXAMPLE);
    Artisan::call('content:refresh');
    $this->get('/example')
        ->assertStatus(200)
        ->assertElementExists('h1', function (AssertElement $element) {
            $element->containsText('Example');
            $element->doesntContainText('title');
        })
        ->assertSeeLivewire(SecondaryMenu::class);
});

it('serves _index file when accessing the root', function () {
    Storage::fake('content');
    Storage::disk('content')->put('_index.md', FileContents::EXAMPLE);
    Artisan::call('content:refresh');
    $this->get('/')
        ->assertStatus(200)
        ->assertElementExists('h1', function (AssertElement $element) {
            $element->containsText('Example');
            $element->doesntContainText('title');
        });
});

it('serves _index file when accessing a directory', function () {
    Storage::fake('content');
    Storage::disk('content')->put('legal/_index.md', FileContents::EXAMPLE);
    Artisan::call('content:refresh');

    $this->get('/legal/')
        ->assertStatus(200)
        ->assertElementExists('h1', function (AssertElement $element) {
            $element->containsText('Example');
            $element->doesntContainText('title');
        });
});

it('does not crash on missing frontmatter title', function () {
    Storage::fake('content');
    Storage::disk('content')->put('legal/_index.md', FileContents::NO_TITLE);
    Artisan::call('content:refresh');

    $this->get('/legal/')
        ->assertStatus(200)
        ->assertDontSee('<h1>', escape: false);
});
