<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{
    protected $fillable = [
        'attribute_name',
        'layout_id',
        'title',
        'slider_dependency_change'

    ];

    protected $casts = [
        'slider_dependency_change' => 'boolean'
    ];

    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url', 'layoutTitle'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/checkboxes/' . $this->getKey());
    }

    public function getLayoutTitleAttribute()
    {
        return $this->layout->name;
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function dependentSliders()
    {
        return $this->belongsToMany(Slider::class, 'checkbox_slider', 'checkbox_id', 'slider_id')->withPivot(['value_function'])->withTimestamps();
    }
}
