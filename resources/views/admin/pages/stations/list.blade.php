<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle mb-0 w-100">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>{{ __('Name') }}</th>
                <th class="text-center">{{ __('Available Online') }}</th>
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
                            data-url="{{ route('admin.stations.toggle-available', $item) }}"
                            aria-pressed="{{ $item->available_online ? 'true' : 'false' }}"
                            autocomplete="off">
                            <span class="toggle-on">{{ __('On') }}</span>
                            <span class="toggle-off">{{ __('Off') }}</span>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
