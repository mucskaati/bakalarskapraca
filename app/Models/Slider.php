<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'default',
        'default_function',
        'layout_id',
        'max',
        'min',
        'step',
        'title',
        'visible',
        'label',
        'columns',
        'sorting'

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url', 'layoutTitle', 'titleWithLayout', 'slug'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/sliders/' . $this->getKey());
    }

    public function getLayoutTitleAttribute()
    {
        return $this->layout->name;
    }

    public function getTitleWithLayoutAttribute()
    {
        return $this->title . ' [' . $this->layout->name . ']';
    }

    public function getSlugAttribute()
    {
        return str_slug($this->title);
    }


    /* ************************ RELATIONSHIPS ************************* */

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }
    public function dependencies()
    {
        return $this->belongsToMany(Slider::class, 'slider_dependencies', 'slider_id', 'depended_slider_id')->withPivot(['value_same_as_added', 'value_function'])->withTimestamps();
    }

    public function dependentCheckboxes()
    {
        return $this->belongsToMany(Checkbox::class, 'checkbox_slider', 'slider_id', 'checkbox_id')->withPivot(['value_function'])->withTimestamps();
    }

    public function sliders()
    {
        return $this->belongsToMany(Slider::class, 'slider_dependencies', 'dependend_slider_id', 'slider_id')->withPivot(['value_same_as_added', 'value_function'])->withTimestamps();
    }
}
