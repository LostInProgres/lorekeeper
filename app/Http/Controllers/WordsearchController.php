<?php

namespace App\Http\Controllers;

use App\Models\Currency\Currency;
use Illuminate\Http\Request;
use App\Services\WordSearchService;
use Auth;
use Config;

class WordSearchController extends Controller {
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
            'prize' => Config::get('lorekeeper.word_search.currency_grant'),
            'currency' => Currency::find(Config::get('lorekeeper.word_search.currency_id')),
            'wordMinimum' => Config::get('lorekeeper.word_search.found_minimum')
        ]);
    }

    /*
     * Ajax post for word search.
     */
    public function postSubmitWordSearch(Request $request, WordSearchService $service) {
        if ($service->submitWordSearch($request->get('count'), Auth::user())) {
            return redirect()->to('word-search');
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }
}
