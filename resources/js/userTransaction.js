
$(function () {
  'use strict';

  // Variable declaration for table
  var dt_project_table = $('.datatable-project'), nom_utilisateur,
    dt_invoice_table = $('.datatable-invoice');
  const input = document.getElementById("userInputT");
  const inputValue = input.value;
// Invoice datatable
// --------------------------------------------------------------------
if (dt_invoice_table.length) {
  var dt_invoice = dt_invoice_table.DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl + `transaction/user-management/${inputValue}`,

    },
    // JSON file to add data
    columns: [
      // columns according to JSON
      { data: '' },
      { data: 'numero' },
      { data: 'adherant_prenom' },
      { data: 'montant' },
      { data: 'statut' },
      { data: 'type' },
      { data: 'action' }
    ],
    columnDefs: [
      {
        // For Responsive
        className: 'control',
        responsivePriority: 2,
        targets: 0,
        render: function (data, type, full, meta) {
          return '';
        }
      },
      {
        // Invoice ID
        targets: 1,
        render: function (data, type, full, meta) {
          var $invoice_id = full['numero'];
          // Creates full output for row
          var $row_output = '<a href="' + baseUrl + 'app/invoice/preview"><span>#' + $invoice_id + '</span></a>';
          return $row_output;
        }
      },
      {
        // Invoice status
        targets: 2,
        render: function (data, type, full, meta) {
          var $prenom = full['prenom'];
          nom_utilisateur = full['prenom'];

          return $prenom;
        }
      },
      {
        // Total Invoice Amount
        targets: 3,
        render: function (data, type, full, meta) {
          var $total = full['montant'];
          return  $total;
        }
      },

      {
        // Due Date
        targets: 5,
        render: function (data, type, full, meta) {
          var $due_date = new Date(full['created_at']);
          // Creates full output for row
          var $row_output =
            '<span class="d-none">' +
            moment($due_date).format('DD-MM-YYYY') +
            '</span>' +
            moment($due_date).format('DD-MM-YYYY');
          $due_date;
          return $row_output;
        }
      },
      {
        // Actions
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function (data, type, full, meta) {
          return (
            '<div class="d-flex align-items-center">' +
            '<a href="javascript:;" class="text-body" data-bs-toggle="tooltip" title="Send Mail"><i class="ti ti-mail me-2 ti-sm"></i></a>' +
            '<a href="' +
            baseUrl +
            'app/invoice/preview" class="text-body" data-bs-toggle="tooltip" title="Preview"><i class="ti ti-eye mx-2 ti-sm"></i></a>' +
            '<div class="d-inline-block">' +
            '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow text-body" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></a>' +
            '<ul class="dropdown-menu dropdown-menu-end m-0">' +
            '<li><a href="javascript:;" class="dropdown-item">Details</a></li>' +
            '<li><a href="javascript:;" class="dropdown-item">Archive</a></li>' +
            '<div class="dropdown-divider"></div>' +
            '<li><a href="javascript:;" class="dropdown-item text-danger delete-record">Delete</a></li>' +
            '</ul>' +
            '</div>' +
            '</div>'
          );
        }
      }
    ],
    order: [[1, 'desc']],
    dom:
      '<"row mx-4"' +
      '<"col-sm-6 col-12 d-flex align-items-center justify-content-center justify-content-sm-start mb-3 mb-md-0"l>' +
      '<"col-sm-6 col-12 d-flex align-items-center justify-content-center justify-content-sm-end"B>' +
      '>t' +
      '<"row mx-4"' +
      '<"col-md-12 col-lg-6 text-center text-lg-start pb-md-2 pb-lg-0"i>' +
      '<"col-md-12 col-lg-6 d-flex justify-content-center justify-content-lg-end"p>' +
      '>',
    language: {
      sLengthMenu: 'Show _MENU_',
      search: '',
      searchPlaceholder: 'Rechercher une Transaction'
    },
    // Buttons with Dropdown
    buttons: [
      {
        extend: 'collection',
        className: 'btn btn-label-secondary dropdown-toggle float-sm-end mb-3 mb-sm-0',
        text: '<i class="ti ti-screen-share ti-xs me-2"></i>Exporter',
        buttons: [
          {
            extend: 'print',
            title: 'Transactions de l \'utilisateur ',
            text: '<i class="ti ti-printer me-2" ></i>Imprimer',
            className: 'dropdown-item',

            exportOptions: {
              columns: [1, 2, 3, 4,5],
              orientation: 'landscape',
            }
          },
          {
            extend: 'csv',
            text: '<i class="ti ti-file-text me-2" ></i>Csv',
            className: 'dropdown-item',
            exportOptions: { columns: [1, 2, 3, 4,5] }
          },
          {
            extend: 'excel',
            text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
            className: 'dropdown-item',
            exportOptions: { columns: [1, 2, 3, 4,5] }
          },
          {
            extend: 'pdf',
            text: '<i class="ti ti-file-description me-2"></i>Pdf',
            orientation: 'landscape',
            className: 'dropdown-item',
            exportOptions: {  columns: [1, 2, 3, 4,5] }
          },
          {
            extend: 'copy',
            text: '<i class="ti ti-copy me-2" ></i>Copy',
            className: 'dropdown-item',
            exportOptions: { columns: [1, 2, 3, 4,5] }
          }
        ]
      }
    ],
    // For responsive popup
    responsive: {
      details: {
        display: $.fn.dataTable.Responsive.display.modal({
          header: function (row) {
            var data = row.data();
            return 'Details of ' + data['prenom'];
          }
        }),
        type: 'column',
        renderer: function (api, rowIdx, columns) {
          var data = $.map(columns, function (col, i) {
            return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
              ? '<tr data-dt-row="' +
              col.rowIndex +
              '" data-dt-column="' +
              col.columnIndex +
              '">' +
              '<td>' +
              col.title +
              ':' +
              '</td> ' +
              '<td>' +
              col.data +
              '</td>' +
              '</tr>'
              : '';
          }).join('');

          return data ? $('<table class="table"/><tbody />').append(data) : false;
        }
      }
    }
  });
}
// On each datatable draw, initialize tooltip
dt_invoice_table.on('draw.dt', function () {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl, {
      boundary: document.body
    });
  });
});

// Filter form control to default size
// ? setTimeout used for multilingual table initialization
setTimeout(() => {
  $('.dataTables_filter .form-control').removeClass('form-control-sm');
  $('.dataTables_length .form-select').removeClass('form-select-sm');
}, 300);
});
