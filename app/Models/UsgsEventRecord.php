<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\UsgsEventRecordObserver;
use Carbon\Carbon;

class UsgsEventRecord extends Model
{
    protected $table = 'usgs';
    
    protected $hidden = [
        'id', 'created_at', 'updated_at', 'usgs_id'
    ];

    /**
     * Attach an observer here
     */
    public static function boot()
    {
        parent::boot();
        static::observe(new UsgsEventRecordObserver());
    }

    /**
     * Gets the event at attribute.
     *
     * @param <type> $value The value
     *
     * @return <type> The event at attribute.
     */
    public function getEventAtAttribute($value) {
        return Carbon::parse($value)->toIso8601String();
    }

    /**
     * Gets the record updated at attribute.
     *
     * @param <type> $value The value
     *
     * @return <type> The record updated at attribute.
     */
    public function getRecordUpdatedAtAttribute($value) {
        return Carbon::parse($value)->toIso8601String();
    }

    /**
     * Gets the magnitude attribute.
     *
     * @param <type> $value The value
     *
     * @return <type> The magnitude attribute.
     */
    public function getMagnitudeAttribute($value) {
        return number_format($value, 1);
    }

    /**
     * Gets the depth attribute.
     *
     * @param <type> $value The value
     *
     * @return <type> The depth attribute.
     */
    public function getDepthAttribute($value) {
        return number_format($value, 2);
    }

    /**
     * Gets the latitude attribute.
     *
     * @param <type> $value The value
     *
     * @return <type> The latitude attribute.
     */
    public function getLatitudeAttribute($value) {
        return number_format($value, 4);
    }

    /**
     * Gets the longitude attribute.
     *
     * @param <type> $value The value
     *
     * @return <type> The longitude attribute.
     */
    public function getLongitudeAttribute($value) {
        return number_format($value, 4);
    }

}
