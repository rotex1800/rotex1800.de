<?php

use App\Utils;

it('sanitizes path', function (string $from, string $to) {
    expect(Utils::sanitizePath($from))
        ->toBe($to);
})->with([
    ['/posts/über-uns.md', 'posts/über-uns'],
    ['/posts/_index.md', 'posts'],
    ['_index.md', '/'],
]);
