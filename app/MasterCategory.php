<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    protected $fillable = ['name', 'cat_type', 'thumbnail', 'active'];

    /**
     * All subcategories
     */
    public function subcategories()
    {
        return $this->hasMany(MasterSubcategory::class);
    }


}
