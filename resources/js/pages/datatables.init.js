/*
Template Name: Ubold - Responsive Bootstrap 4 Admin Dashboard
Author: CoderThemes
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: Datatables init js
*/

$(document).ready(function () {
    // Default Datatable
    $("#basic-datatable").DataTable({
        ordering: false,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });

    //Buttons examples
    var table = $("#datatable-buttons").DataTable({
        ordering: false,
        lengthChange: false,
        buttons: ["copy", "print", "pdf"],
        buttons: [
            { extend: "copy", className: "btn-light" },
            { extend: "print", className: "btn-light" },
            { extend: "pdf", className: "btn-light" },
            { extend: "csv", className: "btn-light" },
        ],
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });

    // Multi Selection Datatable
    $("#selection-datatable").DataTable({
        ordering: false,
        select: {
            style: "multi",
        },
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });

    // Key Datatable
    $("#key-datatable").DataTable({
        ordering: false,
        keys: true,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });

    table
        .buttons()
        .container()
        .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");

    // Alternative Pagination Datatable
    $("#alternative-page-datatable").DataTable({
        ordering: false,
        pagingType: "full_numbers",
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });

    // Scroll Vertical Datatable
    $("#scroll-vertical-datatable").DataTable({
        ordering: false,
        scrollY: "350px",
        scrollCollapse: true,
        paging: false,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });

    // Scroll Horizantal Datatable
    //***************** */ edited by mohammed ahmed*********************
    var scrollableDatatableWithButtons = $(
        "#scroll-horizontal-datatable"
    ).DataTable({
        scrollX: true,
        ordering: false,
        lengthChange: false,
        buttons: ["copy", "print", "pdf"],
        buttons: [
            { extend: "copy", className: "btn-light" },
            { extend: "print", className: "btn-light" },
            { extend: "pdf", className: "btn-light" },
            { extend: "csv", className: "btn-light" },
        ],
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });
    scrollableDatatableWithButtons
        .buttons()
        .container()
        .appendTo(" .col-md-6:eq(0)");

    // Complex headers with column visibility Datatable
    $("#complex-header-datatable").DataTable({
        ordering: false,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
        columnDefs: [
            {
                visible: false,
                targets: -1,
            },
        ],
    });

    // Row created callback Datatable
    $("#row-callback-datatable").DataTable({
        ordering: false,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
        createdRow: function (row, data, index) {
            if (data[5].replace(/[\$,]/g, "") * 1 > 150000) {
                $("td", row).eq(5).addClass("text-danger");
            }
        },
    });

    // Default Datatable
    $("#state-saving-datatable").DataTable({
        ordering: false,
        stateSave: true,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>",
            },
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass(
                "pagination-rounded"
            );
        },
    });
});
