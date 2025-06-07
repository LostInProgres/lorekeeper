<?php

namespace App\Http\Controllers;

use App\Models\Currency\Currency;
use Illuminate\Http\Request;
use App\Services\bubblepopService;
use Auth;
use Config;

class bubblepopController extends Controller {
    /**********************************************************************************************

     Word Search

    **********************************************************************************************/

    /**
     * Shows the game name index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex() {
        return view('bubblepop.index', [
            'user'  => Auth::user(),
        ]);
    }

    /*
     * Ajax post for game name.
     */
    public function postSubmitbubblepop(Request $request, bubblepopService $service) {
        if ($service->submitbubblepop($request->get('count'), Auth::user())) {
            return redirect()->to('word-search');
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return redirect()->back();
    }
}