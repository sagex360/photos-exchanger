@props(['id' => $name, 'name'])
<input name="{{ $name }}" id="{{ $id }}" type="text"
       placeholder="{{ trans('texts.datepicker.date') }}" title="{{ trans('texts.datepicker.date') }}"
       class="form-control form-control-sm table-input-middle @error($name) is-invalid @enderror"
       value="{{ request($name) }}"
       data-datepicker>

@section('head-styles')
    @parent
    <x-styles.bootstrap-datepicker/>
@endsection

@section('bottom-scripts')
    @parent
    <x-scripts.bootstrap-datepicker/>
    <x-scripts.init.datepicker.main/>
@endsection
