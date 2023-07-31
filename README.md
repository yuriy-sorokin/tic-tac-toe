# Tic Tac Toe

## Installation
```bash
php ./composer.phar install
```

## Game start
```bash
php bin/app.php
```

## Customization
By default, there are four classic cell combinations to win: horizontal, vertical and diagonal (left up, right down + left down, right up).

There is also a bonus combination added, which wins the game as well:
```bash
| X |   | X |
-------------
|   |   |   |
-------------
|   | X |   |
```
You can add any winning combinations to ``GameStateConstraint`` in ``bin/app.php`` as same as customizing the playing field/board size when the game starts.

Winning combinations have relative coordinates and are not linked with the actual playing field coordinates directly.

There playing field can be, say, 10x10 but still the winning coordinates should be put in the smallest rectangle possible.

The following winning combination
```bash
|   |   | X |
-------------
|   | X |   |
-------------
| X |   |   |
-------------
|   | X |   |
-------------
|   |   | X |
```
should be described as (x, y):
```bash
new CoordinateCollection(
    new Coordinate(3, 1),
    new Coordinate(2, 2),
    new Coordinate(1, 3),
    new Coordinate(2, 4),
    new Coordinate(3, 5),
)
```
which will make it work in any position within the actual playing field:
```bash
|   |   |   |   |   |   |
-------------------------
|   |   |   |   |   |   |
-------------------------
|   |   |   | X |   |   |
-------------------------
|   |   | X |   |   |   |
-------------------------
|   | X |   |   |   |   |
-------------------------
|   |   | X |   |   |   |
-------------------------
|   |   |   | X |   |   |
-------------------------
|   |   |   |   |   |   |
```
or
```bash
|   |   |   |   |   | X |   |   |
---------------------------------
|   |   |   |   | X |   |   |   |
---------------------------------
|   |   |   | X |   |   |   |   |
---------------------------------
|   |   |   |   | X |   |   |   |
---------------------------------
|   |   |   |   |   | X |   |   |
---------------------------------
|   |   |   |   |   |   |   |   |
```
