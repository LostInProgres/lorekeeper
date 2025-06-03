<?php
namespace App\Models\Arcade;

use App\Models\Arcade\ArcadeLog;
use App\Models\Model;
use App\Services\Arcade\GeneralService;

class Arcade extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'sort', 'has_image', 'description', 'parsed_description', 'is_visible', 'arcade_type', 'data', 'limit', 'limit_period', 'output', 'variable_data', 'currency_id', 'fee', 'flavor_data',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'arcades';

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'name'        => 'required|between:3,100',
        'description' => 'nullable',
        'image'       => 'mimes:jpeg,jpg,gif,png',
    ];

    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'name'        => 'required|between:3,100',
        'description' => 'nullable',
        'image'       => 'mimes:jpeg,jpg,gif,png',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data'          => 'array',
        'output'        => 'array',
        'variable_data' => 'array',
        'flavor_data'   => 'array',
    ];

    /**********************************************************************************************

    ACCESSORS

     **********************************************************************************************/

    /**
     * Displays the shop's name, linked to its purchase page.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return '<a href="' . $this->url . '">' . $this->name . '</a>';
    }

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute()
    {
        return 'images/data/arcade';
    }

    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function getImageFileNameAttribute()
    {
        return $this->id . '-image.png';
    }

    /**
     * Gets the path to the file directory containing the model's image.
     *
     * @return string
     */
    public function getImagePathAttribute()
    {
        return public_path($this->imageDirectory);
    }

    /**
     * Gets the URL of the model's image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (! $this->has_image) {
            return null;
        }

        return asset($this->imageDirectory . '/' . $this->ImageFileName);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('arcade/' . $this->id);
    }

    /**
     * Get the service associated with the associated type.
     *
     * @return mixed
     */
    public function getServiceAttribute()
    {
        $class = 'App\Services\Arcade\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $this->arcade_type))) . 'Service';
        return (new $class());
    }

    /**
     * Get the config data
     *
     * @return mixed
     */
    public function getConfigInfoAttribute()
    {
        return config('lorekeeper.arcade_types.' . $this->arcade_type);
    }

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getCustomImageDirectoryAttribute()
    {
        return 'images/data/arcade/images';
    }

    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function customImageFileName($key)
    {
        return $this->id . '-' . $key . '.png';
    }

    /**
     * Gets the path to the file directory containing the model's image.
     *
     * @return string
     */
    public function getCustomImagePathAttribute()
    {
        return public_path($this->customImageDirectory);
    }

    /**
     * Gets the URL of the model's image.
     *
     * @return string
     */
    public function customImageUrl($key)
    {
        return asset($this->customImageDirectory . '/' . $this->CustomImageFileName($key));
    }

    /**
     * Check that custom image exists
     *
     * @return string
     */
    public function customImageExists($key)
    {
        return file_exists($this->customImagePath . '/' . $this->CustomImageFileName($key));
    }

    /**
     * Get the general service
     *
     * @return mixed
     */
    public function getGeneralServiceAttribute()
    {
        return (new GeneralService());
    }

    /**
     * Gets the decoded output json
     *
     * @return array
     */
    public function getRewardsAttribute()
    {
        $rewards = [];
        if ($this->output) {
            $assets = $this->getRewardItemsAttribute();

            foreach ($assets as $type => $a) {
                $class = getAssetModelString($type, false);
                foreach ($a as $id => $asset) {
                    $rewards[] = (object) [
                        'rewardable_type' => $class,
                        'rewardable_id'   => $id,
                        'quantity'        => $asset['quantity'],
                    ];
                }
            }
        }
        return $rewards;
    }

    /**
     * Interprets the json output and retrieves the corresponding items
     *
     * @return array
     */
    public function getRewardItemsAttribute()
    {
        return parseAssetData($this->output);
    }

    /**
     * Get the currency for the arcade fee
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency\Currency');
    }

    /**********************************************************************************************
    OTHER
     **********************************************************************************************/

    public function checkLimit($user)
    {
        if (isset($this->limit)) {
            if ($this->logCount($user) >= $this->limit) {
                return false;
            }

        }
        return true;
    }

    public function logCount($user)
    {
        if (isset($this->limit)) {

            switch ($this->limit_period) {
                case null:
                    return ArcadeLog::played($this->id, $user->id)->count();
                    break;
                case 'Hour':
                    return ArcadeLog::played($this->id, $user->id)->where('created_at', '>=', now()->startOfHour())->count();
                    break;
                case 'Day':
                    return ArcadeLog::played($this->id, $user->id)->where('created_at', '>=', now()->startOfDay())->count();
                    break;
                case 'Week':
                    return ArcadeLog::played($this->id, $user->id)->where('created_at', '>=', now()->startOfWeek())->count();
                    break;
                case 'Month':
                    return ArcadeLog::played($this->id, $user->id)->where('created_at', '>=', now()->startOfMonth())->count();
                    break;
                case 'Year':
                    return ArcadeLog::played($this->id, $user->id)->where('created_at', '>=', now()->startOfYear())->count();
                    break;
            }

        }
        return null;
    }

    /**
     * Scope a query to only include visible arcades.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', 1);
    }

}
