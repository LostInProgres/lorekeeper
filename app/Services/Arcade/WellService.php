<?php
namespace App\Services\Arcade;

use App\Services\Service;
use Auth;
use App\Models\Arcade\ArcadeLog;
use DB;
use App\Models\Character\Character;

class WellService extends Service
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
        $gameData = $arcade->data;

        if($gameData['require_message']){
            $wishes = ArcadeLog::orderBy('id', 'DESC');
        }else{
            $wishes = ArcadeLog::where('user_id', Auth::user()->id)->orderBy('id', 'DESC');
        }
        if($gameData['use_characters']){
            $wishes = $wishes->with('character');
        }

        return [
            'wishes' => $wishes->get()->take(10),
            'use_characters' => $gameData['use_characters'] ?? false,
            'require_message' => $gameData['require_message'] ?? false,
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

        if (! isset($data['use_characters'])) {
            $data['use_characters'] = 0;
        }

        if (! isset($data['require_message'])) {
            $data['require_message'] = 0;
        }

        return [
            'use_characters' => $data['use_characters'],
            'require_message' => $data['require_message'],
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
            if( $gameData['use_characters']){
                if(!$data['wish_character']){
                    throw new \Exception('You must select a character.');
                }
                $character = Character::find($data['wish_character']);
                if(!$character) throw new \Exception("This character does not exist.");
                if($user->id != $character->user_id) throw new \Exception("You do not own this character.");
            }
            if($gameData['require_message'] && !$data['wish']){
                throw new \Exception('You must type a wish.');
            }

            $arcade->generalService->grantRewards($arcade, $user);

            ArcadeLog::played($arcade->id, $user->id)->orderBy('created_at', 'DESC')->first()->update(['won' => 1, 'character_id' => $gameData['use_characters'] ? $character->id : null, 'data' => [
                'wish' => $gameData['require_message'] ? $data['wish'] : null]
            ]);

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

}
