<?php
namespace App\Services\Minigame;

use App\Models\Currency\Currency;
use App\Models\Minigame\MinigameLog;
use App\Services\CurrencyManager;
use App\Services\Service;
use Auth;
use DB;

class GeneralService extends Service
{

    /**
     * Complete the general first checks associated with playing a minigame
     *
     * @param  \App\Models\User\UserItem  $stacks
     * @param  \App\Models\User\User      $user
     * @param  array                      $data
     * @return bool
     */
    public function handleChecks($minigame, $user)
    {
        DB::beginTransaction();

        try {
            //first let's check the limit
            if ($minigame->limit) {
                if (! $minigame->checkLimit($minigame, $user)) {
                    throw new \Exception("You have already completed this minigame the maximum number of times.");
                }
            }

            if ($minigame->currency && isset($minigame->fee)) {
                if (! (new CurrencyManager())->debitCurrency($user, null, 'Lucky Pull Fee', 'Lucky pull fee ( ' . $minigame->displayName . ')', $minigame->currency, $minigame->fee)) {
                    throw new \Exception('Not enough currency to play this minigame.');
                }
            }

            $log = MinigameLog::create([
                'minigame_id' => $minigame->id,
                'user_id'     => Auth::user()->id,
            ]);

            if(!$log){
                throw new \Exception('Failed to create minigame log.');
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Update a minigame log if the user won
     */
    public function updateLog($minigame, $user)
    {
        DB::beginTransaction();

        try {
            MinigameLog::played($minigame->id, $user->id)->orderBy('created_at', 'DESC')->first()->update(['won' => 1]);
            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

     /**
     * Update a minigame log if the user won
     */
    public function grantRewards($minigame, $user)
    {
        DB::beginTransaction();

        try {
            $gameName = isset($minigame->flavor_data['log_name']) ? $minigame->flavor_data['log_name'] : $minigame->configInfo['name'];
            if (
                !($rewards = fillUserAssets($minigame->rewardItems, null, $user, $gameName.' Reward', [
                    'data' => $gameName.' reward: ' . $minigame->displayName,
                ]))
            ) {
                throw new \Exception('Failed to distribute rewards to user.');
            }
            flash('You have received: ' . createRewardsString($rewards));

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
