<?php

namespace App\Services;

use App\Models\Currency\Currency;
use Config;
use DB;

class WordSearchService extends Service {
    /**********************************************************************************************

        PLAY WORD SEARCH

     **********************************************************************************************/

    /**
     * submit finished puzzle
     *
     * @param mixed $data
     * @param mixed $user
     *
     * @return bool
     */
    public function submitWordSearch($data, $user) {
        DB::beginTransaction();
        try {
            $wordMinimum = Config::get('lorekeeper.word_search.found_minimum');

            if ($data == "0") {
                throw new \Exception('Cannot submit empty word search');
            } elseif ($data < $wordMinimum) {
                throw new \Exception('Not enough words found to claim reward');
            } else {
                flash('Word search completed! You found '.$data.' word(s).')->success();
                //TODO check if user has plays remaining. 
                // I want the game to be playable without plays for enrichtment,
                // so this check should only prevent rewards from being distributed.
                $this->creditReward($user, $data);
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }

    /**
     * send rewards for the words found
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function creditReward($user, $data) {
        DB::beginTransaction();

        try {
            $reward = Config::get('lorekeeper.word_search.currency_grant');
            $currency = Currency::find(Config::get('lorekeeper.word_search.currency_id'));

            $prize = $reward * $data;

            if (!(new CurrencyManager())->creditCurrency(null, $user, 'Word Search Grant', 'Won at Word search!', $currency, $prize)) {
                flash('Could not grant currency.')->error();

                return redirect()->back();
            }
            flash('You earned '.$currency->display($prize).'!')->success();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }
}