<div class="table-responsive">
    <table id="example5" class="table table-bordered table-striped" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('views') }}</th>
                <th>{{ __('likes') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->translated_title }}</td>
                    <td>{{ $item->category->translated_name??'-' }}</td>
                    <td>{{ $item->views }}</td>
                    <td>{{ $item->likes }}</td>
                    <td class="text-center">
                        <!-- Edit Button -->
                        <a href="{{ route('admin.blogs.edit', $item->id) }}" class="btn btn-default btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.blogs.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-default btn-sm" onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@push('scripts')
<script>
    $(function () {
        let table = $('#example5').DataTable();
        table.destroy();
        $('#example5').DataTable({
            "paging": false,
            "info": false,
        });
    });
</script>
@endpush
