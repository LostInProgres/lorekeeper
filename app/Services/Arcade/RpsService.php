<?php
namespace App\Services\Arcade;

use App\Services\Service;
use DB;

class RpsService extends Service
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
        $gameData  = $arcade->data;
        $options   = $arcade->service->rpsOptions($arcade);
        $allimages = true;
        foreach ($options as $key => $name) {
            if (! $arcade->customImageExists($key)) {
                $allimages = false;
            }
        }

        return [
            'options'   => $options,
            'use_7'     => $gameData['use_7'],
            'allimages' => $allimages,
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
        if (! isset($data['use_7'])) {
            $data['use_7'] = 0;
        }

        if (! isset($data['rock_name']) || ! isset($data['paper_name']) || ! isset($data['scissors_name'])) {
            throw new \Exception("All RPS options must be named.");
        }
        if ($data['use_7'] == 1) {
            if (! isset($data['sponge_name']) || ! isset($data['fire_name']) || ! isset($data['air_name']) || ! isset($data['water_name'])) {
                throw new \Exception("All RPS-7 options must be named if RPS-7 is enabled.");
            }
        }

        return [
            'rock_name'     => $data['rock_name'],
            'paper_name'    => $data['paper_name'],
            'scissors_name' => $data['scissors_name'],
            'use_7'         => $data['use_7'],
            'sponge_name'   => $data['sponge_name'],
            'fire_name'     => $data['fire_name'],
            'air_name'      => $data['air_name'],
            'water_name'    => $data['water_name'],
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

            if (! $data['option']) {
                throw new \Exception('No option selected');
            }

            $options = $arcade->service->rpsOptions($arcade);

            //this. is probably an extremely clunky way to do it but i'm not if elseifing for every single combination lmao.

            switch ($data['option']) {
                case 'rock':
                    $wins   = ['scissors', 'fire', 'sponge'];
                    $losses = ['paper', 'air', 'water'];
                    break;
                case 'paper':
                    $wins   = ['rock', 'air', 'paper'];
                    $losses = ['scissors', 'fire', 'sponge'];
                    break;
                case 'scissors':
                    $wins   = ['paper', 'air', 'sponge'];
                    $losses = ['fire', 'water', 'rock'];
                    break;
                case 'sponge':
                    $wins   = ['paper', 'air', 'water'];
                    $losses = ['rock', 'fire', 'scissors'];
                    break;
                case 'fire':
                    $wins   = ['scissors', 'paper', 'sponge'];
                    $losses = ['rock', 'air', 'water'];
                    break;
                case 'air':
                    $wins   = ['fire', 'rock', 'water'];
                    $losses = ['paper', 'scissors', 'sponge'];
                    break;
                case 'water':
                    $wins   = ['rock', 'fire', 'scissors'];
                    $losses = ['sponge', 'air', 'paper'];
                    break;
            }

            $cpu = array_rand($options, 1);

            //win
            if (in_array($cpu, $wins)) {
                flash('The battle was valiant, and in the end, your ' . $data['option'] . ' triumphed over your opponent\'s ' . $cpu . '.')->success();

                $arcade->generalService->grantRewards($arcade, $user);
                $arcade->generalService->updateLog($arcade, $user);
            } elseif (in_array($cpu, $losses)) {
                flash('Your opponent counters your ' . $data['option'] . ' with ' . $cpu . '!! Unfortunate...')->error();

                if (isset($arcade->flavor_data['lose_message'])) {
                    flash($arcade->flavor_data['lose_message'])->error();
                }
            } else {
                flash('Alas, ' . $data['option'] . ' and ' . $cpu . ' lead to an anticlimatic tie...');
                if (isset($arcade->flavor_data['neutral_message'])) {
                    flash($arcade->flavor_data['neutral_message']);
                }
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Processes the data attribute of the arcade and returns it in the preferred format.
     *
     * @param  string  $tag
     * @return mixed
     */
    public function rpsOptions($arcade)
    {
        $gameData = $arcade->data;

        if(isset($gameData)) {
            $options = ['rock' => $gameData['rock_name'], 'paper' => $gameData['paper_name'], 'scissors' => $gameData['scissors_name']];
            if ($gameData['use_7']) {
                $options = $options + ['sponge' => $gameData['sponge_name'], 'fire' => $gameData['fire_name'], 'air' => $gameData['air_name'], 'water' => $gameData['water_name']];
            }
        } else {
            $options = ['rock' => 'rock', 'paper' => 'paper', 'scissors' => 'scissors'];
        }

        return $options;
    }

}
