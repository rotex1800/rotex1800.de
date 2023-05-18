<?php

test('has /home route', function () {
    $response = $this->get('/home');
    $response->assertStatus(200);
});

test('/home route is named "home"', function () {
    expect(route('home'))->toEndWith('/home');
});

it('contains "Rotex 1800" in headline', function () {
    $this->get(route('home'))
        ->assertElementExists('h1', function (\Sinnbeck\DomAssertions\Asserts\AssertElement $element) {
            $element->containsText('Rotex 1800');
        });
});
