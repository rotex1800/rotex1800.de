<?php

use Sinnbeck\DomAssertions\Asserts\AssertElement;
use Tests\TestData\FileContents;

test('/home route is named "home"', function () {
    expect(route('home'))->toEndWith('/home');
});

test('Storage facade')
    ->expect('Illuminate\Support\Facades\Storage')
    ->not->toBeUsedIn('App\Http\Controllers\ContentController');

it('serves markdown file matching the request path', function () {
    Storage::fake('content');
    Storage::disk('content')->put('example.md', FileContents::EXAMPLE);
    Artisan::call('content:refresh');
    $this->get('example')
        ->assertStatus(200)
        ->assertElementExists('h1', function (AssertElement $element) {
            $element->containsText('Rotex 1800');
            $element->doesntContainText('title');
        });;
});
