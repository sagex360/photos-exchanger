@section('password-label')
    <label for="password" class="form-info @error('password') error @enderror">
        {{ trans('texts.auth.password') }}
    </label>
@show

@section('password-input')
    <div class="input-group mb-1" data-password-showable
         data-password-link-selector=".show-hide-password-link"
         data-password-icon-selector="i">

        <x-forms.auth.elements.show-hide-password-input name="password"
                                                        :placeholder="trans('texts.auth.password')"/>
    </div>
@show

@section('bottom-scripts')
    @parent
    <script src="{{ asset('js/show-hide-password.js') }}"></script>
@endsection
