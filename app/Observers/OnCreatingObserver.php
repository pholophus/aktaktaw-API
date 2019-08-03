<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class OnCreatingObserver
{
    public function creating(Model $model)
    {
        if (Schema::hasColumn($model->getTable(), 'uuid') && is_null($model->uuid)) {
            $model->uuid =  generateUuid();
        }
    }
}
