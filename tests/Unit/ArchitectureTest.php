<?php

test('variants of dump')
    ->expect(['dump', 'dd'])
    ->not->toBeUsed();

test('ray calls')
    ->expect(['ray'])
    ->not->toBeUsed();
