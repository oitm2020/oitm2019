<?php

class Sudoku {
    // Ezt az osztályt kell implementálnod
}

/**
 * Ez alapján a példa alapján próbáld meg felépíteni a megoldásod
 */
$sudoku_challenge = [
    [0, 0, 4, 0, 9, 0, 0, 0, 0],
    [0, 6, 1, 0, 0, 0, 0, 0, 0],
    [0, 0, 2, 0, 0, 0, 0, 5, 0],
    [1, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 3, 0, 0, 0, 0, 0, 0],
    [2, 0, 0, 1, 0, 3, 4, 0, 0],
    [3, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 9, 0, 4, 0, 0, 0],
];

$sudoku = new Sudoku($sudoku_challenge);
// az eredménynek ugyanolyan tömb-formátumban kell, hogy legyen, mint amilyen a bemenet volt
$result = $sudoku->solve();
