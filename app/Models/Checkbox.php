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
        $name = "";
        if ($this->layout_id) {
            $name = '<span class="badge badge-primary mr-1">' . $this->layout->name . '</span>';
        } elseif ($this->comparisonExperiments->count() > 0) {
            foreach ($this->comparisonExperiments as $scheme) {
                $name .= '<span class="badge badge-primary mr-1">' . $scheme->title . '</span>';
            }
        }
        return $name;
    }

    public function getTitleWithLayoutAttribute()
    {
        $name = "";
        if ($this->layout_id) {
            $name = '<span class="badge badge-primary mr-1">' . $this->layout->name . '</span>';
        } elseif ($this->comparisonExperiments->count() > 0) {
            foreach ($this->comparisonExperiments as $scheme) {
                $name .= '<span class="badge badge-primary mr-1">' . $scheme->title . '</span>';
            }
        }
        return $this->title . ' - ' . $name;
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function comparisonExperiments()
    {
        return $this->belongsToMany(ComparisonExperiment::class, 'checkbox_comparison_experiment', 'checkbox_id', 'comparison_experiment_id');
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
