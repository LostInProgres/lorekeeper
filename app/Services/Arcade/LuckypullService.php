<?php
namespace App\Services\Arcade;

use App\Models\Currency\Currency;
use App\Models\Arcade\ArcadeLog;
use App\Services\CurrencyManager;
use App\Services\Service;
use Auth;
use DB;

class LuckypullService extends Service
{
    /**
     * Retrieves any data that should be used in the arcade type editing form on the admin side
     *
     * @return array
     */
    public function getEditData()
    {
        return [];
    }

    /**
     * Retrieves any data that should be used in the arcade type on the user side
     *
     * @return array
     */
    public function getActData($arcade)
    {
        return [];
    }

    /**
     * Processes the data attribute of the arcade and returns it in the preferred format.
     *
     * @param  string  $tag
     * @return mixed
     */
    public function getData($data)
    {
        return $data;
    }

    /**
     * Retrieves any data that should be used in the arcade type on the user side
     *
     * @return array
     */
    public function getAjaxData($arcade)
    {
        return [];
    }

    /**
     * Processes the data attribute of the arcade and returns it in the preferred format.
     *
     * @param  object  $arcade
     * @param  array   $data
     * @return bool
     */
    public function updateData($arcade, $data)
    {
        if(!isset($data['use_pool'])) $data['use_pool'] = 0;
        if(!isset($data['use_increment'])) $data['use_increment'] = 0;
        if ($data['use_pool']) {
            if (!isset($arcade->currency_id) || !isset($arcade->fee)) {
                throw new \Exception('You cannot use a pool if the game has no fee.');
            }
            if (!isset($data['base_pool'])) {
                throw new \Exception('You must set a base pool.');
            }
        }elseif (!isset($arcade->output)) {
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
        if (!$arcade->variable_data) {
            $arcade->variable_data = [
                'current_odds' => $data['base_odds'],
                'current_pool' => $data['use_pool'] ? $data['base_pool'] : null,
            ];
            $arcade->save();
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
    public function play($arcade, $data, $user)
    {
        DB::beginTransaction();

        try {

            $gameData = $arcade->data;
            $paramData = $arcade->variable_data;

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
                if ($arcade->output) {
                    $arcade->generalService->grantRewards($arcade, $user);
                }

                if ($use_pool) {
                    if (!(new CurrencyManager())->creditCurrency(null, $user, 'Lucky Pull Reward', 'Lucky pull reward ( ' . $arcade->displayName . ')', $arcade->currency, $paramData['current_pool'])) {
                        throw new \Exception('Failed to award currency pool.');
                    }
                    flash('You earned ' . $arcade->currency->display($paramData['current_pool']) . '.')->success();
                }
                $arcade->generalService->updateLog($arcade, $user);
                $odds = $gameData['base_odds'];
                $pool = $gameData['base_pool'] + $arcade->fee;
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
                    $pool = $paramData['current_pool'] + $arcade->fee;

                    //check for cap
                    if (isset($gameData['max_pool']) && $pool > $gameData['max_pool']) {
                        $pool = $gameData['max_pool'];
                    }
                } else {
                    $pool = null;
                }
            }

            $arcade->variable_data = [
                'current_odds' => $odds,
                'current_pool' => $pool,
            ];
            $arcade->save();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
