<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Translatable\Traits\HasTranslations;

class Layout extends Model
{
    use HasTranslations;
    protected $fillable = [
        'columns',
        'height',
        'margin',
        'name',
        'rows',
        'type',
        'width',
        'xaxis',
        'yaxis',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];
    // these attributes are translatable
    public $translatable = [
        'margin',
        'xaxis',
        'yaxis',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/layouts/' . $this->getKey());
    }

    public function getXaxisAttribute($value)
    {
        return (string) $value;
    }

    public function getYaxisAttribute($value)
    {
        return (string) $value;
    }

    public function getMarginAttribute($value)
    {
        return (string) $value;
    }
}
