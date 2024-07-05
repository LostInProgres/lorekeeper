<?php

namespace App\Models\Feature;

use App\Models\Model;

class FeatureAssociation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['object_id', 'object_type', 'summary', 'association_id', 'association_type', 'association_summary'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feature_associations';

    /**********************************************************************************************
    RELATIONS
     **********************************************************************************************/

    /**
     * Get the attachments.
     */
    public function object()
    {
        switch ($this->association_type) {
            case 'Item':
                return $this->belongsTo('App\Models\Item\Item', 'association_id');
            case 'Trait':
                return $this->belongsTo('App\Models\Feature\Feature', 'association_id');
        }
        return null;
    }
}
