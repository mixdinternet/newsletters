<?php

namespace Mixdinternet\Newsletters;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use Carbon;

class Newsletter extends EloquentModel
{
    use SoftDeletes, RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    protected $revisionFormattedFieldNames = [
        'name' => 'nome',
        'email' => 'email'
    ];

    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'email'];


    public function scopeSort($query, $fields = [])
    {
        if (count($fields) <= 0) {
            $fields = [
                'name' => 'asc'
            ];
        }

        if (request()->has('field') && request()->has('sort')) {
            $fields = [request()->get('field') => request()->get('sort')];
        }

        foreach ($fields as $field => $order) {
            $query->orderBy($field, $order);
        }
    }
}
