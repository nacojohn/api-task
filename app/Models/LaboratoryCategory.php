<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaboratoryCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

    /**
     * Get all of the test for the LaboratoryCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function laboratory_tests(): HasMany
    {
        return $this->hasMany(LaboratoryTest::class);
    }
}
