<?php
namespace App\Services\Arcade;

use App\Services\Service;
use DB;

class BubblepopService extends Service
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
    { //this is placeholder data for now because the data cannot be null

        return [
            'bubble_colour_amount'          => $data['bubble_colour_amount'],
            'turn_speed'                    => $data['turn_speed'],
            'cluster_size'                  => $data['cluster_size'],
            'points_per_pop'                => $data['points_per_pop'],
            'game_columns'                  => $data['game_columns'],
            'game_rows'                     => $data['game_rows'],
            'bubble_size'                   => $data['bubble_size'],
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

            if ($data['count'] == "0") {
                throw new \Exception('Cannot submit an unfinished sudoku.');
            } else {
                $arcade->generalService->calculateRewards($arcade, $user, $data['count']);
                $arcade->generalService->updateLog($arcade, $user);
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}