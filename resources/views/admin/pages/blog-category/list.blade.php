<div class="table-responsive">
    <table id="example5" class="table table-bordered table-striped" style="width:100%">
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
                        <a href="{{ route('admin.blog-categories.edit', $item->id) }}" class="btn btn-default btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.blog-categories.destroy', $item->id) }}" method="POST" style="display:inline;">
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
