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
            if (!isset($data['found'])) {
                throw new \Exception('Cannot submit empty word search');
            } else {
                flash('Word search completed! You found '.$data['found'].'words.')->success();
                $this->creditReward($user);
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
    public function creditReward($user) {
        DB::beginTransaction();

        try {
            //TODO make the reward multiply per word found, and potentially add a bonus for finding all words.
            $currency = Currency::find(Config::get('lorekeeper.word_search.currency_id'));
            $grant = Config::get('lorekeeper.word_search.currency_grant');
            if (!(new CurrencyManager())->creditCurrency(null, $user, 'Word Search Grant', 'Won at Word search!', $currency, $grant)) {
                flash('Could not grant currency.')->error();

                return redirect()->back();
            }
            flash('You earned '.$currency->display($grant).'!')->success();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }

        return $this->rollbackReturn(false);
    }
}