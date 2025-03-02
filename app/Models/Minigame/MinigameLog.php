<?php

namespace App\Models\Minigame;

use App\Models\Model;

class MinigameLog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'minigame_id', 'user_id', 'won','character_id','data'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'minigame_log';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'minigame_id' => 'required',
        'user_id' => 'required',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data'          => 'array',
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the user who purchased the item.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User\User');
    }

    /**
     * Get the shop the item was purchased from.
     */
    public function minigame()
    {
        return $this->belongsTo('App\Models\Minigame\Minigame');
    }

    public function character()
    {
        return $this->belongsTo('App\Models\Character\Character');
    }

     /**********************************************************************************************

        SCOPES

    **********************************************************************************************/

     /**
     * Scope a query to only include user's logs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePlayed($query, $minigame, $user)
    {
        return $query->where('minigame_id', $minigame)->where('user_id', $user);
    }



}
