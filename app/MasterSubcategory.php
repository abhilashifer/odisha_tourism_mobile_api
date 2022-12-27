<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSubcategory extends Model
{
    protected $fillable = ['master_category_id', 'name', 'thumbnail', 'description', 'active'];

    public function masterCategory()
    {
        return $this->belongsTo('App\MasterCategory');
    }
}
