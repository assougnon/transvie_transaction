(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else {
		var a = factory();
		for(var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
	}
})(self, function() {
return /******/ (function() { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/remise-liste.js ***!
  \**************************************/


// Datatable (jquery)
$(function () {
  var dt_remise_table = $('.remise-list-table'),
    dateFormat = 'DD/MM/YYYY';
  if (dt_remise_table.length) {
    var dt_invoice = dt_remise_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'remises-liste'
      },
      columns: [{
        data: ''
      }, {
        data: 'numero'
      }, {
        data: 'adherant_prenom'
      }, {
        data: 'montant'
      }, {
        data: 'type'
      }, {
        data: 'created_at'
      }, {
        data: 'statut'
      }, {
        data: 'note'
      }],
      columnDefs: [{
        // For Responsive
        className: 'control',
        responsivePriority: 2,
        orderable: false,
        targets: 0,
        render: function render(data, type, full, meta) {
          return '';
        }
      }, {
        // Invoice ID
        targets: 1,
        render: function render(data, type, full, meta) {
          var $invoice_id = full['numero'];
          // Creates full output for row
          var $row_output = '<a href="' + baseUrl + 'facture/transaction/' + $invoice_id + '">#' + $invoice_id + '</a>';
          return $row_output;
        }
      }, {
        // Client name
        targets: 2,
        responsivePriority: 4,
        render: function render(data, type, full, meta) {
          // For Avatar badge

          var $name = full['prenom'],
            $initials = $name.match(/\b\w/g) || [];
          $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
          var $output = '<span class="avatar-initial rounded-circle ">' + $initials + '</span>';

          // Creates full output for row
          var $row_output = '<div class="d-flex flex-column">' + '<span class="fw-medium">' + $name + '</span>' + '<small class="text-truncate text-muted">' + '</small>' + '</div>';
          return $row_output;
        }
      }, {
        // Invoice status
        targets: 3,
        render: function render(data, type, full, meta) {
          var $output = "<div class=\"d-flex justify-content-start align-items-center\">\n          <div class=\"avatar-wrapper\">\n          <div class=\"avatar me-2\">\n\n          <img src=\"".concat(baseUrl + full['remise'], "\" alt=\"\" data-id=\"").concat(full['remise'], "\" data-bs-toggle=\"modal\" data-bs-target=\"#pricingModal\" class=\"show-modal rounded-pill\">\n          </div>\n          </div>\n            </div>");
          return $output;
        }
      }, {
        // Total Invoice Amount
        targets: 4,
        render: function render(data, type, full, meta) {
          var $total = full['montant'];
          return '<span class="d-none">' + $total + '</span>' + $total + ' CFA';
        }
      }, {
        // Due Date
        targets: 5,
        orderable: true,
        render: function render(data, type, full, meta) {
          var $due_date = new Date(full['created_at']);
          return moment(full['created_at']).format(dateFormat);
        }
      }, {
        // Client Balance/Status
        targets: 6,
        orderable: false,
        render: function render(data, type, full, meta) {
          var $balance = full['statut'];
          if ($balance === 'Terminee') {
            var $badge_class = 'bg-label-success';
            return '<span class="badge ' + $badge_class + ' text-uppercase">' + $balance + '</span>';
          } else if ($balance === 'Encours') {
            $badge_class = 'bg-label-primary';
            return '<span class="badge ' + $badge_class + ' text-uppercase">' + $balance + ' </span>';
          } else {
            $badge_class = 'bg-label-danger';
            return '<span class="badge ' + $badge_class + ' text-uppercase"> ' + $balance + ' </span>';
          }
        }
      }, {
        // Actions
        targets: -1,
        title: 'Actions',
        searchable: false,
        orderable: false,
        render: function render(data, type, full, meta) {
          return '<div class="d-flex align-items-center">' + '<a href="' + baseUrl + 'facture/transaction/' + full['numero'] + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a>' + "<button class=\"btn btn-sm btn-icon edit-record\" data-id=\"".concat(full['numero'], "\" ><a href=\"transaction/").concat(full['numero'], "\"><i class=\"ti ti-edit\"></i></a></button>") + "<button class=\"btn btn-sm btn-icon delete-transaction\" data-id=\"".concat(full['numero'], "\"><i class=\"ti ti-trash\"></i></button>") + '</div>';
        }
      }],
      order: [[1, 'desc']],
      dom: '<"row mx-1"' + '<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>>' + '<"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: '',
        searchPlaceholder: 'Recherché une Transaction'
      },
      // Buttons with Dropdown
      buttons: [{
        text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Ajouter une Transaction</span>',
        className: 'btn btn-primary',
        action: function action(e, dt, button, config) {
          window.location = baseUrl + 'transaction-list/create';
        }
      }],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function header(row) {
              var data = row.data();
              return 'Details de ' + data['prenom'];
            }
          }),
          type: 'column',
          renderer: function renderer(api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
              ? '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' + '<td>' + col.title + ':' + '</td> ' + '<td>' + col.data + '</td>' + '</tr>' : '';
            }).join('');
            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      },
      initComplete: function initComplete() {
        // Adding role filter once table initialized
        this.api().columns(6).every(function () {
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
  dt_remise_table.on('draw.dt', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl, {
        boundary: document.body
      });
    });
  });
  $(document).on('click', '.show-modal', function () {
    document.getElementById('imageRemise').innerHTML = "";
    var image = $(this).attr('data-id');
    var elem = document.createElement("img");
    elem.setAttribute("src", "".concat(image));
    document.getElementById("imageRemise").appendChild(elem);
  });
});
/******/ 	return __webpack_exports__;
/******/ })()
;
});