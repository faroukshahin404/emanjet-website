<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->translated_name }}</td>
                    {{-- <td class="text-center">
                        <button type="button"
                            class="btn btn-toggle {{ $item->available_online ? 'active' : '' }}"
                            data-bs-toggle="button" data-id="{{ $item->id }}"
                            aria-pressed="{{ $item->available_online ? 'true' : 'false' }}"
                            autocomplete="off">
                            <div class="handle"></div>
                        </button>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
