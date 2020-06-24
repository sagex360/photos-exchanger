@extends('layouts.dashboard')

@php
    /**
     * @var \App\Models\File[] $files
     */
@endphp

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1>{{ trans('texts.dashboard.files.index.title') }} ({{ $filesCount }})</x-texts.h1>

        <x-entities.files.table :files="$files"/>

        <x-buttons.link.main :href="route('dashboard.files.create')">
            {{ trans('texts.dashboard.files.index.add-new') }}
        </x-buttons.link.main>
    </x-grid.dashboard.main>
@endsection
