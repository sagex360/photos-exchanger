@extends('layouts.auth')

@section('auth-content')
    <x-forms.auth.sign-in-client/>

    <br>
    <p>
        {{ trans('texts.auth.has-no-account') }}
        <a href="{{ route('auth.register') }}">{{ trans('texts.auth.sign-up') }}</a>
    </p>
@overwrite
