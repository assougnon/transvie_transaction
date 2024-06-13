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
/*!*******************************************!*\
  !*** ./resources/js/banque-management.js ***!
  \*******************************************/
/**
 * Page User List
 */



// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-users'),
    userView = baseUrl,
    offCanvasForm = $('#offcanvasAddUser');

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Users datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'banque/list'
      },
      columns: [
      // columns according to JSON
      {
        data: ''
      }, {
        data: 'id'
      }, {
        data: 'nom'
      }, {
        data: 'telephone'
      }, {
        data: 'adresse'
      }, {
        data: 'pays_id'
      }, {
        data: 'action'
      }],
      columnDefs: [{
        // For Responsive
        className: 'control',
        searchable: false,
        orderable: false,
        responsivePriority: 2,
        targets: 0,
        render: function render(data, type, full, meta) {
          return '';
        }
      }, {
        searchable: true,
        orderable: false,
        targets: 1,
        render: function render(data, type, full, meta) {
          return "<span>".concat(full.fake_id, "</span>");
        }
      }, {
        // User full name
        targets: 2,
        responsivePriority: 4,
        render: function render(data, type, full, meta) {
          // For Avatar badge
          var stateNum = Math.floor(Math.random() * 6);
          var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
          var $state = states[stateNum],
            $name = full['nom'],
            $photo = full['photo'],
            $initials = $name.match(/\b\w/g) || [],
            $output;
          if ($photo) {
            $output = "<span class=\"avatar-initial rounded-circle \"> <img src=\"".concat($photo, "\" alt=\"\" class=\"rounded-circle\"></span>");
          } else {
            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
            $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
          }

          // Creates full output for row
          var $row_output = '<div class="d-flex justify-content-start align-items-center user-name">' + '<div class="avatar-wrapper">' + '<div class="avatar avatar-sm me-3">' + $output + '</div>' + '</div>' + '<div class="d-flex flex-column">' + '<a href="' + 'banques/' + full['id'] + '" class="text-body text-truncate"><span class="fw-medium">' + $name + '</span></a>' + '</div>' + '</div>';
          return $row_output;
        }
      }, {
        // User email
        targets: 3,
        render: function render(data, type, full, meta) {
          var $telephone = full['telephone'];
          return '<span class="user-email">' + $telephone + '</span>';
        }
      }, {
        // User telephone
        targets: 4,
        responsivePriority: 4,
        render: function render(data, type, full, meta) {
          var $pays = full['adresse'];

          // Creates full output for row
          var $row_output = '<div class="d-flex justify-content-start align-items-center user-name">' + '<div class="d-flex flex-column">' + '<span class="fw-medium">' + $pays + '</span>' + '</div>' + '</div>';
          return $row_output;
        }
      }, {
        targets: 5,
        className: 'text-center',
        render: function render(data, type, full, meta) {
          var $adresse = full['pays'];
          return "".concat($adresse);
        }
      }, {
        // Actions
        targets: -1,
        title: 'Actions',
        searchable: false,
        orderable: false,
        render: function render(data, type, full, meta) {
          return '<div class="d-inline-block text-nowrap">' + "<button class=\"btn btn-sm btn-icon edit-record\" data-id=\"".concat(full['id'], "\" ><a href=\"banques/").concat(full['id'], "\"><i class=\"ti ti-edit\"></i></a></button>") + "<button class=\"btn btn-sm btn-icon delete-record\" data-id=\"".concat(full['id'], "\"><i class=\"ti ti-trash\"></i></button>") + '</div>';
        }
      }],
      order: [[2, 'desc']],
      dom: '<"row mx-2"' + '<"col-md-2"<"me-3"l>>' + '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' + '>t' + '<"row mx-2"' + '<"col-sm-12 col-md-6"i>' + '<"col-sm-12 col-md-6"p>' + '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Rechercher..'
      },
      // Buttons with Dropdown
      buttons: [{
        extend: 'collection',
        className: 'btn btn-label-primary dropdown-toggle mx-3',
        text: '<i class="ti ti-logout rotate-n90 me-2"></i>Exporter',
        buttons: [{
          extend: 'print',
          title: 'Utilisateurs',
          text: '<i class="ti ti-printer me-2" ></i>Imprimer',
          className: 'dropdown-item',
          exportOptions: {
            columns: [2, 3, 4, 5],
            // prevent avatar to be print
            format: {
              body: function body(inner, coldex, rowdex) {
                if (inner.length <= 0) return inner;
                var el = $.parseHTML(inner);
                var result = '';
                $.each(el, function (index, item) {
                  if (item.classList !== undefined && item.classList.contains('user-name')) {
                    result = result + item.lastChild.textContent;
                  } else result = result + item.innerText;
                });
                return result;
              }
            }
          },
          customize: function customize(win) {
            //customize print view for dark
            $(win.document.body).css('color', config.colors.headingColor).css('border-color', config.colors.borderColor).css('background-color', config.colors.body);
            $(win.document.body).find('table').addClass('compact').css('color', 'inherit').css('border-color', 'inherit').css('background-color', 'inherit');
          }
        }, {
          extend: 'csv',
          title: 'Utilisateurs',
          text: '<i class="ti ti-file-text me-2" ></i>Csv',
          className: 'dropdown-item',
          exportOptions: {
            columns: [2, 3, 4, 5],
            // prevent avatar to be print
            format: {
              body: function body(inner, coldex, rowdex) {
                if (inner.length <= 0) return inner;
                var el = $.parseHTML(inner);
                var result = '';
                $.each(el, function (index, item) {
                  if (item.classList.contains('user-name')) {
                    result = result + item.lastChild.textContent;
                  } else result = result + item.innerText;
                });
                return result;
              }
            }
          }
        }, {
          extend: 'excel',
          title: 'Utilisateurs',
          text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
          className: 'dropdown-item',
          exportOptions: {
            columns: [2, 3, 4, 5],
            // prevent avatar to be display
            format: {
              body: function body(inner, coldex, rowdex) {
                if (inner.length <= 0) return inner;
                var el = $.parseHTML(inner);
                var result = '';
                $.each(el, function (index, item) {
                  if (item.classList.contains('user-name')) {
                    result = result + item.lastChild.textContent;
                  } else result = result + item.innerText;
                });
                return result;
              }
            }
          }
        }, {
          extend: 'pdf',
          title: 'Utilisateurs',
          text: '<i class="ti ti-file-text me-2"></i>Pdf',
          className: 'dropdown-item',
          exportOptions: {
            columns: [2, 3, 4, 5],
            // prevent avatar to be display
            format: {
              body: function body(inner, coldex, rowdex) {
                if (inner.length <= 0) return inner;
                var el = $.parseHTML(inner);
                var result = '';
                $.each(el, function (index, item) {
                  if (item.classList.contains('user-name')) {
                    result = result + item.lastChild.textContent;
                  } else result = result + item.innerText;
                });
                return result;
              }
            }
          }
        }, {
          extend: 'copy',
          title: 'Utilisateur',
          text: '<i class="ti ti-copy me-1" ></i>Copy',
          className: 'dropdown-item',
          exportOptions: {
            columns: [2, 3, 4, 5],
            // prevent avatar to be copy
            format: {
              body: function body(inner, coldex, rowdex) {
                if (inner.length <= 0) return inner;
                var el = $.parseHTML(inner);
                var result = '';
                $.each(el, function (index, item) {
                  if (item.classList.contains('user-name')) {
                    result = result + item.lastChild.textContent;
                  } else result = result + item.innerText;
                });
                return result;
              }
            }
          }
        }]
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
      }
    });
  }

  // Delete Record

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(function () {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);

  // validating form and updating user's data

  $(document).on('click', '.delete-record', function () {
    var user_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

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
          type: 'DELETE',
          url: "".concat(baseUrl, "banques/").concat(user_id),
          success: function success() {
            dt_user.draw();
          },
          error: function error(_error) {
            console.log(_error);
          }
        });

        // success sweetalert
        Swal.fire({
          icon: 'success',
          title: 'Supprimer!',
          text: 'La Banque a bien été Supprimée !',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Annuler',
          text: 'L\'utilisateur n\'a pas été supprimé!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });
  $(document).on('click', '.edit-record', function () {
    var banque_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // get data
    $.get("".concat(baseUrl, "banques/").concat(banque_id, "/edit"), function (data) {
      $('#user_id').val(data.id);
      $('#add-user-fullname').val(data.nom);
      $('#user-contry').val(data.pays_id);
      $('#user-adresse').val(data.adresse);
      $('#add-user-contact').val(data.telephone);
    });
  });
});
/******/ 	return __webpack_exports__;
/******/ })()
;
});