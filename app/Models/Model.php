<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Dcat\Admin\Traits\HasDateTimeFormatter;

class Model extends EloquentModel
{
    use HasDateTimeFormatter;

    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }
}
