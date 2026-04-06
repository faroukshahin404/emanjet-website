<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle mb-0 w-100">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>{{ __('Title') }}</th>
                <th class="text-end">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->translated_name }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin.destinations.edit', $item->id) }}"
                            class="btn btn-sm btn-outline-primary me-1" title="{{ __('Edit') }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.destinations.destroy', $item->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm(@json(__('Are you sure you want to delete this category?')));">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('Delete') }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
