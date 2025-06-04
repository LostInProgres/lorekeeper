<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Arcade\Arcade;
use App\Services\Arcade\GeneralService;
use Auth;
use Illuminate\Http\Request;
use View;

class ArcadeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Arcade Controller
    |--------------------------------------------------------------------------
    |
    | Handles arcades
    |
     */

    /**
     * Shows the shop index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('arcades.index', [
            'arcades' => Arcade::visible()->whereNotNull('data')->orderBy('sort', 'DESC')->get(),
        ]);
    }

    /**
     * Shows an arcade.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getArcade($id)
    {
        $arcade = Arcade::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $arcade) {
            abort(404);
        }

        return view('arcades.arcade', [
            'arcade' => $arcade,
            'user'     => Auth::user(),
        ] + $arcade->service->getActData($arcade));
    }

    /**
     * play arcade
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postPlay(Request $request, $id)
    {
        $arcade = Arcade::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $arcade) {
            abort(404);
        }
        $user    = Auth::user();
        $service = $arcade->service;

        //skip hol and other ajax games bc we already checked
        if (! $arcade->configInfo['ajax']) {
            //handle all the general arcade checks through service so it's not hell
            if ($arcade->generalService->handleChecks($arcade, $user)) {
                // Do nothing because the service will call flash directly
            } else {
                foreach ($arcade->generalService->errors()->getMessages()['error'] as $error) {
                    flash($error)->error();
                }
            }
        }

        if ($service->play($arcade, $request->all(), $user)) {
            // Do nothing because the service will call flash directly
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * get arcade ajax
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjax($id)
    {
        $arcade = Arcade::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $arcade) {
            abort(404);
        }
        $user = Auth::user();

        if (! $arcade->configInfo['ajax'] || ! View::exists('arcades.games.' . $arcade->arcade_type . '_ajax')) {
            abort(404);
        }

        //handle all the general arcade checks through service so it's not hell
        if ($arcade->generalService->handleChecks($arcade, $user)) {
            // Do nothing because the service will call flash directly
        } else {
            foreach ($arcade->generalService->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }
        }

        return view('arcades.games.' . $arcade->arcade_type . '_ajax', [
            'arcade' => $arcade,
            'user'     => $user,
        ] + $arcade->service->getAjaxData($arcade));
    }

    /**
     * post ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAjax(Request $request, $id)
    {
        $arcade = Arcade::where('id', $id)->visible()->whereNotNull('data')->first();
        if (! $arcade) {
            abort(404);
        }
        $user    = Auth::user();
        $service = $arcade->service;

        if ($service->play($arcade, $request->all(), $user)) {
            // Do nothing because the service will call flash directly
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

}
