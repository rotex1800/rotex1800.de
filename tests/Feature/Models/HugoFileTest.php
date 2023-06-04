<?php

use App\Models\HugoFile;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

beforeEach(function () {

    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
unknown-key: and-value
menu: main
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!
EOD;

    Storage::fake('content');
    Storage::disk('content')->put('example/path.md', $fileContent);

    $this->cut = HugoFile::fromPath('example/path.md');
});

it('can return content section of a hugo markdown file', function () {
    expect($this->cut->getContent())
        ->toBe('Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!');
});

it('can return frontmatter section of a hugo markdown file', function () {
    expect($this->cut->getFrontmatter())
        ->toBeArray()
        ->toHaveKeys(['date', 'title', 'unknown-key']);
});

it('has method to access title', function () {
    expect($this->cut->getTitle())
        ->toBe('JHV 2014');
});

it('has method to access menu section of frontmatter', function () {
    expect($this->cut->getMenus())
        ->toBeArray()
        ->toHaveLength(1)
        ->toContain('main');
});

it('returns array if multiple menus are defined', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
menu:
  - primary
  - secondary
---
Foo bar baz.
EOD;
    $cut = HugoFile::fromContent($fileContent);

    expect($cut->getMenus())
        ->toBeArray()
        ->toContain('primary', 'secondary');
});

it('returns empty array if no menu is defined', function () {
    $fileContent = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
---
Foo bar baz.
EOD;
    $cut = HugoFile::fromContent($fileContent);

    expect($cut->getMenus())
        ->toBeArray()
        ->toBeEmpty();
});

it('throws exception if given path is null', function () {
    HugoFile::fromPath('non/existent/path.md');
})->throws(NoFileException::class);


it('can return title', function () {
    $content = <<<'EOD'
---
title: Rotex 1800 e.V.
menu: main
---

# Willkommen
Hallo! Wir sind der Rotex 1800 e.V., ein Zusammenschluss ehemaliger
Teilnehmer:innen des Rotary-Youth-Exchange-Programs.

Erfahren Sie mehr über die Aufgaben des Vereins, unsere Aktivitäten und, was
unseren Verein so besonders macht.

EOD;

    $file = HugoFile::fromContent($content);
    expect($file)
        ->getTitle()->not->toBeNull()
    ->toBe('Rotex 1800 e.V.');
});
