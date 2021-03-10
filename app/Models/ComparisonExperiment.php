<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class ComparisonExperiment extends Model implements HasMedia
{
    use ProcessMediaTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;

    protected $fillable = [
        'title',
        'description',
        'prefix',
        'trace_color',
        'legendgroup',
        'shortcut'
    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url', 'schema', 'titleAndPrefix'];

    /* ************************ MEDIA ************************* */

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('schema')
            ->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void
    {

        $this->autoRegisterThumb200();

        $this->addMediaConversion('thumbnail')
            ->width(300)
            ->performOnCollections('schema');
    }

    /* ************************ ACCESSOR ************************* */

    public function getSchemaAttribute()
    {
        return ($this->getFirstMediaUrl('schema', 'thumbnail')) ?: '';
    }

    public function getResourceUrlAttribute()
    {
        return url('/admin/comparison-experiments/' . $this->getKey());
    }

    public function getTitleAndPrefixAttribute()
    {

        return '[' . $this->prefix . '] ' . $this->title;
    }

    /* ************************ RELATIONSHIPS ************************* */

    public function sliders()
    {
        return $this->hasMany(Slider::class)->with('dependencies');
    }

    public function checkboxes()
    {
        return $this->hasMany(Checkbox::class)->with(['dependentSliders']);
    }

    public function experiments()
    {
        return $this->belongsToMany(Experiment::class, 'comparison_scheme', 'scheme_id', 'experiment_id');
    }

    public function examples()
    {
        return $this->belongsToMany(Example::class, 'example_scheme');
    }
}
