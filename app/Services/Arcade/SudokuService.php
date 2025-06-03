<?php
namespace App\Services\Arcade;

use App\Services\Service;
use DB;

class SudokuService extends Service
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
    {//this is placeholder data for now because the data cannot be null

        return [
            'word_min'       => $data['word_min'],
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
                throw new \Exception('Cannot submit empty word search');
            } elseif ($data['count'] < $gameData['submit_min']) {
                throw new \Exception('Not enough words found to claim reward');
            } elseif (! $gameData['award_per_word'] && $data['count'] != $data['word_count']) {
                throw new \Exception('Cannot claim rewards on an incomplete word search.');
            }

            if ($gameData['award_per_word']) {
                flash('Word search completed! You found ' . $data['count'] . ' word(s).')->success();
                //TODO condense the reward string so it doesn't flash like 4 reward boxes and just one that has qty x4
                for ($i = 0; $i < $data['count']; $i++) {
                    $arcade->generalService->grantRewards($arcade, $user);
                }
            } elseif ($data['count'] == $data['word_count']) {
                $arcade->generalService->grantRewards($arcade, $user);
            }
            $arcade->generalService->updateLog($arcade, $user);

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}
