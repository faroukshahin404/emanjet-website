/**
 * DataTables initialisation (legacy table IDs only).
 * Do not init #example5 here — admin list pages initialise it with their own options.
 */
$(function () {
    'use strict';

    if (!$.fn.DataTable) {
        return;
    }

    function initOnce(selector, options) {
        var $el = $(selector);
        if (!$el.length || $.fn.dataTable.isDataTable($el)) {
            return;
        }
        $el.DataTable(options || {});
    }

    initOnce('#example1');

    initOnce('#example2', {
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
    });

    if ($('#example').length && typeof $.fn.dataTable.ext.buttons !== 'undefined') {
        initOnce('#example', {
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        });
    }

    initOnce('#tickets', {
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
    });

    initOnce('#productorder', {
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
    });

    initOnce('#complex_header');
});
