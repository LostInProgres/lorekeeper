<?php

/*
    |--------------------------------------------------------------------------
    | Arcade Types
    |--------------------------------------------------------------------------
    |
    | This is a list of games that can be played on the site.
    | Add types here to make them selectable in the admin panel.
    | The key must be unique, but names do not have to be.
    |

    if you have a game you would like to add here, feel free to PR it for others to use!

    just make sure to include credits and such <3

    */

return [

    'hol'        => [
        'name'           => 'Higher or Lower',
        'require_reward' => true,
        'ajax'           => true,
        'creators'       => [
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
    ],

    'luckypull'  => [
        'name'           => 'Lucky Pull',
        'require_reward' => false,
        'ajax'           => false,
        'creators'       => [
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
    ],

    'gtn'        => [
        'name'           => 'Guess The Number',
        'require_reward' => true,
        'ajax'           => false,
        'creators'       => [
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
    ],
    'wordsearch' => [
        'name'           => 'Word Search',
        'require_reward' => true,
        'ajax'           => true,
        'creators'       => [
            'Bunkat (Original code)'       => 'https://github.com/bunkat',
            'LostInProgres (Edits for LK)' => 'https://github.com/LostInProgres',
        ],
    ],

    'rps'        => [
        'name'           => 'Rock, Paper, Scissors',
        'require_reward' => true,
        'ajax'           => false,
        'creators'       => [
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
    ],
    'sudoku'     => [
        'name'           => 'Sudoku',
        'require_reward' => true,
        'ajax'           => true,
        'creators'       => [
            'Cristian Canea (Original code)' => 'https://codepen.io/cristiancanea',
            'LostInProgres (Edits for LK)'   => 'https://github.com/LostInProgres',
            'SpeedyD'                  => 'https://github.com/SpeedyD',
        ],
    ],
    'well'       => [
        'name'           => 'Wishing Well',
        'require_reward' => true,
        'ajax'           => false,
        'creators'       => [
            '8BitBaker (Original idea/code)' => 'https://toyhou.se/8BitBaker/',
            'CH3RVB (Edits for Arcade)'      => 'https://github.com/CH3RVB',
        ],
    ],
    'race'       => [
        'name'           => 'Race',
        'require_reward' => true,
        'ajax'           => true,
        'creators'       => [
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
    ],

];
