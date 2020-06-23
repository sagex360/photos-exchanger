@props(['file' => optional($file ?? null)])
@php
    /**
     * @var \App\Models\File $file
     */
@endphp

<div class="form-group form-row align-items-start">
    <label for="description" class="form-info h3 mb-2 mt-0 col-12">
        {{ trans('texts.dashboard.files.enter-description') }}:
    </label>
    <div class="col-12">
        <x-forms.elements.textarea name="description"
                                   required="required"
                                   :placeholder="trans('texts.dashboard.files.enter-description')">
            {{ old('description', optional($file->description)->description()) }}
        </x-forms.elements.textarea>

        <x-forms.elements.error-feedback name="description"/>
    </div>
</div>
