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
                    <td class="text-center">
                        <!-- Edit Button -->
                        <a href="{{ route('admin.blog-categories.edit', $item->id) }}" class="btn btn-primary btn-sm">
                            {{ __('Edit') }}
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.blog-categories.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
