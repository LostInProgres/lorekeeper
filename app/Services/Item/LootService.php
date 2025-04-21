<?php namespace App\Services\Item;

use App\Services\Service;

use DB;

use App\Services\InventoryManager;

use App\Models\Item\Item;
use App\Models\Currency\Currency;
use App\Models\Loot\LootTable;
use App\Models\Raffle\Raffle;

class LootService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Loot Service
    |--------------------------------------------------------------------------
    |
    | Handles the editing and usage of loot type items.
    |
    */

    /**
     * Retrieves any data that should be used in the item tag editing form.
     *
     * @return array
     */
    public function getEditData()
    {
        return [
            'tables' => LootTable::orderBy('name')->pluck('name', 'id'),
        ];
    }

    /**
     * Processes the data attribute of the tag and returns it in the preferred format.
     *
     * @param  string  $tag
     * @return mixed
     */
    public function getTagData($tag)
    {
        return $tag->data;
    }

        /**
     * Processes the data attribute of the tag and returns it in the preferred format.
     *
     * @param  string  $tag
     * @param  array   $data
     * @return bool
     */
    public function updateData($tag, $data)
    {
        DB::beginTransaction();

        try {

            // If there's no data, return.
            if(!isset($data['table_id'])) return true;

            $tag->data = $data['table_id'];
            $tag->save();

            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**
     * Acts upon the item when used from the inventory.
     *
     * @param  \App\Models\User\UserItem  $stacks
     * @param  \App\Models\User\User      $user
     * @param  array                      $data
     * @return bool
     */
    public function act($stacks, $user, $data)
    {
        DB::beginTransaction();

        try {
            foreach($stacks as $key=>$stack) {
                // We don't want to let anyone who isn't the owner of the loot open it,
                // so do some validation... 
                if($stack->user_id != $user->id) throw new \Exception("This item does not belong to you.");

                // Next, try to delete the loot item. If successful, we can start distributing rewards.
                if((new InventoryManager)->debitStack($stack->user, 'Loot Opened', ['data' => ''], $stack, $data['quantities'][$key])) {
                    // Okay, so now we just fake having the data like other item tags.
                    $array = [];
                    $loot_tables = [];

                    $loot_tables[1] = $stack->item->tag('loot')->data;

                    $array["loot_tables"] = $loot_tables;


                    for($q=0; $q<$data['quantities'][$key]; $q++) {
                        // Distribute user rewards
                        if(!$rewards = fillUserAssets(parseAssetData($array), $user, $user, 'Loot Rewards', [
                            'data' => 'Received rewards from opening '.$stack->item->name
                        ])) throw new \Exception("Failed to open loot.");
                        flash($this->getLootRewardsString($rewards));
                    }
                }
            }
            return $this->commitReturn(true);
        } catch(\Exception $e) { 
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    ///***
    // LostTODO
    // the following is unedited! Lost, don't leave this in or i swear to god-
    // 
    //  */

    /**
     * Acts upon the item when used from the inventory.
     *
     * @param  array                  $rewards
     * @return string
     */
    private function getLootRewardsString($rewards)
    {
        $results = "You have received: ";
        $result_elements = [];
        foreach($rewards as $assetType)
        {
            if(isset($assetType))
            {
                foreach($assetType as $asset)
                {
                    array_push($result_elements, $asset['asset']->name.(class_basename($asset['asset']) == 'Raffle' ? ' (Raffle Ticket)' : '')." x".$asset['quantity']);
                }
            }
        }
        return $results.implode(', ', $result_elements);
    }
}