<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>{{ __('Name Ar') }}</th>
                <th>{{ __('Name En') }}</th>
                <th>{{ __('Rate') }}</th>
                <th>{{ __('Passengers') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $item)
                <tr>
                    <td>{{ $item->name_ar }}</td>
                    <td>{{ $item->name_en }}</td>
                    <td>{{ $item->rate }}</td>
                    <td>{{ $item->passengers }}</td>
                    <td class="text-center">
                        <!-- Edit Button -->
                        <a href="{{ route('admin.bus-categories.edit', $item->id) }}" class="btn btn-primary btn-sm">
                            {{ __('Edit') }}
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.bus-categories.destroy', $item->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
