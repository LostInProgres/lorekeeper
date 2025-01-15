<?php

namespace App\Http\Controllers;

use Auth;
use Config;

class WordsearchController extends Controller {
    /**********************************************************************************************

     Word Search

    **********************************************************************************************/

    /**
     * Shows the word search index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex() {
        return view('word_search.index', [
            'user'  => Auth::user(),
            'words' => Config::get('lorekeeper.word_search.word_search_words'),
        ]);
    }

    /*
     * Ajax post for word search.
     */
}
