<?php

namespace App\GraphQL\Mutations;

use App\Events\MedicalRecordCreated;
use App\Models\MedicalRecord;
use Illuminate\Support\Arr;

final class MedicalRecordMutator
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $input = Arr::only($args, ['tests', 'ctscan', 'mri']);

        $record = new MedicalRecord();
        $record->patient_id = auth()->user()->id;
        $record->lab_tests = $input['tests'];
        $record->ctscan = $input['ctscan'];
        $record->mri = $input['mri'];
        $record->save();

        // dispatch an event to send email
        MedicalRecordCreated::dispatch($record, $input['tests'], $input['ctscan'], $input['mri']);

        return $record;
    }
}
