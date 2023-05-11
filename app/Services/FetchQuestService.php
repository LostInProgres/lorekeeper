<?php namespace App\Services;

use App\Services\Service;

use DB;
use Notifications;
use Config;
use Settings;
use Auth;

use App\Services\InventoryManager;
use App\Services\CurrencyManager;

use App\Models\Item\Item;
use App\Models\Currency\Currency;

use App\Models\User\User;
use App\Models\User\UserItem;
use App\Models\User\UserCurrency;

class FetchQuestService extends Service
{
    /**
    * Attempts to complete the fetch quest.
    *
    * @param  array                        $data
    * @param  \App\Models\User\User        $user
    * @param  \App\Models\Item\UserItem    $stacks
    * @return bool
    */
    public function completeFetchQuest($data, $user)
    {
        DB::beginTransaction();

        try {

            $fetchItem = Settings::get('fetch_item');

            $rewardqty = Settings::get('fetch_reward');
            $rewardqtymax = Settings::get('fetch_reward_max');
            $currency = Currency::find(Settings::get('fetch_currency_id'));

            $user = Auth::user();
            $stack = UserItem::where([['user_id', $user->id], ['item_id', $fetchItem], ['count', '>', 0]])->first();

            if(!$stack) { throw new \Exception("You don't have the item to complete this quest.");}
    
            if(!(new InventoryManager)->debitStack($user, 'Turned in for Fetch Quest', ['data' => ''], $stack, 1)) { throw new \Exception("Failed to turn in quest.");}

                //successful turnin, so we credit the reward
                //first we randomize it though
                $totalWeight = $rewardqtymax;
                $roll = mt_rand($rewardqty, $totalWeight - 1);
                //credit now after the random shenanigans
                if(!(new CurrencyManager)->creditCurrency(null, $user, 'Fetch Quest Reward', 'Reward for completing fetch quest', $currency, $roll)) throw new \Exception("Failed to credit currency.");   

            return $this->commitReturn(true);
        } catch(\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}