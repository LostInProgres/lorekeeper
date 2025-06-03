<?php

namespace App\Services\Arcade;

use App\Models\Arcade\ArcadeLog;
use App\Services\Service;
use DB;
use Auth;

class HolService extends Service
{

    /**
     * Retrieves any data that should be used in the arcade type editing form on the admin side
     *
     * @return array
     */
    public function getEditData()
    {

        return [

        ];
    }

    /**
     * Retrieves any data that should be used in the arcade type on the user side
     *
     * @return array
     */
    public function getActData($arcade)
    {
        return [
        ];
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
     * Retrieves any data that should be used in the arcade type on the user side (ajax)
     *
     * @return array
     */
    public function getAjaxData($arcade)
    {
        return [
            'number' => mt_rand(2, 12),
        ];
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
        if (!isset($data['known_min']) || !isset($data['known_max']) || !isset($data['unknown_min']) || !isset($data['unknown_max'])) {
            throw new \Exception("You must set the guessable numbers.");
        }

        return [
            'known_min' => $data['known_min'],
            'known_max' => $data['known_max'],
            'unknown_min' => $data['unknown_min'],
            'unknown_max' => $data['unknown_max'],
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

            if (!isset($data['guess'])) {
                throw new \Exception('You must make a guess.');
            }

            $number = $data['number'];

            //roll second number
            //hopefully this prevents a tie occuring between the 2 numbers
            $secondnumber = mt_rand(1, 13);
            while ($secondnumber == $number) {
                $secondnumber = mt_rand(1, 13);
            }

            $guess = $data['guess'];
            if ($guess == 'higher') {
                //if $number is bigger than $secondnumber & user selected higher
                if ($number > $secondnumber) {
                    flash('Nice try, but the second number was ' . $secondnumber . '...')->error();
                } elseif ($number < $secondnumber) {
                    //if $number is smaller than $secondnumber & user selected higher
                    flash('You were right! ' . $secondnumber . ' is larger than ' . $number . '.')->success();
                    $this->creditReward($arcade, $user);

                }
            } else {
                //if $number is smaller than $secondnumber & user selected smaller
                if ($number > $secondnumber) {
                    flash('You were right! ' . $secondnumber . ' is smaller than ' . $number . '.')->success();
                    $this->creditReward($arcade, $user);

                } elseif ($number < $secondnumber) {
                    flash('Nice try, but the second number was ' . $secondnumber . '...')->error();
                }
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * make guess
     *
     * @return bool
     */
    public function creditReward($arcade, $user)
    {
        DB::beginTransaction();

        try {
            $arcade->generalService->grantRewards($arcade, $user);
            $arcade->generalService->updateLog($arcade, $user);

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}
