<?php
namespace App\Services;

use App\Models\Currency\Currency;
use App\Models\Minigame\Minigame;
use App\Services\Service;
use DB;

class MinigameService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Minigame Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of Minigames
    |
     */

    /**********************************************************************************************

    MINIGAMES

     **********************************************************************************************/

    /**
     * Creates a new minigame.
     *
     * @param  array                  $data
     * @param  \App\Models\User\User  $user
     */
    public function createMinigame($data)
    {
        DB::beginTransaction();

        try {

            $data = $this->populateMinigameData($data);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image             = $data['image'];
                unset($data['image']);
            } else {
                $data['has_image'] = 0;
            }

            $minigame = Minigame::create($data);

            if ($image) {
                $this->handleImage($image, $minigame->ImagePath, $minigame->ImageFileName);
            }

            return $this->commitReturn($minigame);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a minigame.
     *
     * @param  array                  $data
     * @param  \App\Models\User\User  $user
     */
    public function updateMinigame($minigame, $data)
    {
        DB::beginTransaction();

        try {
            // More specific validation
            if (Minigame::where('name', $data['name'])->where('id', '!=', $minigame->id)->exists()) {
                throw new \Exception("The name has already been taken.");
            }

            $data = $this->populateMinigameData($data, $minigame);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image             = $data['image'];
                unset($data['image']);
            }

            // If changing games, clear out the old data
            if ($minigame->minigame_type !== $data['minigame_type']) {
                $minigame->data          = null;
                $minigame->variable_data = null;
                $minigame->save();
            }

            $minigame->update($data);

            if ($minigame) {
                $this->handleImage($image, $minigame->ImagePath, $minigame->ImageFileName);
            }

            return $this->commitReturn($minigame);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Processes user input for creating/updating a minigame.
     *
     * @param  array                  $data
     * @return array
     */
    private function populateMinigameData($data, $minigame = null)
    {
        if (! $data['minigame_type']) {
            throw new \Exception("You must select a minigame type.");
        }

        if (isset($data['currency_id'])) {
            if (! isset($data['fee'])) {
                throw new \Exception("You must set an entry fee.");
            }
            if (! Currency::find($data['currency_id'])) {
                throw new \Exception("Invalid currency selected.");
            }
        }

        if (isset($data['rewardable_type'])) {
            $data['output'] = encodeForDataColumn($data, false);
        } elseif ($minigame->configInfo['require_reward']) {
            throw new \Exception("You must add rewards for this type of minigame.");
        } else {
            $data['output'] = null;
        }

        if (isset($data['description']) && $data['description']) {
            $data['parsed_description'] = parse($data['description']);
        }

        $data['is_visible'] = isset($data['is_visible']);

        if (isset($data['remove_image'])) {
            if ($minigame && $minigame->has_image && $data['remove_image']) {
                $data['has_image'] = 0;
                $this->deleteImage($minigame->ImagePath, $minigame->ImageFileName);
            }
            unset($data['remove_image']);
        }

        $data['flavor_data'] = [
            'win_message'        => $data['win_message'],
            'lose_message'        => $data['lose_message'],
            'neutral_message'        => $data['neutral_message'],
            'log_name'        => $data['log_name'],
        ];

        return $data;
    }

    /**
     * Deletes a minigame.
     *
     * @return bool
     */
    public function deleteMinigame($minigame)
    {
        DB::beginTransaction();

        try {
            if ($minigame->has_image) {
                $this->deleteImage($minigame->ImagePath, $minigame->ImageFileName);
            }

            $minigame->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Sorts minigame order.
     *
     * @param  string  $data
     * @return bool
     */
    public function sortMinigame($data)
    {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach ($sort as $key => $s) {
                Minigame::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Update the minigame's game data.
     *
     * @param  string  $data
     * @return bool
     */
    public function updateType($minigame, $data)
    {
        DB::beginTransaction();

        try {
            $minigame->data = $minigame->service->updateData($minigame, $data);
            $minigame->save();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**********************************************************************************************

    IMAGES

     **********************************************************************************************/

    /**
     * Updates a image.
     *
     */
    public function updateMinigameImages($minigame, $data)
    {
        DB::beginTransaction();

        try {

            if (isset($data['remove_custom_image'])) {
                foreach ($data['remove_custom_image'] as $key => $check) {
                    if ($minigame->customImageExists($key) && $data['remove_custom_image'][$key]) {
                        $this->deleteImage($minigame->customImagePath, $minigame->CustomImageFileName($key));
                    }
                    unset($data['remove_custom_image'][$key]);
                }
            }

            if (isset($data['custom_image'])) {
                foreach ($data['custom_image'] as $key => $image) {
                    $this->handleImage($image, $minigame->customImagePath, $minigame->CustomImageFileName($key));
                    unset($data['custom_image'][$key]);
                }
            }

            return $this->commitReturn($minigame);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}
