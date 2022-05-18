<?php

namespace App\Http\Controllers;

use App\Events\MedicalRecordCreated;
use App\Http\Resources\MedicalRecordResource;
use App\Mail\RecordCreated;
use App\Models\LaboratoryCategory;
use App\Models\LaboratoryTest;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class MedicalRecordController extends BaseController
{
    public function retrieveData()
    {
        $categories = LaboratoryCategory::with('laboratory_tests')->get();

        return $this->sendResponse($categories, 'Retrieved successfully');
    }

    public function index()
    {
        $records = MedicalRecord::where('patient_id', request()->user()->id)->with('patient')->get();

        return $this->sendResponse(MedicalRecordResource::collection($records), 'Records retrieved successfully');
    }

    public function store(Request $request)
    {
        //request for all post values
        $input = $request->all();

        //Validate to ensure valid inputs
        $validator = Validator::make($input, [
            'tests' => 'required|array',
            'tests.*' => 'required|exists:laboratory_tests,id',
            'ctscan' => 'required',
            'mri' => 'required'
        ]);

        //handle validation error
        if ($validator->fails())
            return $this->sendError('Validation error', $validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);

        $record = new MedicalRecord();
        $record->patient_id = $request->user()->id;
        $record->lab_tests = $request->tests;
        $record->ctscan = $request->ctscan;
        $record->mri = $request->mri;
        $record->save();

        // dispatch an event to send email
        MedicalRecordCreated::dispatch($record, $request->tests, $request->ctscan, $request->mri);

        return $this->sendResponse(new MedicalRecordResource($record), 'Record saved successfully', Response::HTTP_CREATED);
    }
}
