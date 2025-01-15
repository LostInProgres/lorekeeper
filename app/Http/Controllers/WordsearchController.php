<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Config;
use Illuminate\Http\Request;

class WordSearchController extends Controller
{
    /**********************************************************************************************

     Word Search

    **********************************************************************************************/

    /**
     * Shows the word search index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('word_search.index', [
            'user' => Auth::user(),
            'words' => Config::get('lorekeeper.word_search.word_search_words')
        ]);
    }

    /**
     * Ajax post for word search.
     */
}
