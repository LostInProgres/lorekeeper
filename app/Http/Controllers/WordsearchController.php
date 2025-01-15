<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Config;
use Illuminate\Http\Request;

class WordsearchController extends Controller
{
    /**********************************************************************************************

     Wordsearch

     **********************************************************************************************/

    /**
     * Shows the wordsearch index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('wordsearch.index', [
            'user' => Auth::user(),
            'words' => Config::get('lorekeeper.wordsearch.wordsearch_words')
        ]);
    }
}
