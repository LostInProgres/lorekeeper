<?php

namespace App\Http\Controllers;

use App\Models\Currency\Currency;
use Illuminate\Http\Request;
use App\Services\gamenameService;
use Auth;
use Config;

class gamenameController extends Controller {
    /**********************************************************************************************

     Word Search

    **********************************************************************************************/

    /**
     * Shows the game name index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex() {
        return view('gamename.index', [
            'user'  => Auth::user(),
        ]);
    }

    /*
     * Ajax post for game name.
     */
    public function postSubmitgamename(Request $request, gamenameService $service) {
        if ($service->submitgamename($request->get('count'), Auth::user())) {
            return redirect()->to('word-search');
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }
}