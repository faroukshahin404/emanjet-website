<table class="table table-hover table-bordered align-middle mb-0">
    <thead class="table-light">
        <tr>
            <th>{{ __('Name Ar') }}</th>
            <th>{{ __('Name En') }}</th>
            <th>{{ __('Rate') }}</th>
            <th>{{ __('Passengers') }}</th>
            <th class="text-end">{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $item)
            <tr>
                <td>{{ $item->name_ar }}</td>
                <td>{{ $item->name_en }}</td>
                <td>{{ $item->rate }}</td>
                <td>{{ $item->passengers }}</td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.bus-categories.edit', $item->id) }}"
                        class="btn btn-sm btn-outline-primary me-1">{{ __('Edit') }}</a>
                    <form action="{{ route('admin.bus-categories.destroy', $item->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm(@json(__('Are you sure you want to delete this category?')));">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
