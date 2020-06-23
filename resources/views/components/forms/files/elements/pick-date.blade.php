@props(['file' => optional($file ?? null)])
@php
    /**
     * @var \App\Models\File $file
     */
@endphp

<div class="form-group form-row align-items-start">
    <label for="name" class="form-info h3 m-0 col-5">
        {{ trans('texts.dashboard.files.select-date-to-delete') }}:
    </label>
    <div class="col-7">
        <x-forms.elements.datepicker name="date_to_delete"
                                     :value="old('date_to_delete', optional($file->will_be_deleted_at)->format('Y-m-d'))"/>

        <x-forms.elements.error-feedback name="date_to_delete"/>
    </div>
</div>
