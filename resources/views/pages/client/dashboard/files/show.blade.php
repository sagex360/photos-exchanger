@extends('layouts.dashboard')

@php
    /**
     * @var \App\Models\File $file
     */
@endphp

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1 class="text-center">{{ trans('texts.dashboard.files.show.title') }}
            <x-buttons.link.main class="ml-4" href="{{ route('dashboard.files.edit', $file) }}">Edit
            </x-buttons.link.main>
        </x-texts.h1>

        <div class="row">
            <div class="col-3">
                <h2>{{ trans('texts.dashboard.files.show.name') }}:</h2>
            </div>
            <div class="col-9">
                <p class="h3">{{ $file->description->publicName() }}</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-3">
                <h2>{{ trans('texts.dashboard.files.show.description') }}:</h2>
            </div>
            <div class="col-9">
                <p class="h4">{{ $file->description->description() }}</p>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <label for="will-be-deleted-at-input"
                       class="h3">{{ trans('texts.dashboard.files.show.will-be-deleted-at') }}:</label>
            </div>
            <div class="col-3">
                <input id="will-be-deleted-at-input" class="form-control" type="text"
                       value="{{ $file->will_be_deleted_at->readable() }}" readonly>
            </div>
            <div class="col-3 offset-1">
                <x-buttons.delete.outline sendForm="#delete-file-now-form" class="btn-xs">
                    {{ trans('texts.dashboard.files.show.delete-now') }}
                </x-buttons.delete.outline>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <x-texts.h2>{{ trans('texts.dashboard.files.show.contents') }}:</x-texts.h2>
            </div>
            <div class="col-12">
                <x-images.main :src="$file->location->url()"
                               :alt="$file->description->publicName()"/>
            </div>
        </div>

    </x-grid.dashboard.main>
    <x-forms.common.delete id="delete-file-now-form" :action="route('dashboard.files.destroy', $file)"/>
@endsection
