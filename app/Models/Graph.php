<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graph extends Model
{
    protected $fillable = [
        'experiment_id',
        'annotation_title',
        'align',
        'annotation_angle',
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
        return url('/admin/sliders/' . $this->getKey());
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function experiment()
    {
        return $this->belongsTo(Experiment::class, 'experiment_id');
    }
}
