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
        'custom_js'
    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url', 'layoutName'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/experiments/' . $this->getKey());
    }

    public function getLayoutNameAttribute()
    {
        return $this->layout->name;
    }
    /* ************************ RELATIONSHIPS ************************* */

    public function graphs()
    {
        return $this->hasMany(Graph::class)->with('traces');
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }
}
