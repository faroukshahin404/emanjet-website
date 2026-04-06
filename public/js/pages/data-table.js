/**
 * DataTables initialisation for admin tables (only when matching elements exist).
 */
$(function () {
    'use strict';

    if (!$.fn.DataTable) {
        return;
    }

    if ($('#example1').length) {
        $('#example1').DataTable();
    }

    if ($('#example2').length) {
        $('#example2').DataTable({
            paging: true,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: true,
            autoWidth: false,
        });
    }

    if ($('#example').length && typeof $.fn.dataTable.ext.buttons !== 'undefined') {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        });
    }

    if ($('#tickets').length) {
        $('#tickets').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
        });
    }

    if ($('#productorder').length) {
        $('#productorder').DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
        });
    }

    if ($('#complex_header').length) {
        $('#complex_header').DataTable();
    }

    if ($('#example5').length) {
        $('#example5 tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        var table = $('#example5').DataTable();

        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    }

    if ($('#example6').length) {
        var table6 = $('#example6').DataTable();

        $('button').on('click', function () {
            var data = table6.$('input, select').serialize();
            alert('The following data would have been submitted to the server: \n\n' + data.substr(0, 120) + '...');
            return false;
        });
    }
});
