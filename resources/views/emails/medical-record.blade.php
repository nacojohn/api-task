@component('mail::message')
# New Medical Record

**Patient Name:** {{$data['patient']['name']}}

## Medical Record

@component('mail::table')
| Category       | Tests        |
| ------------- |:-------------:|
@foreach ($data['medical_records'] as $key => $value)
| {{$key}}      | {{ implode(', ', array_column($value->toArray(), 'title')) }}      |
@endforeach
@endcomponent

**CT Scan:** {{$data['ctscan']}}<br>
**MRI:** {{$data['mri']}}

Thanks,<br>
Nnanna John<br>
{{ config('app.name') }}
@endcomponent
