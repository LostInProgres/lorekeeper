<?php

// assuming this will be customisable later on thru the admin panel?

$generic = ['lorekeeper', 'species', 'ARPG', 'community', 'profile', 'collection', 'art', 
    'design', 'gallery', 'game', 'role', 'world', 'event', 
    'character', 'group', 'admin', 'player', 'reward', 'trade', 'market', 'currency', 
    'rank', 'tier', 'item', 'quest', 'shop', 'feedback', 'update', 
    'tracker', 'record', 'approval', 'creation', 'rarity', 'trait', 'species', 'concept', 
    'ownership', 'exchange', 'interaction', 'log', 'network', 'guild', 
    'customization', 'archive'];

$LKcoders = ['mercury', 'moif', 'lostinprogres', 'supercool', 'speedy', 'newt', 'corowne', ];

return [

    /*
    |--------------------------------------------------------------------------
    | Wordsearch Settings
    |--------------------------------------------------------------------------
    |
    | Settings for wordsearch
    | 
    |
    */

    //word list for word search
    'word_search_words' => array_rand(array_flip(array_merge($generic, $LKcoders)), 12),

    //daily plays for word search
    'word_search_plays' => 5, 


    // id let rewards be configurable on the admin panel
    
    //TODO
    //amount to grant when guess is successful
    'currency_grant' => 1,
    
    //TODO
    //id of currency to grant
    'currency_id' => 1,
];