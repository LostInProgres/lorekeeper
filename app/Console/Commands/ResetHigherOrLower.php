<?php

namespace App\Console\Commands;

use App\Facades\Settings;
use Illuminate\Console\Command;
use Config;
use App\Models\User\UserSettings;

class ResetHigherOrLower extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset-hol';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'resets daily plays for higher or lower.';

    /**
     * Create a new command instance.
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

        $users = UserSettings::all();
        foreach ($users as $user) {
            $user->hol_plays = Config::get('lorekeeper.hol.hol_plays');
            $user->save();
        }
    }
}
