<form action="{{ $action ?? '' }}" method="post" class="text-dark form" enctype="multipart/form-data">
    @csrf

    <div class="form-group form-row align-items-start">
        <label for="file" class="form-info h3 m-0 col-3">
            {{ trans('texts.dashboard.files.select-file') }}:
        </label>
        <div class="col-9">
            <input id="file" name="file" class="form-control @error('file') is-invalid @enderror" type="file">

            <x-forms.elements.error-feedback name="file"/>
        </div>
    </div>

    <div class="form-group form-row align-items-start">
        <label for="content" class="form-info h3 mb-2 mt-0 col-12">
            {{ trans('texts.dashboard.files.enter-description') }}:
        </label>
        <div class="col-12">
            <x-forms.elements.textarea name="content">
                {{ old('content', $post->content ?? '') }}
            </x-forms.elements.textarea>

            <x-forms.elements.error-feedback name="content"/>
        </div>
    </div>

    <div class="form-group form-row align-items-start">
        <label for="name" class="form-info h3 m-0 col-5">
            {{ trans('texts.dashboard.files.select-date-to-delete') }}:
        </label>
        <div class="col-7">
            <x-forms.elements.datepicker name="date_to_delete"/>

            <x-forms.elements.error-feedback name="date_to_delete"/>
        </div>
    </div>

    <x-buttons.submit.main>
        {{ $submitButtonText }}
    </x-buttons.submit.main>
</form>
