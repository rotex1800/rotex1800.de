<?php

test('has /home route', function () {
    $response = $this->get('/home');
    $response->assertStatus(200);
});

test('/home route is named "home"', function () {
    expect(route('home'))->toEndWith('/home');
});
