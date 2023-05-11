<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Item\Item;
use App\Models\User\User;
use App\Models\User\UserItem;
use App\Models\Currency\Currency;

use App\Services\FetchQuestService;
class FetchQuestController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Fetch Quest Controller
    |--------------------------------------------------------------------------
    |
    | Does... things
    |
    */
    
    /**
     * Shows the homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        if(Settings::get('fetch_item')) {
            $item = Item::find(Settings::get('fetch_item'));
        }
        else $fetchItem = null;

        if(Settings::get('fetch_currency_id')) {
            $currency = Currency::find(Settings::get('fetch_currency_id'));
        }
        else $fetchCurrency = null;

        if(Settings::get('fetch_reward')) {
            $fetch_reward = Settings::get('fetch_reward');
        }
        else $fetchCurrency = null;

        if(Settings::get('fetch_reward_max')) {
            $fetch_reward_max = Settings::get('fetch_reward_max');
        }
        else $fetchCurrencymax = null;

        return view('fetchquests.fetch', [
            'fetchItem' => $item,
            'fetchCurrency' => $currency,
            'fetchReward' => $fetch_reward,
            'fetchRewardmax' => $fetch_reward_max
        ]);
    }

    /**
     * Completes a fetch quest
     *
     * @param  integer  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postFetchQuest(Request $request, FetchQuestService $service)
    {
        if($service->completeFetchQuest($request->only(['stack_id', 'stack_quantity']), Auth::user())) {
            flash('Fetch quest handed in succesfully!')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }
}