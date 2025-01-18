<?php

namespace App\Services;

use App\Models\Currency\Currency;
use Config;
use DB;

class SudokuService extends Service {
    /**********************************************************************************************

        PLAY Sudoku

     **********************************************************************************************/

    /**
     * submit finished puzzle
     *
     * @param mixed $data
     * @param mixed $user
     *
     * @return bool
     */
    public function submitSudoku($data, $user) {
        DB::beginTransaction();
        try {
            if ($data == "0") {
                throw new \Exception('No score found.');
            } else {
                flash('Sudoku completed!')->success();
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
            $prize = Config::get('lorekeeper.Sudoku.currency_grant');
            $currency =  Currency::find(Config::get('lorekeeper.Sudoku.currency_id'));

            if (!(new CurrencyManager())->creditCurrency(null, $user, 'Sudoku Grant', 'Won at Sudoku!', $currency, $prize)) {
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