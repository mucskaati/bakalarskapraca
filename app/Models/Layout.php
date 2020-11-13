<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $fillable = [
        'columns',
        'height',
        'margin',
        'name',
        'rows',
        'type',
        'width',
        'xaxis',
        'yaxis',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/layouts/' . $this->getKey());
    }

    public function getXaxisAttribute($value)
    {
        return json_decode($value);
    }

    public function getYaxisAttribute($value)
    {
        return json_decode($value);
    }

    public function getMarginAttribute($value)
    {
        return json_decode($value);
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function experiments()
    {
        return $this->hasMany(Experiment::class);
    }
}
