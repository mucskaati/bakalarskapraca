<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    protected $fillable = [
        'experiment_id',
        'path1_name',
        'path2_name',
        'path1',
        'path2',
        'legend_color',
        'show_legend',
    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/sliders/' . $this->getKey());
    }

    public function getPath1Attribute($value)
    {
        return ['id' => $value, 'title' => $value];
    }

    public function getPath2Attribute($value)
    {
        return ['id' => $value, 'title' => $value];
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function experiment()
    {
        return $this->belongsTo(Experiment::class);
    }
}
