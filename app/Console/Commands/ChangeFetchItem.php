<?php

namespace App\Console\Commands;

use DB;
use Settings;
use Log;
use Illuminate\Console\Command;
use App\Models\Item\Item;

class ChangeFetchItem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-fetch-item';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes currently wanted fetch item.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $items = Item::where('item_category_id', Settings::get('fetch_category_id'))->released()->get();
        if(!$items->count()) throw new \Exception('There are no items to select from!');

        $totalWeight = $items->count();
        $roll = mt_rand(0, $totalWeight - 1);
        $result = $items[$roll]->id;

        $setting = Settings::get('fetch_item');
        while($result == $setting) {
            $roll = mt_rand(0, $totalWeight - 1);
            $result = $items[$roll]->id;
        }

        DB::table('site_settings')->where('key', 'fetch_item')->update(['value' => $result]);
    }
}
