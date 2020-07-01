@extends('layouts.root.generic')

@php
    /**
    * @var \App\Models\FileLinkToken $fileLinkToken
    */
@endphp

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-texts.h1 class="text-center mt-4">{{ trans('texts.guest.view.files.title') }}</x-texts.h1>
                <x-images.main class="my-4" :src="route('api.guest.files.resource', $fileLinkToken->token->token())"/>
            </div>
        </div>
    </div>
@endsection
