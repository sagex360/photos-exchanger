<x-forms.files.elements.form-frame :action="route('dashboard.files.store')">
    @csrf

    <x-forms.files.elements.browse-file/>

    <x-forms.files.elements.input-public-name/>

    <x-forms.files.elements.input-description/>

    <x-forms.files.elements.pick-date/>

    <div class="row">
        <div class="col-12">
            <x-buttons.submit.main>
                {{ trans('texts.dashboard.files.create.submit') }}
            </x-buttons.submit.main>
        </div>
    </div>
</x-forms.files.elements.form-frame>
