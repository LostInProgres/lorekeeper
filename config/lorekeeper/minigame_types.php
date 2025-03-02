<?php

/*
    |--------------------------------------------------------------------------
    | Minigame Types
    |--------------------------------------------------------------------------
    |
    | This is a list of minigames that can be played on the site.
    | Add types here to make them selectable in the admin panel.
    | The key must be unique, but names do not have to be.
    |
    */

return [
    'hol'        => [
        'name'           => 'Higher or Lower',
        'require_reward' => true,
        'ajax'           => true,
    ],

    'luckypull'  => [
        'name'           => 'Lucky Pull',
        'require_reward' => false,
        'ajax'           => false,
    ],

    'gtn'        => [
        'name'           => 'Guess The Number',
        'require_reward' => true,
        'ajax'           => false,
    ],
    'wordsearch' => [
        'name'           => 'Word Search',
        'require_reward' => true,
        'ajax'           => true,
    ],

    'rps'        => [
        'name'           => 'Rock, Paper, Scissors',
        'require_reward' => true,
        'ajax'           => false,
    ],
    'sudoku' => [
        'name'           => 'Sudoku',
        'require_reward' => true,
        'ajax'           => true,
    ],
    'well' => [
        'name'           => 'Wishing Well',
        'require_reward' => true,
        'ajax'           => false,
    ],
    'race' => [
        'name'           => 'Race',
        'require_reward' => true,
        'ajax'           => true,
    ],

];
