# Checkers

Author: Bas de Ruiter

License: MIT

## Design considerations

In deze assessment wil ik graag laten zien hoe ik een applicatie opbouw. Om deze reden heb ik het "geöverengineerd".
Het dambord is een canvas javascript app dat via een api met de php backend praat. In het backend valideren we de zetten en reageren met een tegenzet van de AI.
Omwille van de tijd zal deze AI gewoon een random zet kiezen uit de lijst met toegestane zetten.

## Assets

Ik gebruik Laravel Mix (wat weer een wrapper is om webpack) om mijn sass en js assets te compilen en te comprimeren.

## Setup

1. Download de source code
1. Zorg dat php 8 draait, of gebruik een VM of Docker.
1. run `composer install`   
1. run `php artisan serve`
1. Open [http://127.0.0.1:8000](http://127.0.0.1:8000)

> De gecompilede assets vind je al terug in de source code, dus npm dependencies hoeven niet geinstalleerd te worden.
