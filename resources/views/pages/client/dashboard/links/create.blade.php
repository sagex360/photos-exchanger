@extends('layouts.dashboard')

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1>{{ trans('texts.dashboard.file-links.create-form.title') }}</x-texts.h1>

        <x-forms.links.create-link-to-file :file="$file"/>
    </x-grid.dashboard.main>
@endsection
