@extends('layouts.dashboard')

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1>{{ trans('texts.dashboard.files.edit.title') }}</x-texts.h1>

        <x-forms.files.edit-file-form :file="$file"/>
    </x-grid.dashboard.main>
@endsection
