<?php

namespace App\Http\Controllers;

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
        ]);
    }

    /*
     * Ajax post for word search.
     */
    public function postSubmitWordSearch(WordSearchService $service) {
        dd($_GET);
        $data = $_GET['found'];
        if ($service->submitWordSearch($data, Auth::user())) {
            return redirect()->to('word-search');
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }
}
