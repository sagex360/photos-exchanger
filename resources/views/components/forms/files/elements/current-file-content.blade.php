@php
    /**
     * @var \App\Models\File $file
     */
@endphp

<div class="form-row my-3">
    <div class="col-3 h3">
        {{ trans('texts.dashboard.files.edit.current-content') }}:
    </div>
    <div class="col-9">
        <img src="{{ $file->location->url() }}"
             class="rounded mx-auto d-block img-fluid" alt="{{ $file->description->description() }}">
    </div>
</div>
