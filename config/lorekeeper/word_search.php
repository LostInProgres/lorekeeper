<?php

$generic = ['lorekeeper', 'species', 'ARPG', 'community', 'profile', 'collection', 'art',
    'design', 'gallery', 'game', 'role', 'world', 'event', 'character', 'group', 
    'admin', 'player', 'reward', 'trade', 'market', 'currency', 'item', 
    'shop', 'approval', 'creation', 'rarity', 'trait', 'species', 'masterlist',
    'ownership', 'exchange', 'interaction', 'log', 'customization', 'archive'];

$LKcoders = ['Mercury', 'Moif', 'Lostinprogres', 'Supercool', 'Speedy', 'Newt', 'Corowne', 
    'JuniJwi', 'Draginraptor', 'Uri', 'DeePci', 'Ryannicmyk'];

$fantasy = ['magic', 'spell', 'enchantment', 'mystic', 'alchemy', 'arcana', 'mana', 
    'potion', 'wand', 'cauldron', 'supernatural'];

$scifi = ['spaceship', 'alien', 'robot', 'galaxy', 'universe', 'moons', 
    'stars', 'futuristic', 'quantum', 'hologram', 'asteroid', 'blackhole', 'supernova', 
    'biotech', 'simulation', 'colony', 'gravity', 'fusion', 'lightyear', 'satellite', 
    'cosmos', 'future'];
$nature = ['forest', 'river', 'mountain', 'ocean', 'lake', 'valley', 'meadow', 
    'tree', 'flower', 'grass', 'wildlife', 'ecosystem', 'desert', 'waterfall', 
    'stream', 'canyon', 'island', 'coast', 'beach', 'jungle', 'prairie', 'cliff', 
    'rainforest', 'savanna', 'reef', 'volcano', 'tundra', 'sky', 'cloud', 'sun', 
    'moon', 'star', 'breeze', 'storm', 'rain', 'snow', 'hail', 'fog', 'dew', 'soil', 
    'rock', 'sand', 'stone', 'earth', 'wind', 'lightning', 'thunder', 'sunlight', 'shade', 
    'habitat', 'flora'];

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

    //Minimum word list size
    $minsize = 10,

    // Maximum word list size
    //Note that the word list MUST contain at least this amount of unique words.
    $maxsize = 15,

    //word list for word search
    'word_search_words' => array_rand(array_flip(array_merge($generic, $LKcoders, $fantasy, $scifi, $nature)), mt_rand($minsize, $maxsize)),

    //daily plays for word search
    'word_search_plays' => 5,

    //Minimum words that need to be found to be rewarded for a puzzle.
    //Note that empty word searches cannot be submitted regardless.
    //If you do not want a minimum, leave this at 0.
    'found_minimum' => 0,

    //amount to grant PER WORD found
    'currency_grant' => 25,

    //id of currency to grant
    'currency_id' => 1,
];
