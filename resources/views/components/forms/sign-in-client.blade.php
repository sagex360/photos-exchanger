<form method="post" class="@section('form-class') auth @show ">
    @csrf
    @section('auth-form-header')
        <h2>{{ trans('texts.auth.sign-in') }}</h2>
    @show

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

    @section('password-label')
        <label for="password" class="form-info @error('password') error @enderror">
            {{ trans('texts.auth.password') }}
        </label>
    @show

    @section('password-input')
        <div class="input-group mb-1" data-password-showable
             data-password-link-selector=".show-hide-password-link"
             data-password-icon-selector="i">

            <x-forms.elements.show-hide-password-input name="password"
                                                       :placeholder="trans('texts.auth.password')"/>
        </div>
    @show

    @section('remember-checkbox')
        <input id="remember" name="remember" type="checkbox" @if(old('remember')) checked="checked" @endif>
    @show

    @section('remember-label')
        <label for="remember" class="form-info">{{ trans('texts.auth.remember') }}</label>
    @show

    @section('submit-button')
        <button type="submit" class="btn btn-primary btn-block">{{ trans('texts.auth.submit') }}</button>
    @show
</form>

@section('bottom-scripts')
    @parent
    <script src="{{ asset('js/show-hide-password.js') }}"></script>
@endsection

