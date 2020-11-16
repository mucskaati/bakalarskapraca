<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trace extends Model
{
    protected $fillable = [
        'title',
        'graph_id',
        'color',
        'legendgroup',
        'show_legend',
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

    public function getXaxisAttribute($value)
    {
        return ['id' => $value, 'title' => $value];
    }

    public function getYaxisAttribute($value)
    {
        return ['id' => $value, 'title' => $value];
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function graph()
    {
        return $this->belongsTo(Graph::class);
    }
}
