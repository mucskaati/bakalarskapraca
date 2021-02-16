<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{
    protected $fillable = [
        'attribute_name',
        'layout_id',
        'title',
        'slider_dependency_change',
        'comparison_experiment_id',
        'type'
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

    public function getTypeAttribute($value)
    {
        return ($value) ?: 'fo';
    }

    public function getLayoutTitleAttribute()
    {
        if ($this->layout_id) {
            $name = $this->layout->name;
        } elseif ($this->comparison_experiment_id) {
            $name = $this->comparisonExperiment->title;
        }
        return $name;
    }

    public function getTitleWithLayoutAttribute()
    {
        if ($this->layout_id) {
            $name = $this->layout->name;
        } elseif ($this->comparison_experiment_id) {
            $name = $this->comparisonExperiment->title;
        }
        return $this->title . ' [' . $name . ']';
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function comparisonExperiment()
    {
        return $this->belongsTo(ComparisonExperiment::class, 'comparison_experiment_id');
    }

    public function dependentSliders()
    {
        return $this->belongsToMany(Slider::class, 'checkbox_slider', 'checkbox_id', 'slider_id')->withPivot(['value_function'])->withTimestamps();
    }

    public function examples()
    {
        return $this->belongsToMany(Example::class, 'example_checkbox');
    }
}
