<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\UsgsEventRecordObserver;

class UsgsEventRecord extends Model
{

    protected $table = 'usgs';
    
    protected $hidden = [
        'id', 'created_at', 'updated_at', 'record_updated_at', 'usgs_id'
    ];

    /**
     * Attach an observer here
     */
    public static function boot()
    {
        parent::boot();
        static::observe(new UsgsEventRecordObserver());
    }

}
