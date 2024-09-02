/**
 * App Invoice List (jquery)
 */

'use strict';

import Swal from 'sweetalert2';

$(function () {
  // Variable declaration for table

var dt_invoice_table = $('.invoice-list-table');
var dt_transaction_table = $('.transaction-list-table');
  var dt_adv_filter_table = $('.dt-advanced-search'),
    startDateEle = $('.start_date'),
    endDateEle = $('.end_date');

  var rangePickr = $('.flatpickr-range'),
    dateFormat = 'DD/MM/YYYY';

  if (rangePickr.length) {
    rangePickr.flatpickr({
      mode: 'range',
      dateFormat: 'm/d/Y',
      orientation: isRtl ? 'auto right' : 'auto left',
      locale: French,
      onClose: function (selectedDates, dateStr, instance) {
        var startDate = '',
          endDate = new Date();
        if (selectedDates[0] != undefined) {
          startDate = moment(selectedDates[0]).format('DD/MM/YYYY');
          startDateEle.val(startDate);
        }
        if (selectedDates[1] != undefined) {
          endDate = moment(selectedDates[1]).format('DD/MM/YYYY');
          endDateEle.val(endDate);
        }
        $(rangePickr).trigger('change').trigger('keyup');
      }
    });
  }

  function filterColumn(i, val) {
    if (i === 5) {
      var startDate = startDateEle.val(),
        endDate = endDateEle.val();
      if (startDate !== '' && endDate !== '') {
        $.fn.dataTableExt.afnFiltering.length = 0; // Reset datatable filter
        dt_adv_filter_table.dataTable().fnDraw(); // Draw table after filter
        filterByDate(i, startDate, endDate); // We call our filter function
      }
      dt_adv_filter_table.dataTable().fnDraw();
    } else {
      dt_adv_filter_table.DataTable().column(i).search(val, false, true).draw();
    }
  }

  // Advance filter function
  // We pass the column location, the start date, and the end date
  $.fn.dataTableExt.afnFiltering.length = 0;
  var filterByDate = function (column, startDate, endDate) {
    // Custom filter syntax requires pushing the new filter to the global filter array
    $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
      var rowDate = normalizeDate(aData[column]),
        start = normalizeDate(startDate),
        end = normalizeDate(endDate);

      // If our date from the row is between the start and end
      if (start <= rowDate && rowDate <= end) {
        return true;
      } else if (rowDate >= start && end === '' && start !== '') {
        return true;
      } else if (rowDate <= end && start === '' && end !== '') {
        return true;
      } else {
        return false;
      }
    });
  };

  // converts date strings to a Date object, then normalized into a YYYYMMMDD format (ex: 20131220). Makes comparing dates easier. ex: 20131220 > 20121220
  var normalizeDate = function (dateString) {
    var date = new Date(dateString);
    var normalized =
      date.getFullYear() + '' + ('0' + (date.getMonth() + 1)).slice(-2) + '' + ('0' + date.getDate()).slice(-2);
    return normalized;
  };
  // Advanced Search
  // --------------------------------------------------------------------

  // Advanced Filter table
  if (dt_adv_filter_table.length) {
    var dt_adv_filter = dt_adv_filter_table.DataTable({
      dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6 dataTables_pager'p>>",

      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'transaction/management'
      },
      columns: [
        { data: '' },
        { data: 'numero' },
        { data: 'prenom' },
        { data: 'montant' },
        { data: 'banque' },
        { data: 'created_at' },
        { data: 'statut' }
      ],

      columnDefs: [
        {
          className: 'control',
          orderable: false,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          // Due Date
          targets: 5,
          render: function (data, type, full, meta) {


            return  moment(full['created_at']).format(dateFormat);
          }
        },
      ],
      order: [[1, 'desc']],
      orderCellsTop: true,
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['full_name'];
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
      },

      initComplete: function () {
        this.api()
          .columns(5)
          .every(function () {
            let column = this;
            $('input.dt-input').on('keyup', function () {


              if (column.search() !== this.value) {

                filterColumn($(this).attr('data-column'), $(this).val());

              }
            });
          });
      }
    });
  }

  // on key up from input field
