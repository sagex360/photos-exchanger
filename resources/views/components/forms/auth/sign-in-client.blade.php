<form method="post" class="@section('form-class') auth @show ">
    @csrf
    @section('auth-form-header')
        <h2>{{ trans('texts.auth.sign-in') }}</h2>
    @show

    <x-forms.auth.elements.login-input/>

    <x-forms.auth.elements.password-input/>

    @section('remember-checkbox')
        <input id="remember" name="remember" type="checkbox" @if(old('remember')) checked="checked" @endif>
    @show

    @section('remember-label')
        <label for="remember" class="form-info">{{ trans('texts.auth.remember') }}</label>
    @show

    <x-forms.auth.elements.submit-button/>
</form>
