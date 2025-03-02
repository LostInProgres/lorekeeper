<?php
namespace App\Services\Minigame;

use App\Models\Currency\Currency;
use App\Models\Minigame\MinigameLog;
use App\Services\CurrencyManager;
use App\Services\Service;
use Auth;
use DB;

class LuckypullService extends Service
{
    /**
     * Retrieves any data that should be used in the minigame type editing form on the admin side
     *
     * @return array
     */
    public function getEditData()
    {
        return [];
    }

    /**
     * Retrieves any data that should be used in the minigame type on the user side
     *
     * @return array
     */
    public function getActData($minigame)
    {
        return [];
    }

    /**
     * Processes the data attribute of the minigame and returns it in the preferred format.
     *
     * @param  string  $tag
     * @return mixed
     */
    public function getData($data)
    {
        return $data;
    }

    /**
     * Retrieves any data that should be used in the minigame type on the user side
     *
     * @return array
     */
    public function getAjaxData($minigame)
    {
        return [];
    }

    /**
     * Processes the data attribute of the minigame and returns it in the preferred format.
     *
     * @param  object  $minigame
     * @param  array   $data
     * @return bool
     */
    public function updateData($minigame, $data)
    {
        if(!isset($data['use_pool'])) $data['use_pool'] = 0;
        if(!isset($data['use_increment'])) $data['use_increment'] = 0;
        if ($data['use_pool']) {
            if (!isset($minigame->currency_id) || !isset($minigame->fee)) {
                throw new \Exception('You cannot use a pool if the game has no fee.');
            }
            if (!isset($data['base_pool'])) {
                throw new \Exception('You must set a base pool.');
            }
        }elseif (!isset($minigame->output)) {
            throw new \Exception('If you\'re not using a currency pool, then you must include other rewards.');
        }

        if (!isset($data['base_odds'])) {
            throw new \Exception('You must set base odds.');
        }

        if ($data['use_increment']) {
            if (!isset($data['increment_amount'])) {
                throw new \Exception('You must set an increment.');
            }
        }

        //set variable data if not set
        if (!$minigame->variable_data) {
            $minigame->variable_data = [
                'current_odds' => $data['base_odds'],
                'current_pool' => $data['use_pool'] ? $data['base_pool'] : null,
            ];
            $minigame->save();
        }

        return [
            'use_pool' => $data['use_pool'],
            'max_pool' => $data['max_pool'],
            'base_pool' => $data['base_pool'],
            'base_odds' => $data['base_odds'],
            'use_increment' => $data['use_increment'],
            'increment_amount' => $data['increment_amount'],
            'increment_cap' => $data['increment_cap'],
        ];
    }

    /**
     * Acts upon the item when used from the inventory.
     *
     * @param  \App\Models\User\UserItem  $stacks
     * @param  \App\Models\User\User      $user
     * @param  array                      $data
     * @return bool
     */
    public function play($minigame, $data, $user)
    {
        DB::beginTransaction();

        try {

            $gameData = $minigame->data;
            $paramData = $minigame->variable_data;

            //roll to see if the user wins!
            //for this we're just going to say that any match of 100 = win
            $use_increment = $gameData['use_increment'];
            $use_pool = $gameData['use_pool'];
            $increment = $use_increment ? $gameData['base_odds'] + $paramData['current_odds'] : $gameData['base_odds'];

            //add the increments/win chance
            $roll = mt_rand(1, 100) + $increment;

            //winnar
            if ($roll >= 100) {
                flash('You lucked out this time!');
                // Credit rewards
                if ($minigame->output) {
                    $minigame->generalService->grantRewards($minigame, $user);
                }

                if ($use_pool) {
                    if (!(new CurrencyManager())->creditCurrency(null, $user, 'Lucky Pull Reward', 'Lucky pull reward ( ' . $minigame->displayName . ')', $minigame->currency, $paramData['current_pool'])) {
                        throw new \Exception('Failed to award currency pool.');
                    }
                    flash('You earned ' . $minigame->currency->display($paramData['current_pool']) . '.')->success();
                }
                $minigame->generalService->updateLog($minigame, $user);
                $odds = $gameData['base_odds'];
                $pool = $gameData['base_pool'] + $minigame->fee;
            } else {
                flash("Looks like you'll need to try again...");
                //losar
                if ($use_increment) {
                    $odds = $paramData['current_odds'] + $gameData['increment_amount'];

                    //check for cap
                    if (isset($gameData['increment_cap']) && $odds > $gameData['increment_cap']) {
                        $odds = $gameData['increment_cap'];
                    }
                } else {
                    $odds = $gameData['base_odds'];
                }

                if ($use_pool) {
                    $pool = $paramData['current_pool'] + $minigame->fee;

                    //check for cap
                    if (isset($gameData['max_pool']) && $pool > $gameData['max_pool']) {
                        $pool = $gameData['max_pool'];
                    }
                } else {
                    $pool = null;
                }
            }

            $minigame->variable_data = [
                'current_odds' => $odds,
                'current_pool' => $pool,
            ];
            $minigame->save();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
