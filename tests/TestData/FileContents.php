<?php

namespace Tests\TestData;

class FileContents
{
    const CALENDAR_FILE = <<<'EOD'
---
slug: /kalender
title: Kalender
menu: [main]
---

[Die Termine können auch abonniert](https://storage.rotex1800.de/remote.php/dav/public-calendars/St4BEmjY2CqQaqHt?export) werden um sie im Kalender auf dem
Smartphone oder Computer zu nutzen.

## Goodbye Wochenende
02\. bis 04. Juni 2023 in Havelberg

## Distriktkonferenz
17\. Juni 2023

## Outboundschulung
30\. Juni bis 02. Juli 2023 in Wolfsburg

## Reboundabend
18\. August 2023 auf Gut Nienfeld

## Jahreshauptversammlung
19\. August 2023 auf Gut Nienfeld

## Gasteltern Information Teil 2
20\. August 2023 auf Gut Nienfeld

## Welcome Wochenende
08\. bis 10. September 2023

## [Rotex DAChKo](https://mailchi.mp/b115dc8c2557/newsletter-vom-5230557#2023)
21\. bis 24. September in Dresden
Ganz viel Liebe zu unseren Rotex-Freund:innen in 1880 💙

## Welcome Camp
25\. bis 30. September 2023 in Magdeburg

## Länder Information
12\. November 2023 in Hannover

## Bewerbungs-Wochenende
24\. bis 26. November 2023 in Magdeburg

## Weihnachts-Wochenende
15\. bis 17. Dezember 2023

## Interne Arbeitstage
27\. bis 29. Dezember 2023

EOD;

    const JHV_POST = <<<'EOD'
---
date: 2014-08-10
title: JHV 2014
menu: [main, events]
categories:
    - Wochenende
---
Wann merkt man, dass schon wieder ein Jahr ins Land gegangen ist? An
Weihnachten? An Neujahr? Am Geburtstag? Nein! Am alljährlichen Reboundabend!

So strömten auch dieses Jahr, am Wochenende vom 5.-7.9.14, Rebounds
(Rotary-Austauschschüler, die ihren Austausch beendet haben) und Rotexer von nah
und fern auf das Gut Nienfeld, wo uns die Familie von Blomberg mit großer
Gastfreundschaft empfing. Nach einer herzlichen Begrüßung von Ekkehard Musick
und den Rotexern war der Reboundabend in vollem Gange. Zudem wurde Rotex1800
durch einen Vertreter des Rotary-Clubs Bückeburg unter großem Applaus eine
großzügige Spende überreicht. Das Wetter zeigte sich wie schon lange nicht mehr
von seiner schönsten Seite, so konnten alle die Köstlichkeiten vom Grill und vom
Mitbringbuffet in strahlendem Sonnenschein auf den großen Wiesen des Gutes
genießen.

Danach kam es zu einer feierlichen Übergabe der Urkunden für den erfolgreich
abgeschlossenen Austausch. Um diesmal nicht nur die Gespräche in der großen
Runde laufen zu lassen, bildeten sich unter der Begleitung der Rotexer mehrere
Kleingruppen, in denen intensiv von den eigenen Erfahrungen berichtet werden
konnte. Der Abend klang dann bei einem gemütlichen Lagerfeuer aus und mit den
letzten Flammen senkte sich auch die Ruhe über den improvisierten Zeltplatz.

![JHV 2014](/img/2014-jhv-gruppenbild.jpg)

Am nächsten Morgen, nach der Abreise der Rebounds, begann schon das nächste
Highlight und zwar die Jahreshauptversammlung der Rotexer. Bis in den frühen
Abend hinein wurde angeregt diskutiert, ausgewertet und geplant, sowie als
krönender Abschluss ein Teil des Vorstands neu gewählt. Für die Anstrengungen
des Tages wurden wir dann mit einem köstlichen Wildschweingulasch, zubereitet
von der Familie von Blomberg, belohnt und auch diesmal war der Abend geprägt von
guten Gesprächen unter Freunden am Lagerfeuer.

Der Sonntag begann für die Rotexer mit Kaffee kochen und Brötchen schmieren,
denn zur Mittagszeit wurden die Gasteltern des aktuellen Austauschjahres
erwartet. Nach einer Begrüßung durch Ekkehard Musick, sowie die Rotexer und
ihren neuen Vorstand, begann eine kleine Information über die Europatour,
gefolgt vom regen Austausch in Ländergruppen. So konnten die Gasteltern
länderspezifische Fragen stellen und auf die Unterstützung anderer Gasteltern
sowie auch der Rotexer setzen. Viele Gasteltern hatten auch ihre neuen Gastsöhne
und Gasttöchter mitgebracht, sodass sich einige Inbounds zum ersten Mal treffen
und austauschen konnten.

So ging ein erfülltes, intensives und produktives Wochenende zu Ende und
Rotex1800 bedankt sich herzlich bei allen, die uns das letzte Jahr begleitet und
gefördert haben. Für das kommende Jahr hoffen wir auf weitere gute
Zusammenarbeit und wünschen unserem neuen Vorstand, sowie den Gasteltern und
Inbounds ein erfolgreiches, erlebnisreiches und unvergessliches Jahr 2014/2015!
EOD;

    const EXAMPLE = <<<'EOD'
---
title: Example
date: 2014-08-10
menu: test
---
# Hello Rotex 1800

This is a markdown file read from disk!
EOD;

    const EXAMPLE_CHANGED_TITLE = <<<'EOD'
---
title: Second Example
date: 2014-08-10
menu: test
---
# Hello Rotex 1800

This is a markdown file read from disk!
EOD;

    const NO_TITLE_NO_MENU = <<<'EOD'
---
date: 2014-08-10
---
This file has no title
EOD;

    const INDEX_PAGE = <<<'EOD'
---
title: Index page
menu:
    -   name: main
        order: 10
    -   name: posts
---
This is an index page.
EOD;

    const MAIN_MENU_AND_POSTS_MENU = <<<'EOD'
---
menu:
    -   name: main
        order: 10
    -   name: posts
title: Posts
---

# Test heading
EOD;
}
