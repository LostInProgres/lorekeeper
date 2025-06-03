<?php
namespace App\Services\Arcade;

use App\Models\Arcade\ArcadeLog;
use App\Services\Service;
use Auth;
use DB;

class GtnService extends Service
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
            'min' => $arcade->data['min'],
            'max' => $arcade->data['max'],
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
     * Retrieves any data that should be used in the arcade type on the user side
     *
     * @return array
     */
    public function getAjaxData($arcade)
    {
        return [
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
        if (! isset($data['min']) || ! isset($data['max'])) {
            throw new \Exception("You must set the guessable numbers.");
        }

        return [
            'min' => $data['min'],
            'max' => $data['max'],
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

            if (! isset($data['guess'])) {
                throw new \Exception('You must make a guess.');
            }

            $gameData = $arcade->data;

            //roll
            $num = mt_rand($gameData['min'], $gameData['max']);
            if ($data['guess'] == $num) {

                flash("A perfect guess! You picked the exact number! ")->success();

                $arcade->generalService->grantRewards($arcade, $user);

                $arcade->generalService->updateLog($arcade, $user);

            } else {
                flash('Nice try, but the number was ' . $num . '...')->error();
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}
