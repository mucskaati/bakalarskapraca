<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    protected $fillable = [
        'experiment_id',
        'title',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url', 'experimentTitle'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/examples/' . $this->getKey());
    }

    public function getExperimentTitleAttribute()
    {
        return $this->experiment->title;
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function experiment()
    {
        return $this->belongsTo(Experiment::class);
    }

    public function sliders()
    {
        return $this->belongsToMany(Slider::class, 'example_slider')->with('dependencies')->withPivot(['value'])->withTimestamps();
    }

    public function checkboxes()
    {
        return $this->belongsToMany(Checkbox::class, 'example_checkbox')->with(['dependentSliders']);
    }
}
