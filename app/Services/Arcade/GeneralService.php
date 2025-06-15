<?php
namespace App\Services\Arcade;

use App\Models\Arcade\ArcadeLog;
use App\Models\Currency\Currency;
use App\Services\CurrencyManager;
use App\Services\Service;
use Auth;
use DB;

class GeneralService extends Service
{

    /**
     * Complete the general first checks associated with playing a arcade
     *
     * @param  \App\Models\User\UserItem  $stacks
     * @param  \App\Models\User\User      $user
     * @param  array                      $data
     * @return bool
     */
    public function handleChecks($arcade, $user)
    {
        DB::beginTransaction();

        try {
            //first let's check the limit
            if ($arcade->limit) {
                if (! $arcade->checkLimit($arcade, $user)) {
                    throw new \Exception("You have already completed this game the maximum number of times.");
                }
            }

            if ($arcade->currency && isset($arcade->fee)) {
                if (! (new CurrencyManager())->debitCurrency($user, null, 'Lucky Pull Fee', 'Lucky pull fee ( ' . $arcade->displayName . ')', $arcade->currency, $arcade->fee)) {
                    throw new \Exception('Not enough currency to play this game.');
                }
            }

            $log = ArcadeLog::create([
                'arcade_id' => $arcade->id,
                'user_id'   => Auth::user()->id,
            ]);

            if (! $log) {
                throw new \Exception('Failed to create arcade log.');
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Update a arcade log if the user won
     */
    public function updateLog($arcade, $user)
    {
        DB::beginTransaction();

        try {
            ArcadeLog::played($arcade->id, $user->id)->orderBy('created_at', 'DESC')->first()->update(['won' => 1]);
            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Grant game rewards
     */
    public function calculateRewards($arcade, $user, $score)
    {
        $gameData = $arcade->data;

        //If min score is set, substract score_min from the score.
        if ($gameData['score_min']) {
            $basescore = $score - $gameData['score_min'];
        } else {
            $basescore = $score;
        }

        //If max score is set, reduce score the the maximum score
        if ($gameData['score_max'] && $basescore > $gameData['score_max'] && $basescore > 0) {
            $maxedscore = $gameData['score_max'];
        } else {
            $maxedscore = $basescore;
        }

        //If milestone is set, divide the remaining score by the milestone amount.
        if ($gameData['milestone'] && $maxedscore > 0) {
            $totalrewards = $maxedscore / $gameData['milestone'];
        } elseif (!$gameData['milestone'] && $maxedscore > 0) {
            $totalrewards = 1;
        } else {
            throw new \Exception('You did not earn enough points to get a reward.');
        }

        for ($i = 0; $i < $totalrewards; $i++) {
            $this->grantRewards($arcade, $user);
        }
    }

    /**
     * Grant game rewards
     */
    public function grantRewards($arcade, $user)
    {
        DB::beginTransaction();

        try {
            $gameName = isset($arcade->flavor_data['log_name']) ? $arcade->flavor_data['log_name'] : $arcade->configInfo['name'];
            if (
                ! ($rewards = fillUserAssets($arcade->rewardItems, null, $user, $gameName . ' Reward', [
                    'data' => $gameName . ' reward: ' . $arcade->displayName,
                ]))
            ) {
                throw new \Exception('Failed to distribute rewards to user.');
            }
            if (isset($arcade->flavor_data['win_message'])) {
                flash($arcade->flavor_data['win_message'])->success();
            }
            flash('You have received: ' . createRewardsString($rewards));

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }
}
