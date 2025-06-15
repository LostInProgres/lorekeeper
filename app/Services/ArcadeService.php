<?php
namespace App\Services;

use App\Models\Currency\Currency;
use App\Models\Arcade\Arcade;
use App\Services\Service;
use DB;

class ArcadeService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Arcade Service
    |--------------------------------------------------------------------------
    |
    | Handles the creation and editing of Arcade games
    |
     */

    /**********************************************************************************************

    ARCADES

     **********************************************************************************************/

    /**
     * Creates a new arcade.
     *
     * @param  array                  $data
     * @param  \App\Models\User\User  $user
     */
    public function createArcade($data)
    {
        DB::beginTransaction();

        try {

            $data = $this->populateArcadeData($data);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image             = $data['image'];
                unset($data['image']);
            } else {
                $data['has_image'] = 0;
            }

            $arcade = Arcade::create($data);

            if ($image) {
                $this->handleImage($image, $arcade->ImagePath, $arcade->ImageFileName);
            }

            return $this->commitReturn($arcade);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Updates a arcade.
     *
     * @param  array                  $data
     * @param  \App\Models\User\User  $user
     */
    public function updateArcade($arcade, $data)
    {
        DB::beginTransaction();

        try {
            // More specific validation
            if (Arcade::where('name', $data['name'])->where('id', '!=', $arcade->id)->exists()) {
                throw new \Exception("The name has already been taken.");
            }

            $data = $this->populateArcadeData($data, $arcade);

            $image = null;
            if (isset($data['image']) && $data['image']) {
                $data['has_image'] = 1;
                $image             = $data['image'];
                unset($data['image']);
            }

            // If changing games, clear out the old data
            if ($arcade->arcade_type !== $data['arcade_type']) {
                $arcade->data          = null;
                $arcade->variable_data = null;
                $arcade->save();
            }

            $arcade->update($data);

            if ($arcade) {
                $this->handleImage($image, $arcade->ImagePath, $arcade->ImageFileName);
            }

            return $this->commitReturn($arcade);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Processes user input for creating/updating a arcade.
     *
     * @param  array                  $data
     * @return array
     */
    private function populateArcadeData($data, $arcade = null)
    {
        if (! $data['arcade_type']) {
            throw new \Exception("You must select a arcade type.");
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
        } else {
            $data['output'] = null;
        }

        if (isset($data['description']) && $data['description']) {
            $data['parsed_description'] = parse($data['description']);
        }

        if (isset($data['remove_image'])) {
            if ($arcade && $arcade->has_image && $data['remove_image']) {
                $data['has_image'] = 0;
                $this->deleteImage($arcade->ImagePath, $arcade->ImageFileName);
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
     * Deletes a arcade.
     *
     * @return bool
     */
    public function deleteArcade($arcade)
    {
        DB::beginTransaction();

        try {
            if ($arcade->has_image) {
                $this->deleteImage($arcade->ImagePath, $arcade->ImageFileName);
            }

            $arcade->delete();

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Sorts arcade order.
     *
     * @param  string  $data
     * @return bool
     */
    public function sortArcade($data)
    {
        DB::beginTransaction();

        try {
            // explode the sort array and reverse it since the order is inverted
            $sort = array_reverse(explode(',', $data));

            foreach ($sort as $key => $s) {
                Arcade::where('id', $s)->update(['sort' => $key]);
            }

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Update the arcade's game data.
     *
     * @param  string  $data
     * @return bool
     */
    public function updateScoreData($data)
    {
        return [
            'score_min' => $data['score_min'],
            'milestone' => $data['milestone'],
            'score_max' => $data['score_max'],
        ];
    }

    /**
     * Update the arcade's game data.
     *
     * @param  string  $data
     * @return bool
     */
    public function updateType($arcade, $data)
    {
        DB::beginTransaction();

        try {
            $arcade->is_visible = isset($data['is_visible']);
            $arcade->data = $arcade->service->updateData($arcade, $data) + $this->updateScoreData($data);

            $arcade->save();

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
    public function updateArcadeImages($arcade, $data)
    {
        DB::beginTransaction();

        try {

            if (isset($data['remove_custom_image'])) {
                foreach ($data['remove_custom_image'] as $key => $check) {
                    if ($arcade->customImageExists($key) && $data['remove_custom_image'][$key]) {
                        $this->deleteImage($arcade->customImagePath, $arcade->CustomImageFileName($key));
                    }
                    unset($data['remove_custom_image'][$key]);
                }
            }

            if (isset($data['custom_image'])) {
                foreach ($data['custom_image'] as $key => $image) {
                    $this->handleImage($image, $arcade->customImagePath, $arcade->CustomImageFileName($key));
                    unset($data['custom_image'][$key]);
                }
            }

            return $this->commitReturn($arcade);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}
