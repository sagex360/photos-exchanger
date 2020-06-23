@php
    /**
     * @var \App\Models\File $file
     */
@endphp

<x-forms.files.elements.form-frame :action="route('dashboard.files.update', $file)">
    @csrf
    @method('PUT')

    <x-forms.files.elements.current-file-content :file="$file"/>

    <x-forms.files.elements.input-description :file="$file"/>

    <x-forms.files.elements.pick-date :file="$file"/>

    <div class="row">
        <div class="col-7">
            <x-buttons.submit.main>
                {{ trans('texts.dashboard.files.edit.submit') }}
            </x-buttons.submit.main>
        </div>
        <div class="col-5">
            <x-buttons.delete.main sendForm="#delete-file-hidden-form">
                {{ trans('texts.dashboard.files.delete.button') }}
            </x-buttons.delete.main>
        </div>
    </div>

</x-forms.files.elements.form-frame>

<x-forms.common.delete id="delete-file-hidden-form"
                       :action="route('dashboard.files.destroy', $file)"/>
