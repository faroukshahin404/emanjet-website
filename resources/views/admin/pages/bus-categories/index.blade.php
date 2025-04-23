@extends('admin.layouts.master')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .btn-toggle {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
            background-color: #e9ecef;
            border-radius: 15px;
            transition: background-color 0.25s;
        }

        .btn-toggle:focus,
        .btn-toggle.focus {
            outline: 0;
        }

        .btn-toggle.active {
            background-color: #0d6efd;
        }

        .btn-toggle .toggle-on {
            position: absolute;
            left: 10px;
            top: 6px;
            color: white;
            font-size: 12px;
            font-weight: bold;
            opacity: 0;
        }

        .btn-toggle.active .toggle-on {
            opacity: 1;
        }

        .btn-toggle.active .toggle-off {
            opacity: 0;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">{{ __('Bus Categories Management') }}</h4>
                        <a href="{{ route('admin.bus-categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('Create New Category') }}
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Name (Arabic)') }}</th>
                                        <th>{{ __('Name (English)') }}</th>
                                        <th>{{ __('Rate') }}</th>
                                        <th>{{ __('Passengers') }}</th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Available Online') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($results as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name_ar }}</td>
                                            <td>{{ $item->name_en }}</td>
                                            <td>{{ $item->rate }}</td>
                                            <td>{{ $item->passengers }}</td>
                                            <td>
                                                @if($item->image)
                                                    <img src="{{ asset('storage/'.$item->image) }}" 
                                                         alt="{{ $item->name_en }}" 
                                                         style="max-height: 50px; max-width: 100px;">
                                                @else
                                                    <span class="badge bg-secondary">{{ __('No Image') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-toggle {{ $item->available_online ? 'active' : '' }}"
                                                    data-bs-toggle="button" data-id="{{ $item->id }}"
                                                    aria-pressed="{{ $item->available_online ? 'true' : 'false' }}"
                                                    autocomplete="off">
                                                    <div class="handle"></div>
                                                </button>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.bus-categories.edit', $item->id) }}" 
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                                                    </a>
                                                    <form action="{{ route('admin.bus-categories.destroy', $item->id) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i> {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">{{ __('No bus categories found') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $results->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const successAvailableMsg = "{{ __(':itemName is now available online') }}";
        const successUnavailableMsg = "{{ __(':itemName is now unavailable online') }}";
        const errorMsg = "{{ __('Failed to update status') }}";

        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            $('.btn-toggle').on('click', function() {
                const button = $(this);
                const itemId = button.data('id');
                const itemName = button.closest('tr').find('td:eq(2)').text().trim();
                const currentStatus = button.hasClass('active');

                $.ajax({
                    url: '/admin/bus-categories/' + itemId + '/toggle-available',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (!currentStatus) {
                                button.addClass('active');
                                button.attr('aria-pressed', 'true');
                                toastr.success(successAvailableMsg.replace(':itemName', itemName));
                            } else {
                                button.removeClass('active');
                                button.attr('aria-pressed', 'false');
                                toastr.success(successUnavailableMsg.replace(':itemName', itemName));
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating availability:', xhr.responseText);
                        toastr.error(errorMsg);
                    }
                });
            });
        });
    </script>
@endpush