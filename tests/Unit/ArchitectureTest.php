<?php

test('globals')
    ->expect(['dump', 'dd'])
    ->not->toBeUsed();
