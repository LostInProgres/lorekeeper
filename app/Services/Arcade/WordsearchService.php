<?php
namespace App\Services\Arcade;

use App\Services\Service;
use DB;

class WordsearchService extends Service
{

    /**
     * Retrieves any data that should be used in the arcade type editing form on the admin side
     *
     * @return array
     */
    public function getEditData()
    {
        $presets = config('lorekeeper.wordsearch');
        $result  = [];
        foreach ($presets as $preset => $presetData) {
            $result[$preset] = $presetData['name'];
        }

        return [
            'presets' => ['all' => 'All (Random words from all other sets)'] + $result,
        ];
    }

    /**
     * Retrieves any data that should be used in the arcade type on the user side
     *
     * @return array
     */
    public function getActData($arcade)
    {
        $gameData = $arcade->data;
        return [
            'wordMinimum'    => $gameData['submit_min'],
            'award_per_word' => $gameData['award_per_word'],
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
        $gameData = $arcade->data;
        $words    = explode(', ', $gameData['words']);
        $rand     = mt_rand($gameData['word_min'], $gameData['word_max']);
        $arr      = array_flip($words);
        //failsafe if not enough words, shrink to the max amount
        if (sizeof($arr) < $rand) {
            $rand = sizeof($arr);
        }
        $words = array_rand($arr, $rand);

        return [
            'words'          => $words,
            'wordMinimum'    => $gameData['submit_min'],
            'award_per_word' => $gameData['award_per_word'],
            'word_count'     => $rand,
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
        if (! isset($data['award_per_word'])) {
            $data['award_per_word'] = 0;
        }

        if (! isset($data['word_min']) || ! isset($data['word_max'])) {
            throw new \Exception("You must set a word min and max.");
        }

        if (isset($data['submit_min']) && $data['submit_min'] > $data['word_max']) {
            throw new \Exception("You can't set a minimum required word amount greater than the max word amount.");
        }

        if (isset($data['preset'])) {

            if ($data['preset'] == 'all') {

                $list = [];
                foreach (config('lorekeeper.wordsearch') as $set) {
                    $list[] = $set['words'];
                }
                //we're trimming down the list here because... yeah. at time of writing there are about 900 words total in the default list......
                $data['words'] = implode(', ', array_rand(array_flip(array_merge(...$list)), $data['word_max'] + 30));

            } else {
                $preset        = config('lorekeeper.wordsearch.' . $data['preset']);
                $data['words'] = implode(', ', $preset['words']);
            }
        } elseif (! isset($data['words'])) {
            throw new \Exception("You must set a word list.");
        }

        return [
            'word_min'       => $data['word_min'],
            'word_max'       => $data['word_max'],
            'words'          => $data['words'],
            'submit_min'     => ! $data['award_per_word'] ? null : $data['submit_min'],
            'award_per_word' => $data['award_per_word'],
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
