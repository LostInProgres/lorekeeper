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
        'name'           => 'Higher or Lower', // Game name, can have spaces
        'require_reward' => true,       //If set to true the game MUST have a reward attached
        'ajax'           => true,       //If set to true the game have an ajax. AJAX games have slightly different files, as well as confirmation before playing.
        'scored'         => false,     //If set to true the game rewards rewards based on the total score reached.
        'creators'       => [
            //All people who have contributed to the game.
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
        //The rules of the game. This displays over the ? tooltip.
        'rules'          => '<p>You will be given a number, you must guess whether you think it will be <strong>higher</strong> or <strong>lower</strong> than a second, randomly generated number that you cannot see. </p>',
    ],

    'luckypull'  => [
        'name'           => 'Lucky Pull',
        'require_reward' => false,
        'ajax'           => false,
        'scored'         => false,
        'creators'       => [
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
    ],

    'gtn'        => [
        'name'           => 'Guess The Number',
        'require_reward' => true,
        'ajax'           => false,
        'scored'         => false,
        'creators'       => [
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
    ],
    'wordsearch' => [
        'name'           => 'Word Search',
        'require_reward' => true,
        'ajax'           => true,
        'scored'         => false,
        'creators'       => [
            'Bunkat (Original code)'       => 'https://github.com/bunkat',
            'LostInProgres (Edits for LK)' => 'https://github.com/LostInProgres',
        ],
        'rules'          => '<p>The objective of this puzzle is to find and mark all the words hidden inside the box. The words may be placed horizontally, vertically, or diagonally, and can be backwards too. </p>
        <p>Click and drag starting at the word\'s first letter, and ending at the last, to select a correct word. If the page is failing to recognize your input, try to slow down your movement and drag in a more straight line.</p>',
    ],

    'rps'        => [
        'name'           => 'Rock, Paper, Scissors',
        'require_reward' => true,
        'ajax'           => false,
        'scored'         => false,
        'creators'       => [
            'CH3RVB' => 'https://github.com/CH3RVB',
        ],
        'rules'          => '<p>Standard RPS rules. If noted, then <a href="https://www.umop.com/rps7.htm">RPS-7</a> may also be enabled. Note that the names of the symbols to select may be different compared to default if the site has decided to rename them.</p>',
    ],
    'sudoku'     => [
        'name'           => 'Sudoku',
        'require_reward' => true,
        'ajax'           => true,
        'scored'         => false,
        'creators'       => [
            'Cristian Canea (Original code)' => 'https://codepen.io/cristiancanea',
            'LostInProgres (Edits for LK)'   => 'https://github.com/LostInProgres',
            'SpeedyD'                        => 'https://github.com/SpeedyD',
        ],
        'rules'          => '<p>Standard sudoku rules. <a href="https://www.learn-sudoku.com/sudoku-rules.html">This page</a> has a good amount of info on sudoku.</p>',
    ],
    'well'       => [
        'name'           => 'Wishing Well',
        'require_reward' => true,
        'ajax'           => false,
        'scored'         => false,
        'creators'       => [
            '8BitBaker (Original idea/code)' => 'https://toyhou.se/8BitBaker/',
            'CH3RVB (Edits for Arcade)'      => 'https://github.com/CH3RVB',
        ],
    ],
    'blockfall'       => [
        'name'           => 'BlockFall',
        'require_reward' => false,
        'ajax'           => true,
        'scored'         => true,
        'creators'       => [
            'LostInProgres'      => 'https://github.com/LostInProgres',
        ],
    ],
    'twentyfourtyeight'       => [
        'name'           => 'twentyfourtyeight',
        'require_reward' => false,
        'ajax'           => true,
        'scored'         => true,
        'creators'       => [
            'Antoine Neff (Original code)'      => 'https://codepen.io/antoineneff',
            'Lostinprogres (Edits for LK)'      => 'https://github.com/LostInProgres',
        ],
    ],
];