/*  $('input.dt-input').on('keyup', function () {
console.log($(this).attr('data-column'));

    filterColumn($(this).attr('data-column'), $(this).val());
  });*/



  // Invoice datatable
  if (dt_invoice_table.length) {
    var dt_invoice = dt_invoice_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'transaction/management'
      },
      columns: [
        { data: '' },
        { data: 'numero' },
        { data: 'adherant_prenom' },
        { data: 'montant' },
        { data: 'type' },
        { data: 'created_at' },
        { data: 'statut' },
        { data: 'note' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          responsivePriority: 2,
          orderable: false,
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
            var $row_output = '<a href="' + baseUrl + 'facture/transaction/'+$invoice_id+'">#' + $invoice_id + '</a>';
            return $row_output;
          }
        },
        {
          // Client name
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {

            // For Avatar badge

            var $name = full['prenom'],
              $initials = $name.match(/\b\w/g) || [];
            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
            var  $output = '<span class="avatar-initial rounded-circle ">' + $initials + '</span>';

            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar me-2">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-medium">' +
              $name +
              '</span>' +
              '<small class="text-truncate text-muted">' +
              '</small>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // Invoice status
          targets: 3,
          render: function (data, type, full, meta) {
            return (
              full['banque']
            );
          }
        },

        {
          // Total Invoice Amount
          targets: 4,
          render: function (data, type, full, meta) {
            var $total = full['montant'];
            return '<span class="d-none">' + $total + '</span>' + $total+' CFA';
          }
        },
        {
          // Due Date
          targets: 5,
          orderable:true,
          render: function (data, type, full, meta) {
            var $due_date = new Date(full['created_at']);

            return  moment(full['created_at']).format(dateFormat);
          }
        },
        {
          // Client Balance/Status
          targets: 6,
          orderable: false,
          render: function (data, type, full, meta) {
            var $balance = full['statut'];
            if ($balance === 'Terminee') {
              var $badge_class = 'bg-label-success';
              return '<span class="badge ' + $badge_class + ' text-uppercase">'+$balance+'</span>';
            } else if($balance === 'Encours'){
               $badge_class = 'bg-label-primary';
              return '<span class="badge ' + $badge_class + ' text-uppercase">'+$balance+' </span>';
            }else{
              $badge_class = 'bg-label-danger';
              return '<span class="badge ' + $badge_class + ' text-uppercase"> '+$balance+' </span>';
            }
          }
        },

        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center">' +
              '<a href="' +
              baseUrl +
              'facture/transaction/'+full['numero']+'" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a>' +

              `<button class="btn btn-sm btn-icon edit-record" data-id="${full['numero']}" ><a href="transaction/${full['numero']}"><i class="ti ti-edit"></i></a></button>` +
              `<button class="btn btn-sm btn-icon delete-transaction" data-id="${full['numero']}"><i class="ti ti-trash"></i></button>` +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'desc']],
      dom:
        '<"row mx-1"' +
        '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
        '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: '',
        searchPlaceholder: 'Recherché une Transaction'
      },
      // Buttons with Dropdown
      buttons: [
        {
          text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Ajouter une Transaction</span>',
          className: 'btn btn-primary',
          action: function (e, dt, button, config) {
            window.location = baseUrl + 'transaction-list/create';
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details de ' + data['prenom'];
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
      },
      initComplete: function () {
        // Adding role filter once table initialized
        this.api()
          .columns(6)
          .every(function () {
            /*var column = this;
            var select = $(
              '<select id="UserRole" class="form-select"><option value=""> Selectionne le statut </option></select>'
            )
              .appendTo('.invoice_status')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());


                column.search( val ? '^'+val+'$' : '', true, false ).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
              });*/
          });
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

  // Delete Record
  $('.invoice-list-table tbody').on('click', '.delete-record', function () {
    dt_invoice.row($(this).parents('tr')).remove().draw();
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);



  $(document).on('click', '.delete-transaction', function () {
    var transaction_id = $(this).data('id');



    // hide responsive modal in small screen


    // sweetalert for confirmation of delete
    Swal.fire({
      title: 'êtes vous sur ?',
      text: "La suppression est irreversible !",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Oui , Je supprime !',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          type: 'GET',
          url: `${baseUrl}transaction-delete/${transaction_id}`,
          success: function (data) {
            Swal.fire({
              icon: 'success',
              title: 'Supprimer!',
              text: data.message+' '+transaction_id+' a bien été Supprimée !',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
            dt_invoice.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert

      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Annuler',
          text: 'La transaction  n\'a pas été supprimé!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

//all transaction

  if (dt_transaction_table.length) {
    let dt_transaction = dt_transaction_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'transactions/show/all'
      },
      columns: [
        { data: '' },
        { data: 'numero' },
        { data: 'adherant_prenom' },
        { data: 'montant' },
        { data: 'type' },
        { data: 'created_at' },
        { data: 'statut' },
        { data: 'note' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          responsivePriority: 2,
          orderable: false,
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
            var $row_output = '<a href="' + baseUrl + 'facture/transaction/'+$invoice_id+'">#' + $invoice_id + '</a>';
            return $row_output;
          }
        },
        {
          // Client name
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {

            // For Avatar badge

            var $name = full['prenom'],
              $initials = $name.match(/\b\w/g) || [];
            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
            var  $output = '<span class="avatar-initial rounded-circle ">' + $initials + '</span>';

            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar me-2">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-medium">' +
              $name +
              '</span>' +
              '<small class="text-truncate text-muted">' +
              '</small>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // Invoice status
          targets: 3,
          render: function (data, type, full, meta) {
            return (
              full['banque']
            );
          }
        },

        {
          // Total Invoice Amount
          targets: 4,
          render: function (data, type, full, meta) {
            var $total = full['montant'];
            return '<span class="d-none">' + $total + '</span>' + $total+' CFA';
          }
        },
        {
          // Due Date
          targets: 5,
          orderable:true,
          render: function (data, type, full, meta) {
            var $due_date = new Date(full['created_at']);

            return  moment(full['created_at']).format(dateFormat);
          }
        },
        {
          // Client Balance/Status
          targets: 6,
          orderable: false,
          render: function (data, type, full, meta) {
            var $balance = full['statut'];
            if ($balance === 'Terminee') {
              var $badge_class = 'bg-label-success';
              return '<span class="badge ' + $badge_class + ' text-uppercase">'+$balance+'</span>';
            } else if($balance === 'Encours'){
              $badge_class = 'bg-label-primary';
              return '<span class="badge ' + $badge_class + ' text-uppercase">'+$balance+' </span>';
            }else{
              $badge_class = 'bg-label-danger';
              return '<span class="badge ' + $badge_class + ' text-uppercase"> '+$balance+' </span>';
            }
          }
        },

        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center">' +
              '<a href="' +
              baseUrl +
              'facture/transaction/'+full['numero']+'" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Voir la Transaction"><i class="ti ti-eye mx-2 ti-sm"></i></a>' +

              `<button class="btn btn-sm btn-icon edit-record" data-id="${full['numero']}" ><a href="${baseUrl}transaction/${full['numero']}"><i class="ti ti-edit"></i></a></button>` +
              `<button class="btn btn-sm btn-icon delete-transaction" data-id="${full['numero']}"><i class="ti ti-trash"></i></button>` +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'desc']],
      dom:
        '<"row mx-1"' +
        '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' +
        '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: '',
        searchPlaceholder: 'Recherché une Transaction'
      },
      // Buttons with Dropdown
      buttons: [
        {
          text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Ajouter une Transaction</span>',
          className: 'btn btn-primary',
          action: function (e, dt, button, config) {
            window.location = baseUrl + 'transaction-list/create';
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details de ' + data['prenom'];
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
      },
      initComplete: function () {
        // Adding role filter once table initialized
        this.api()
          .columns(6)
          .every(function () {
            /*var column = this;
            var select = $(
              '<select id="UserRole" class="form-select"><option value=""> Selectionne le statut </option></select>'
            )
              .appendTo('.invoice_status')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());


                column.search( val ? '^'+val+'$' : '', true, false ).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + d + '" class="text-capitalize">' + d + '</option>');
              });*/
          });
      }
    });
  }



});

