@extends('layouts.dashboard')

@section('title')
    {{ trans('texts.dashboard.files.create.page-title') }}
@endsection

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1>{{ trans('texts.dashboard.files.create.title') }}</x-texts.h1>

        <x-forms.files.create-file-form/>
    </x-grid.dashboard.main>
@endsection
