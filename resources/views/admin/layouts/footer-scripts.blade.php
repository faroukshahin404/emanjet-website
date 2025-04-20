<script src="{{ asset('js/vendors.min.js') }}"></script>
<script src="{{ asset('js/pages/chat-popup.js') }}"></script>
<script src="{{ asset('assets/icons/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/c3/d3.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/c3/c3.min.js') }}"></script>

<!-- CrmX Admin App -->
<script src="{{ asset('js/jquery.smartmenus.js') }}"></script>
<script src="{{ asset('js/menus.js') }}"></script>
<script src="{{ asset('js/template.js') }}"></script>
{{--
<script src="{{ asset('js/demo.js') }}"></script> --}}

<script src="{{ asset('js/pages/c3-axis.js') }}"></script>


{{--

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/maps.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/kelly.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/dataviz.js"></script>
<script src="{{ asset('assets/vendor_components/apexcharts-bundle/data.js') }}"></script>
<script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor_components/jquery.peity/jquery.peity.js') }}"></script>
<script src="{{ asset('assets/vendor_components/c3/d3.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/c3/c3.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/morris.js/morris.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/jquery.peity/jquery.peity.js') }}"></script>
<script src="{{ asset('assets/vendor_components/echarts/dist/echarts-en.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/apexcharts-bundle/irregular-data-series.js') }}"></script>
<script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor_components/Flot/jquery.flot.js') }}"></script>
<script src="{{ asset('assets/vendor_components/Flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('assets/vendor_components/Flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('assets/vendor_components/Flot/jquery.flot.categories.js') }}"></script>

<!-- CrmX Admin App -->
<script src="{{ asset('js/jquery.smartmenus.js') }}"></script>

<script src="{{ asset('js/template.js') }}"></script>

<script src="{{ asset('js/pages/dashboard3.js') }}"></script>
<script src="{{ asset('js/pages/chart-dash3-int.js') }}"></script>
<script src="{{ asset('js/pages/chart-widgets.js') }}"></script>
<script src="{{ asset('js/pages/chartjs-int.js') }}"></script>
<script src="{{ asset('js/pages/dashboard.js') }}"></script>

<script src="{{ asset('assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('assets/vendor_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}">
</script>
<script src="{{ asset('assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset('assets/vendor_plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('assets/vendor_plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script src="{{ asset('assets/vendor_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
</script>
<script src="{{ asset('assets/vendor_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
</script>
<script src="{{ asset('assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor_plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/advanced-form-element.js') }}"></script>
<script src="{{ asset('assets/vendor_components/dropzone/dropzone.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function showConfirmationAlert(message, callback) {
        event.preventDefault();
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم',
            cancelButtonText: 'لا',
        }).then((result) => {
            if (result.isConfirmed) {
                callback(); // استدعاء الـ callback إذا تم التأكيد
            }
        });
    }

    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
    };

    function showToast(message, type) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            closeOnClickOutside: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: type,
            title: message
        });
    }

    @if (session('success'))
        showToast("{{ session('success') }}", "success");
    @endif
    @if (session('error'))
        showToast("{{ session('error') }}", "error");
    @endif
    @if (session('warning'))
        showToast("{{ session('warning') }}", "warning");
    @endif
    @if (session('info'))
        showToast("{{ session('info') }}", "info");
    @endif
</script>
<script>
    $(document).ready(function() {
        $('[id^="auto_"]').each(function() {
            const name = $(this).attr('id').replace('auto_', '');
            const selectedValue = $(`#auto_${name}_id`).val();
            const table = $(`#table_${name}`).val();
            console.log('Selected Value:', selectedValue);

            if (selectedValue) {
                if (selectedValue.trim() != '') {

                }
                $.ajax({
                    url: `{{ route('get-record') }}`,
                    method: 'GET',
                    data: {
                        table: table,
                        id: selectedValue,
                    },
                    success: function(data) {

                        document.getElementById('auto_' + name).value = data.label;
                        // $(this).val(data.label);

                    },
                    error: function(xhr) {


                    }
                });
            }
        });
    });
