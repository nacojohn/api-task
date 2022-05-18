<?php

namespace App\Listeners;

use App\Events\MedicalRecordCreated;
use App\Mail\RecordCreated;
use App\Models\LaboratoryCategory;
use App\Models\LaboratoryTest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailMedicalRecord
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MedicalRecordCreated  $event
     * @return void
     */
    public function handle(MedicalRecordCreated $event)
    {
        $record = $event->record;
        $tests = $event->tests;
        $ctscan = $event->ctscan;
        $mri = $event->mri;

        $medical_records = LaboratoryTest::whereIn('id', $tests)->get()->groupBy(function($query) {
            return LaboratoryCategory::find($query->laboratory_category_id)->title;
        });

        $mailData = [
            'patient' => $record->patient,
            'medical_records' => $medical_records,
            'ctscan' => $ctscan,
            'mri' => $mri
        ];

        // send an email
        Mail::to('peopleoperations@kompletecare.com')->send(new RecordCreated($mailData));
    }
}
