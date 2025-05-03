<table id="example5" class="table table-bordered table-striped" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Available Online') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td class="text-center">
                    <button type="button"
                        class="btn btn-toggle {{ $item->available_online ? 'active' : '' }}"
                        data-bs-toggle="button" data-id="{{ $item->id }}"
                        aria-pressed="{{ $item->available_online ? 'true' : 'false' }}" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
