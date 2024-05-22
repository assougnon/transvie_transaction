/**
 * App Invoice List (jquery)
 */

'use strict';

import Swal from 'sweetalert2';

$(function () {
  // Variable declaration for table
  var dt_invoice_table = $('.invoice-list-table');

  // Invoice datatable
  if (dt_invoice_table.length) {
    var dt_invoice = dt_invoice_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'transaction/management'
      }, // JSON file to add data
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'numero' },
        { data: 'montant' },
        { data: 'type' },
        { data: 'created_at' },
        { data: 'statut' },
        { data: 'note' },
        { data: 'created_at' },


      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          responsivePriority: 2,
          searchable: false,
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
            var $invoice_status = full['statut'],
              $due_date = full['created_at'],
              $balance = full['montant'];
            var roleBadgeObj = {
              Terminee: '<span class="badge badge-center rounded-pill bg-label-secondary w-px-30 h-px-30"><i class="ti ti-circle-check ti-sm"></i></span>',
              Encours:
                '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30"><i class="ti ti-device-floppy ti-sm"></i></span>',
              'Past Due':
                '<span class="badge badge-center rounded-pill bg-label-danger w-px-30 h-px-30"><i class="ti ti-info-circle ti-sm"></i></span>',
              'Partial Payment':
                '<span class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30"><i class="ti ti-circle-half-2 ti-sm"></i></span>',
              Rejetee: '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30"><i class="ti ti-chart-pie ti-sm"></i></span>',
              Impayee:
                '<span class="badge badge-center rounded-pill bg-label-info w-px-30 h-px-30"><i class="ti ti-arrow-down-circle ti-sm"></i></span>'
            };
            return (
              /*"<span data-bs-toggle='tooltip' data-bs-html='true' title='<span>" +
              $invoice_status +
              '<br> <span class="fw-medium">Balance:</span> ' +
              $balance +
              '<br> <span class="fw-medium">Due Date:</span> ' +
              $due_date +
              "</span>'>" +
              roleBadgeObj[$invoice_status] +
              '</span>'*/
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

            return  moment($due_date).format('DD-MM-YYYY');
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
              return '<span class="badge ' + $badge_class + '" text-capitalized>'+$balance+'</span>';
            } else if($balance === 'Encours'){
               $badge_class = 'bg-label-primary';
              return '<span class="badge ' + $badge_class + '" text-capitalized> '+$balance+' </span>';
            }else{
              $badge_class = 'bg-label-danger';
              return '<span class="badge ' + $badge_class + '" text-capitalized> '+$balance+' </span>';
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
        searchPlaceholder: 'Search Invoice'
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
          .columns(5)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="UserRole" class="form-select"><option value=""> Select Status </option></select>'
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
              });
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



});

