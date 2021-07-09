# Checkers

Author: Bas de Ruiter

## Design considerations

In deze assessment wil ik graag laten zien hoe ik een applicatie opbouw. Om deze reden heb ik het "geöverengineerd".
Het dambord is een canvas javascript app dat via een api met de php backend praat. In het backend valideren we de zetten en reageren met een tegenzet van de AI.
Omwille van de tijd zal deze AI gewoon een random zet kiezen uit de lijst met mogelijkheden.

## Assets

Ik gebruik Laravel Mix (wat weer een wrapper is om webpack) om mijn sass en js assets te compilen en te comprimeren.
