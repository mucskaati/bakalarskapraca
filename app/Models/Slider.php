<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'default',
        'default_function',
        'layout_id',
        'comparison_experiment_id',
        'max',
        'min',
        'step',
        'title',
        'visible',
        'label',
        'columns',
        'sorting',
        'type'
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

    public function getSlugAttribute()
    {
        return str_slug($this->title);
    }

    public function getTypeAttribute($value)
    {
        return ($value) ?: 'fo';
    }


    /* ************************ RELATIONSHIPS ************************* */

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function comparisonExperiments()
    {
        return $this->belongsToMany(ComparisonExperiment::class, 'slider_comparison_experiment', 'slider_id', 'comparison_experiment_id');
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

    public function examples()
    {
        return $this->belongsToMany(Example::class, 'example_slider');
    }
}
