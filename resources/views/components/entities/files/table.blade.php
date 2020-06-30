@php
    /**
     * @var \App\Models\File[] $files
     */
@endphp
<table class="table ">
    <thead>
    <tr>
        <th scope="col">{{ trans('texts.dashboard.files.table.name') }}</th>
        <th scope="col">{{ trans('texts.dashboard.files.table.description') }}</th>
        <th scope="col">{{ trans('texts.dashboard.files.table.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($files as $file)
        <tr>
            <td>{{ $file->description->publicName() }}</td>
            <td><p>{{ $file->description->shortDescription() }}</p></td>
            <td>
                <x-buttons.link.action.view :href="route('dashboard.files.show', $file)">
                    {{ trans('texts.dashboard.files.table.buttons.view') }}
                </x-buttons.link.action.view>

                <x-buttons.link.action.edit :href="route('dashboard.files.edit', $file)">
                    {{ trans('texts.dashboard.files.table.buttons.edit') }}
                </x-buttons.link.action.edit>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3">
                {{ trans('texts.dashboard.files.table.empty') }}
            </td>
        </tr>
    @endforelse
</table>
