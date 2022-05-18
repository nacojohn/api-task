<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $casts = [
        'lab_tests' => 'array'
    ];
    protected $hidden = ['added_by', 'updated_at', 'created_at'];

    /**
     * Get the patient that owns the MedicalRecord
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    protected function Ctscan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
        );
    }

    protected function Mri(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
        );
    }

    public function getTests()
    {
        $medical_records = LaboratoryTest::whereIn('id', $this->lab_tests)->get()->groupBy(function($query) {
            return LaboratoryCategory::find($query->laboratory_category_id)->title;
        });

        return $medical_records;
    }
}
