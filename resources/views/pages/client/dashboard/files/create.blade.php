@extends('layouts.dashboard')

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1>{{ trans('texts.dashboard.files.create.new') }}</x-texts.h1>

        <x-forms.files.save-file-form :action="route('dashboard.files.store')"
                                      :submitButtonText="trans('texts.dashboard.files.create.submit')"/>
    </x-grid.dashboard.main>
@endsection
