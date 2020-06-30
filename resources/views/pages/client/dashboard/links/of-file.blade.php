@extends('layouts.dashboard')

@php
    /**
     * @var \App\Models\FileLinkToken[] $linkTokens
     */
@endphp

@section('dashboard-content')
    <x-grid.dashboard.main>
        <x-texts.h1>{{ trans('texts.dashboard.file-links.title') }}:</x-texts.h1>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">{{ trans('texts.dashboard.file-links.table.link-url') }}</th>
                <th scope="col">{{ trans('texts.dashboard.file-links.table.type') }}</th>
                <th scope="col">{{ trans('texts.dashboard.file-links.table.status') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($linkTokens as $linkToken)
                <tr>
                    <td><p>{{ $linkToken->link() }}</p></td>
                    <td><p>{{ $linkToken->typeReadable() }}</p></td>
                    <td><p>{{ $linkToken->statusReadable() }}</p></td>
                </tr>
            @empty
                <tr>
                    <td colspan="3"><p>{{ trans('texts.dashboard.file-links.list-empty') }}</p></td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <x-buttons.link.main class="mt-4"
                             href="{{ route('dashboard.links.create', $file) }}">
            {{ trans('texts.dashboard.file-links.create-new-btn') }}
        </x-buttons.link.main>
    </x-grid.dashboard.main>
@endsection
