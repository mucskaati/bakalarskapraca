<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiment extends Model
{
    protected $fillable = [
        'ajax_url',
        'slug',
        'description',
        'export',
        'layout_id',
        'title',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/experiments/' . $this->getKey());
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function graphs()
    {
        return $this->hasMany(Graph::class);
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }
}
