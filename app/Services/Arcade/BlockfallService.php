<?php
namespace App\Services\Arcade;

use App\Services\Service;
use DB;

class BlockfallService extends Service
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
            'steward_colour'                        => $data['steward_colour'],
            'arnold_colour'                         => $data['arnold_colour'],
            'freddy_colour'                         => $data['freddy_colour'],
            'gerald_colour'                         => $data['gerald_colour'],
            'evil_gerald_colour'                    => $data['evil_gerald_colour'],
            'vanessa_colour'                        => $data['vanessa_colour'],
            'amber_colour'                          => $data['amber_colour'],
            'board_outline_width'                   => $data['board_outline_width'],
            'board_outline_colour'                  => $data['board_outline_colour'],
            'board_colour'                          => $data['board_colour'],
            'container_colour'                      => $data['container_colour'],
            'container_outline_width'               => $data['container_outline_width'],
            'container_outline_colour'          	=> $data['container_outline_colour'],
            'score_colour'                          => $data['score_colour'],
            'score_text_colour'                     => $data['score_text_colour'],
            'next_colour'                           => $data['next_colour'],
            'next_outline_width'                    => $data['next_outline_width'],
            'next_outline_colour'          	        => $data['next_outline_colour'],

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
                throw new \Exception('Cannot submit an unfinished game.');
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

