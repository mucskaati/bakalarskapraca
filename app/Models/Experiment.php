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
        'custom_js',
        'run_button',
        'template',
        'type'
    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $casts = [
        'run_button' => 'boolean',
        'export' => 'boolean'
    ];

    protected $appends = ['resource_url', 'layoutName', 'detail_url', 'comparison_url', 'comparison_detail_url', 'nyquist_url', 'nyquist_detail_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/experiments/' . $this->getKey());
    }

    public function getComparisonUrlAttribute()
    {
        return url('/admin/comparisons/' . $this->getKey());
    }

    public function getNyquistUrlAttribute()
    {
        return url('/admin/nyquist-experiments/' . $this->getKey());
    }

    public function getTypeAttribute($value)
    {
        return ($value) ?: 'fo';
    }

    public function getDetailUrlAttribute()
    {
        if ($this->getKey()) {
            return route('graph_fo', ['id' => $this->getKey(), 'slug' => $this->slug]);
        }
        return;
    }

    public function getComparisonDetailUrlAttribute()
    {
        if ($this->getKey()) {
            return route('comparison', ['id' => $this->getKey(), 'slug' => $this->slug]);
        }
        return;
    }

    public function getNyquistDetailUrlAttribute()
    {
        if ($this->getKey()) {
            return route('graph_nyquist', ['id' => $this->getKey(), 'slug' => $this->slug]);
        }
        return;
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
        return $this->belongsTo(Layout::class)->with(['sliders', 'checkboxes']);
    }

    public function schemes()
    {
        return $this->belongsToMany(ComparisonExperiment::class, 'comparison_scheme', 'experiment_id', 'scheme_id');
    }

    public function examples()
    {
        return $this->hasMany(Example::class);
    }

    public function paths()
    {
        return $this->hasMany(Path::class);
    }
}
