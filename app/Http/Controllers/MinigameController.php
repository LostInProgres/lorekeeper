<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Minigame\Minigame;
use App\Services\Minigame\GeneralService;
use Auth;
use Illuminate\Http\Request;
use View;

class MinigameController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Minigame Controller
    |--------------------------------------------------------------------------
    |
    | Handles minigames
    |
     */

    /**
     * Shows the shop index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('minigames.index', [
            'minigames' => Minigame::visible()->whereNotNull('data')->orderBy('sort', 'DESC')->get(),
        ]);
    }

    /**
     * Shows an minigame.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getMinigame($id)
    {
        $minigame = Minigame::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $minigame) {
            abort(404);
        }

        return view('minigames.minigame', [
            'minigame' => $minigame,
            'user'     => Auth::user(),
        ] + $minigame->service->getActData($minigame));
    }

    /**
     * play minigame
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPlay(Request $request, $id)
    {
        $minigame = Minigame::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $minigame) {
            abort(404);
        }
        $user    = Auth::user();
        $service = $minigame->service;

        //skip hol and other ajax games bc we already checked
        if (! $minigame->configInfo['ajax']) {
            //handle all the general minigame checks through service so it's not hell
            if ($minigame->generalService->handleChecks($minigame, $user)) {
                // Do nothing because the service will call flash directly
            } else {
                foreach ($minigame->generalService->errors()->getMessages()['error'] as $error) {
                    flash($error)->error();
                }
            }
        }

        if ($service->play($minigame, $request->all(), $user)) {
            // Do nothing because the service will call flash directly
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * get minigame ajax
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjax($id)
    {
        $minigame = Minigame::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $minigame) {
            abort(404);
        }
        $user = Auth::user();

        if (! $minigame->configInfo['ajax'] || ! View::exists('minigames.games.' . $minigame->minigame_type . '_ajax')) {
            abort(404);
        }

        //handle all the general minigame checks through service so it's not hell
        if ($minigame->generalService->handleChecks($minigame, $user)) {
            // Do nothing because the service will call flash directly
        } else {
            foreach ($minigame->generalService->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return view('minigames.games.' . $minigame->minigame_type . '_ajax', [
            'minigame' => $minigame,
            'user'     => $user,
        ] + $minigame->service->getAjaxData($minigame));
    }

    /**
     * post ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAjax(Request $request, $id)
    {
        $minigame = Minigame::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $minigame) {
            abort(404);
        }
        $user    = Auth::user();
        $service = $minigame->service;

        if ($service->play($minigame, $request->all(), $user)) {
            // Do nothing because the service will call flash directly
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * get minigame ajax
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjaxInfo(Request $request, $id)
    {
        $minigame = Minigame::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $minigame) {
            return response(404);
        }
        $user = Auth::user();

        if (!$minigame->configInfo['ajax']) {
            return response(404);
        }

        if ($minigame->minigame_type == 'sudoku') {
            if ($minigame->customImageExists('number_' . $request['num'])) {
                return $minigame->customImageUrl('number_' . $request['num']);
            }
            return null;
        }
    }

}
