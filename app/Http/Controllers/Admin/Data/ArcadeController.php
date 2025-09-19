<?php
namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\Currency\Currency;
use App\Models\Arcade\Arcade;
use App\Services\ArcadeService;
use Config;
use Illuminate\Http\Request;
use App\Models\Arcade\ArcadeImage;

class ArcadeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin / Arcade Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of arcades.
    |
    */

    /**
     * Shows the arcade index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('admin.arcades.arcades', [
            'arcades' => Arcade::orderBy('sort', 'DESC')->get(),
        ]);
    }

    /**
     * Shows the create arcade page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateArcade()
    {
        $types  = config('lorekeeper.arcade_types');
        $result = [];
        foreach ($types as $type => $typeData) {
            $result[$type] = $typeData['name'];
        }
        $arcade = new Arcade;

        return view('admin.arcades.create_edit_arcade', [
            'arcade'      => $arcade,
            'types'         => $result,
            'limit_periods' => [null => 'None', 'Hour' => 'Hour', 'Day' => 'Day', 'Week' => 'Week', 'Month' => 'Month', 'Year' => 'Year'],
            'currencies'    => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'flavor'    => $arcade->flavor_data,
        ]);
    }

    /**
     * Shows the edit arcade page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditArcade($id)
    {
        $arcade = Arcade::find($id);
        if (! $arcade) {
            abort(404);
        }

        $types  = config('lorekeeper.arcade_types');
        $result = [];
        foreach ($types as $type => $typeData) {
            $result[$type] = $typeData['name'];
        }

        return view('admin.arcades.create_edit_arcade', [
            'arcade'      => $arcade,
            'types'         => $result,
            'limit_periods' => [null => 'None', 'Hour' => 'Hour', 'Day' => 'Day', 'Week' => 'Week', 'Month' => 'Month', 'Year' => 'Year'],
            'currencies'    => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'flavor'    => $arcade->flavor_data,
        ] + $arcade->service->getEditData());
    }

    /**
     * Creates or edits a arcade.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\ArcadeService  $service
     * @param  int|null                  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditArcade(Request $request, ArcadeService $service, $id = null)
    {
        $id ? $request->validate(Arcade::$updateRules) : $request->validate(Arcade::$createRules);
        $data = $request->only([
            'name', 'description', 'image', 'remove_image', 'is_visible', 'arcade_type',
            'rewardable_type', 'rewardable_id', 'quantity', 'currency_id', 'fee', 'limit', 'limit_period','win_message','lose_message','neutral_message','log_name','currency_cap'
        ]);
        if ($id && $service->updateArcade(Arcade::find($id), $data)) {
            flash('Arcade updated successfully.')->success();
        } else if (! $id && $arcade = $service->createarcade($data)) {
            flash('Arcade created successfully.')->success();
            return redirect()->to('admin/data/arcade/edit/' . $arcade->id);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * Edits a arcade's type data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\ArcadeService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditType(Request $request, ArcadeService $service, $id)
    {
        $data = $request->all();
        if ($service->updateType(Arcade::find($id), $data)) {
            flash('Arcade type settings updated successfully.')->success();
            return redirect()->back();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * Gets the arcade deletion modal.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteArcade($id)
    {
        $arcade = Arcade::find($id);
        return view('admin.arcades._delete_arcade', [
            'arcade' => $arcade,
        ]);
    }

    /**
     * Deletes a arcade.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\ArcadeService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteArcade(Request $request, ArcadeService $service, $id)
    {
        if ($id && $service->deleteArcade(Arcade::find($id))) {
            flash('Arcade deleted successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->to('admin/data/arcade');
    }

    /**
     * Sorts arcades.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\ArcadeService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortArcade(Request $request, ArcadeService $service)
    {
        if ($service->sortArcades($request->get('sort'))) {
            flash('Arcade order updated successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }

    /**
     * Edits a arcade's images.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\ArcadeService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function posEditArcadeImages(Request $request, ArcadeService $service, $id)
    {
        $data     = $request->all();
        $arcade = Arcade::find($id);
        if (! $arcade) {
            abort(404);
        }
        if ($id && $service->updateArcadeImages($arcade, $data)) {
            flash('Images updated successfully.')->success();
        }else {
            foreach ($service->errors()->getMessages()['error'] as $error) {
                flash($error)->error();
            }

        }
        return redirect()->back();
    }
}