</script>
<script>
    document.querySelectorAll("input[type=number]").forEach(function(input) {
        input.addEventListener("input", function() {
            if (parseFloat(this.value) > parseFloat(this.max)) {
                this.value = this.max;
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('keydown', function(e) {
            let currentElement = null;

            $(document).on('input', 'input, select, textarea, [contenteditable="true"]', function() {
                currentElement = this;
                console.log("Typing in element ID:", currentElement.id);

            });

            if (e.key === 'Enter') {
                e.preventDefault();

                const currentElement = document.activeElement;
                console.log(currentElement.value);
                if (currentElement && currentElement.id.startsWith('text_') && (currentElement.value !=
                        '')) {
                    const name = currentElement.id.replace('text_', '');
                    const value = currentElement.value;
                    const table = $(`#table_${name}`).val();
                    const type = $(`#type_${name}`).val() || null;
                    const searchKey = "{{ $searchKey ?? null }}";
                    const condition = "{{ $condition ?? null }}";
                    const conditionValue = "{{ $conditionValue ?? null }}";

                    getElementWithCode(value, table, type, searchKey, name);
                } else {

                    let focusableElements = Array.from(document.querySelectorAll(".focusable"));
                    let currentIndex = focusableElements.indexOf(currentElement);

                    if (currentIndex !== -1 && currentIndex < focusableElements.length - 1) {
                        console.log("Focusing next element:", focusableElements[currentIndex + 1].id);
                        focusableElements[currentIndex + 1].focus();
                    }
                }
            }


        });

    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('keyup', '[id^="text_"]', function(e) {
            console.log(e.key);
            if (e.key === 'Enter') {
                const name = $(this).attr('id').replace('text_', '');
                const value = $(this).val();
                const table = $(`#table_${name}`).val();
                const type = $(`#type_${name}`).val() || null;
                const searchKey = "{{ $searchKey ?? null }}";
                const condition = "{{ $condition ?? null }}";
                const conditionValue = "{{ $conditionValue ?? null }}";

                getElementWithCode(value, table, type, searchKey, name);
            }

        });


        //
        $(document).on('change', '.dynamic-dropdown', function() {
            const dropdown = $(this); // The dropdown that triggered the event
            const name = dropdown.attr('id').replace('dropdown_', ''); // Adjusted ID replacement
            const value = dropdown.val();

            // Find the closest table input relative to the dropdown
            const table = $(`#table_${name}`).val();
            const nextFocus = document.getElementById(`nextFocus_${name}`);

            console.log('Dropdown ID:', name);
            console.log('Selected Value:', value);
            console.log('Table Value:', table);

            if (table !== null && value) {
                getItemCode(table, name);
                console.log(nextFocus);
                moveToNextInput(document.getElementById(`text_${name}`));
                // if(nextFocus){
                //     document.getElementById(nextFocus.value).focus();
                // }

            }
        });

        function moveToNextInput(currentElement) {
            console.log('function started');
            console.log(currentElement.id);
            let focusableElements = Array.from(document.querySelectorAll(".focusable"));
            let currentIndex = focusableElements.indexOf(currentElement);
            if (currentIndex !== -1 && currentIndex < focusableElements.length - 1) {
                console.log(focusableElements[currentIndex + 1].id);
                focusableElements[currentIndex + 1].focus();
            }
        }

        $(document).on('click', '[id^="modal_table_"] tr', function() {
            const name = $(this).closest('table').attr('id').replace('modal_table_', '');
            const selectedId = $(this).data('id');
            $(`#dropdown_${name}`).val(selectedId);
            $(`#search_name_${name}`).val('');
            $(`#search_code_${name}`).val('');
            $(`#model_${name}`).modal('hide');
        });
    });

    function getItemCode(table, name) {
        var dropdown = $(`#dropdown_${name}`);
        var item_id = dropdown.val();
        $.ajax({
            url: `{{ route('master-data.get-code') }}`,
            method: 'GET',
            data: {
                table,
                item_id
            },
            success: function(data) {
                $(`#text_${name}`).val(data);

            },
            error: function(xhr) {
                console.error(xhr);
            }
        });
    }
</script>
<script>
    function getElementWithCode(code, table, type = null, searchKey, name) {
        if (code != '') {
            var condition = $('#condition_' + name).val();
            $.ajax({
                url: `{{ route('master-data.code-search') }}`,
                method: 'GET',
                data: {
                    code,
                    table,
                    type,
                    condition
                },
                success: function(data) {

                    var dropdown = $(`#dropdown_${name}`);

                    dropdown.empty();


                    data.forEach(item => {
                        dropdown.append(
                            `
                         <option value="${item.id}">
                            ${item.label}
                            </option>
                          `
                        );
                    });


                    if (data.length > 0) {
                        dropdown.val(data[0].id);
                        dropdown.trigger('change');
                    }

                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });

        }
    }
</script>

@yield('js')
{{-- @livewireScripts --}}
