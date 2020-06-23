@extends('layouts.dashboard')

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1>{{ trans('texts.dashboard.files.create.title') }}</x-texts.h1>

        <x-forms.files.create-file-form/>
    </x-grid.dashboard.main>
@endsection
