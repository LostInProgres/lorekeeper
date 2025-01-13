<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\HolService;
use Auth;
use Illuminate\Http\Request;

class HolController extends Controller
{
    /**********************************************************************************************

    HIGHER OR LOWER

     **********************************************************************************************/

    /**
     * Shows the hol index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('hol.index', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * play hol
     *
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function playHol(HolService $service)
    {
        $user = Auth::user();

        if ($user->settings->hol_plays < 1) {
            flash('You can\'t play higher or lower more today.')->error();
            return redirect()->back();
        }

        $user->settings->hol_plays -= 1;
        $user->settings->save();

        //roll numba
        $number = mt_rand(2, 12);

        return view('hol.play', [
            'number' => $number,
        ]);
    }

    /**
     * make a guess.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  App\Services\HolService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postGuess(Request $request, HolService $service)
    {
        $data = $request->only(['guess', 'number']);
        if ($service->makeGuess($data, Auth::user())) {
            return redirect()->to('higher-or-lower');
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }
        return redirect()->back();
    }

}
