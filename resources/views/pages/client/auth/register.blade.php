@extends('layouts.auth')

@section('auth-content')
    <x-forms.auth.sign-up-client/>

    <br>
    <p>
        {{ trans('texts.auth.already-have-account') }}
        <a href="{{ route('auth.login') }}">{{ trans('texts.auth.sign-in') }}</a>
    </p>
@overwrite
