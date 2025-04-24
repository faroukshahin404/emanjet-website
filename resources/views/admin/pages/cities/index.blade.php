@extends('admin.layouts.master')

@section('title', __('Cities'))
@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="box p-3 mb-3">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Cities') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-12">
                    @include('admin.pages.cities.filters')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                           @include('admin.pages.cities.list')
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

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const successAvailableMsg = "{{ __(':cityName is now available online') }}";
        const successUnavailableMsg = "{{ __(':cityName is now unavailable online') }}";
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
                const cityId = button.data('id');
                const cityName = button.closest('tr').find('td:eq(1)').text().trim();
                const currentStatus = button.hasClass('active');

                $.ajax({
                    url: '/admin/cities/' + cityId + '/toggle-available',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (!currentStatus) {
                                button.addClass('active');
                                button.attr('aria-pressed', 'true');
                                toastr.success(successAvailableMsg.replace(':cityName',
                                    cityName));
                            } else {
                                button.removeClass('active');
                                button.attr('aria-pressed', 'false');
                                toastr.success(successUnavailableMsg.replace(':cityName',
                                    cityName));
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
