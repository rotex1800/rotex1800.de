<?php

namespace Tests\Console;

use Illuminate\Support\Facades\Artisan;

test('Correctly imports the commands', function () {
    $all = Artisan::all();
    expect($all["content:wipe"])
        ->not->toBeNull()
        ->and($all["content:refresh"])
        ->not->toBeNull();
});
