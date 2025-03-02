<?php
namespace App\Services\Minigame;

use App\Services\Service;
use DB;

class SudokuService extends Service
{

    /**
     * Retrieves any data that should be used in the minigame type editing form on the admin side
     *
     * @return array
     */
    public function getEditData()
    {


        return [
        ];
    }

    /**
     * Retrieves any data that should be used in the minigame type on the user side
     *
     * @return array
     */
    public function getActData($minigame)
    {
        return [
        ];
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

        return [
        ];
    }

    /**
     * Processes the data attribute of the minigame and returns it in the preferred format.
     *
     * @param  object  $minigame
     * @param  array   $data
     * @return bool
     */
    public function updateData($minigame, $data)
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
    public function play($minigame, $data, $user)
    {
        DB::beginTransaction();

        try {

            $gameData = $minigame->data;

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
                    $minigame->generalService->grantRewards($minigame, $user);
                }
            } elseif ($data['count'] == $data['word_count']) {
                $minigame->generalService->grantRewards($minigame, $user);
            }
            $minigame->generalService->updateLog($minigame, $user);

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}
