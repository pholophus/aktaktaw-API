<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Nicolaslopezj\Searchable\SearchableTrait;
class Base extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use SearchableTrait;

    public function findByUuid($uuid)
    {
        return static::where('uuid', $uuid)->first();
    }
    public function findByHashid($hashid)
    {
        return static::findOrFail(\Hashids::decode($hashid)[0]);
    }

    public function getHashid($columnName = 'id')
    {
        return \Hashids::encode($this->{$columnName});
    }


    public function enable()
    {
        $this->update(['is_active' => 1]);

        return $this;
    }

    public function disable()
    {
        $this->update(['is_active' => 0]);

        return $this;
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', 1);
    }
}
