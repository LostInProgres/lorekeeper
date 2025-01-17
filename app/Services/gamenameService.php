<?php

namespace App\Services;

use App\Models\Currency\Currency;
use Config;
use DB;

class gamenameService extends Service {
    /**********************************************************************************************

        PLAY GAME NAME

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

            if ($data == "0") {
                throw new \Exception('No score found');
            } else {
                flash('GAME NAME completed! Total score: '.$data)->success();
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
            $prize = //PRIZE AMOUNT
            $currency = //CURRENCY ID

            if (!(new CurrencyManager())->creditCurrency(null, $user, 'GAME NAME Grant', 'Won at GAME NAME!', $currency, $prize)) {
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