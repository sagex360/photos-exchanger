@section('login-label')
    <label for="name" class="form-info">
        {{ trans('texts.auth.login') }}
    </label>
@show

@section('login-input')
    <input id="name" name="email" type="text"
           class="form-control @error('email') is-invalid @enderror"
           placeholder="{{ trans('texts.auth.login-placeholder') }}"
           required="required"
           value="{{ old('email') }}">

    @error('email')
    <span class="invalid-feedback" role="alert"><label for="email">{{ $message }}</label></span>
    @enderror
@show
