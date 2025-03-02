<?php
namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\Currency\Currency;
use App\Models\Minigame\Minigame;
use App\Services\MinigameService;
use Config;
use Illuminate\Http\Request;
use App\Models\Minigame\MinigameImage;

class MinigameController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin / Minigame Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of minigames.
    |
    */

    /**
     * Shows the minigame index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('admin.minigames.minigames', [
            'minigames' => Minigame::orderBy('sort', 'DESC')->get(),
        ]);
    }

    /**
     * Shows the create minigame page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateMinigame()
    {
        $types  = config('lorekeeper.minigame_types');
        $result = [];
        foreach ($types as $type => $typeData) {
            $result[$type] = $typeData['name'];
        }
        $minigame = new Minigame;

        return view('admin.minigames.create_edit_minigame', [
            'minigame'      => $minigame,
            'types'         => $result,
            'limit_periods' => [null => 'None', 'Hour' => 'Hour', 'Day' => 'Day', 'Week' => 'Week', 'Month' => 'Month', 'Year' => 'Year'],
            'currencies'    => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'flavor'    => $minigame->flavor_data,
        ]);
    }

    /**
     * Shows the edit minigame page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditMinigame($id)
    {
        $minigame = Minigame::find($id);
        if (! $minigame) {
            abort(404);
        }

        $types  = config('lorekeeper.minigame_types');
        $result = [];
        foreach ($types as $type => $typeData) {
            $result[$type] = $typeData['name'];
        }

        return view('admin.minigames.create_edit_minigame', [
            'minigame'      => $minigame,
            'types'         => $result,
            'limit_periods' => [null => 'None', 'Hour' => 'Hour', 'Day' => 'Day', 'Week' => 'Week', 'Month' => 'Month', 'Year' => 'Year'],
            'currencies'    => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'flavor'    => $minigame->flavor_data,
        ] + $minigame->service->getEditData());
    }

    /**
     * Creates or edits a minigame.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\MinigameService  $service
     * @param  int|null                  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditMinigame(Request $request, MinigameService $service, $id = null)
    {
        $id ? $request->validate(Minigame::$updateRules) : $request->validate(Minigame::$createRules);
        $data = $request->only([
            'name', 'description', 'image', 'remove_image', 'is_visible', 'minigame_type',
            'rewardable_type', 'rewardable_id', 'quantity', 'currency_id', 'fee', 'limit', 'limit_period','win_message','lose_message','neutral_message','log_name'
        ]);
        if ($id && $service->updateMinigame(Minigame::find($id), $data)) {
            flash('Minigame updated successfully.')->success();
        } else if (! $id && $minigame = $service->createminigame($data)) {
            flash('Minigame created successfully.')->success();
            return redirect()->to('admin/data/minigames/edit/' . $minigame->id);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * Edits a minigame's type data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\MinigameService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditType(Request $request, MinigameService $service, $id)
    {
        $data = $request->all();
        if ($service->updateType(Minigame::find($id), $data)) {
            flash('Minigame type settings updated successfully.')->success();
            return redirect()->back();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * Gets the minigame deletion modal.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteMinigame($id)
    {
        $minigame = Minigame::find($id);
        return view('admin.minigames._delete_minigame', [
            'minigame' => $minigame,
        ]);
    }

    /**
     * Deletes a minigame.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\MinigameService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteMinigame(Request $request, MinigameService $service, $id)
    {
        if ($id && $service->deleteMinigame(Minigame::find($id))) {
            flash('Minigame deleted successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->to('admin/data/minigames');
    }

    /**
     * Sorts minigames.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\MinigameService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortMinigame(Request $request, MinigameService $service)
    {
        if ($service->sortMinigames($request->get('sort'))) {
            flash('Minigame order updated successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * Edits a minigame's images.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\MinigameService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function posEditMinigameImages(Request $request, MinigameService $service, $id)
    {
        $data     = $request->all();
        $minigame = Minigame::find($id);
        if (! $minigame) {
            abort(404);
        }
        if ($id && $service->updateMinigameImages($minigame, $data)) {
            flash('Images updated successfully.')->success();
        }else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }
}
