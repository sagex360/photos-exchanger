@extends('layouts.dashboard')

@php
    /**
     * @var \App\Models\File $file
     */
@endphp

@section('title')
    {{ trans('texts.dashboard.files.edit.page-title') }} - {{ $file->description->publicName() }}
@endsection

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1>{{ trans('texts.dashboard.files.edit.title') }}</x-texts.h1>

        <x-forms.files.edit-file-form :file="$file"/>
    </x-grid.dashboard.main>
@endsection
