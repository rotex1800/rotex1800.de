<?php

use Tests\TestData\FileContents;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

test('has /home route', function () {
    $response = $this->get('/home');
    $response->assertStatus(200);
});

test('/home route is named "home"', function () {
    expect(route('home'))->toEndWith('/home');
});

it('serves markdown file matching the request path', function () {
    Storage::fake('content');
    Storage::disk('content')->put('example.md', FileContents::EXAMPLE);
    $this->get('example')
        ->assertStatus(200)
        ->assertElementExists('h1', function (AssertElement $element) {
            $element->containsText('Rotex 1800');
            $element->doesntContainText('title');
        });;
});

it('serves markdown file matching the request path from nested folder', function () {
    Storage::fake('content');
    Storage::disk('content')->put('nested/example.md', FileContents::EXAMPLE);
    $this->get('nested/example')
        ->assertStatus(200)
        ->assertElementExists('h1', function (AssertElement $element) {
            $element->containsText('Rotex 1800');
            $element->doesntContainText('title');
        });;
});
