<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaboratoryTest extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = ['created_at', 'deleted_at', 'updated_at'];

    /**
     * Get the laboratory_category that owns the LaboratoryTest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function laboratory_category(): BelongsTo
    {
        return $this->belongsTo(LaboratoryCategory::class);
    }

    protected function Title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
        );
    }
}
