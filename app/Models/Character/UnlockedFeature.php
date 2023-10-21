<?php

namespace App\Models\Character;

use Config;
use DB;
use App\Models\Model;
use App\Models\Character\CharacterCategory;

class UnlockedFeature extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'character_id', 'feature_id','character_type'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unlocked_features';    
    
    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/

    /**
     * Get the character associated with this record.
     */
    public function character() 
    {
        return $this->belongsTo('App\Models\Character\Character', 'character_id');
    }
    
    /**
     * Get the feature (character trait) associated with this record.
     */
    public function feature() 
    {
        return $this->belongsTo('App\Models\Feature\Feature', 'feature_id');
    }

    
     /**
     *  
     *
     * @return string
     */
    public function getFeatureNameAttribute()
    { 
        return $this->feature->name;
    }
}
