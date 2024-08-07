/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  var dt_user_table = $('.datatables-adherant'),

    userView = baseUrl + 'app/user/view/account';


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
        url: baseUrl + 'adherant/list'
      },
      columns: [
        // columns according to JSON
        {data: ''},
        {data: 'id'},
        {data: 'prenom'},
        {data: 'email'},
        {data: 'telephone'},
        {data: 'entreprise'},
        {data: 'population'},
        {data: 'agence'},
        {data: 'Actions'},
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        {
          searchable: true,
          orderable: false,
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span>${full.fake_id}</span>`;
          }
        },
        {
          // User full name
          targets: 2,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $name = full['prenom'];

            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="d-flex flex-column">' +
              '<a href="" class="text-body text-truncate"><span class="fw-medium">' +
              $name +
              '</span></a>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // User email
          targets: 3,
          render: function (data, type, full, meta) {
            var $email = full['email'];

            return '<span class="user-email">' + $email + '</span>';
          }
        },
        {
          // User telephone
          targets: 4,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $telephone = full['telephone'];


            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +

              '<div class="d-flex flex-column">' +
              '<span class="fw-medium">' +
              $telephone +
              '</span>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          //entrepirse
          targets: 5,
          className: 'text-center',
          render: function (data, type, full, meta) {

            let $entreprise = full['entreprise'];
            return `${$entreprise}`;
          }
        }
        ,
        {
          // population
          targets: 6,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $popoulation = full['population'];
            return `${$popoulation}`;
          }
        }, {
          // agence
          targets: 7,
          className: 'text-center',
          render: function (data, type, full, meta) {
            var $agence = full['agence'];
            return `${$agence}`;
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
              '<div class="d-inline-block text-nowrap">' +
              `  <button class="btn btn-sm btn-icon edit-record" data-id="${full['id']}" data-bs-toggle="modal" data-bs-target="#editAdherant"><i class="ti ti-edit"></i></button>` +
              `  <button class="btn btn-sm btn-icon delete-record" data-id="${full['id']}"><i class="ti ti-trash"></i></button>` +
              '</div>'
            );
          }
        }
      ],
      order: [[2, 'desc']],
      dom:
        '<"row mx-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Rechercher..'
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-primary dropdown-toggle mx-3',
          text: '<i class="ti ti-logout rotate-n90 me-2"></i>Exporter',
          buttons: [
            {
              extend: 'print',
              title: 'Adherants',
              text: '<i class="ti ti-printer me-2" ></i> Imprimer',
              className: 'dropdown-item',

              exportOptions: {
                columns: [2, 4, 5, 6, 7],

              },
              customize: function (win) {
                //customize print view for dark
                $(win.document.body)
                  .css('color', config.colors.headingColor)
                  .css('border-color', config.colors.borderColor)
                  .css('background-color', config.colors.body);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'csv',
              title: 'Adherants',
              text: '<i class="ti ti-file-text me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 4, 5, 6, 7],
                // prevent avatar to be print

              }
            },
            {
              extend: 'excel',
              title: 'Adherants',
              text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 4, 5, 6, 7],
                // prevent avatar to be display

              }
            },
            {
              extend: 'pdf',
              title: 'Adherants',
              text: '<i class="ti ti-file-text me-2"></i>Pdf',
              className: 'dropdown-item',
              orientation: 'landscape',
              exportOptions: {
                columns: [2, 4, 5, 6, 7],
                // prevent avatar to be display

              }
            },
            {
              extend: 'copy',
              title: 'Adherants',
              text: '<i class="ti ti-copy me-1" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [2, 4, 5, 6, 7],
                // prevent avatar to be copy

              }
            }
          ]
        },
        {
          text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Ajouter un Adherant</span>',
          className: 'add-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
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
      }
    });
  }



  // edit record
  $(document).on('click', '.edit-record', function () {
    var adherant_id = $(this).data('id'),
      dtrModal = $('#editAdherant');


    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }


    $.get(`${baseUrl}adherant\/${adherant_id}\/edit`, function (data) {

      $('#prenom1').val(data.prenom);
      $('#nom1').val(data.nom);
      $('#email1').val(data.email);
      $('#entreprise1').val(data.nom_entreprise);
      $('#telephone1').val(data.telephone);
      $('#oldnumber').val(data.telephone);
      $('#population1').val(data.population);
      $('#adresse1').val(data.adresse);

      $.ajax({
        type: 'GET',
        url: `${baseUrl}adherant/pays`,
        data: 'agenceID=' + data.agence_id,
        success: function (res) {
          $('#user-contry').val(res.pays);
          $.ajax({
            type: 'GET',
            url: `${baseUrl}auth/register-basic`,
            data: 'id=' + res.pays,
            success: function (res) {

              $('#user-agence').empty();
              $('#user-agence').append(`<option value="0" disabled>Selectionnez l'agence</option>`);
              for (let i = 0; i < res.length; i++) {

                if (data.agence_id === res[i]['id']) {

                  $('#user-agence').append(`<option value="${res[i]['id']}" selected>${res[i]['nom']}</option>`);
                } else {

                  $('#user-agence').append(`<option value="${res[i]['id']}">${res[i]['nom']}</option>`);
                }


              }


            }
          });
        }

      });





    });
  });
//end edit record

  // changing the title
  $('.add-new').on('click', function () {
    window.location.href = baseUrl + "adherant/create";
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);


  // validating form and updating user's data
  const formadhe = document.getElementById('demoForm');






// user form validation
  const fv = FormValidation.formValidation(formadhe, {
    fields: {
      'prenom_adh': {
        validators: {
          notEmpty: {
            message: 'Veuillez saisir un prénom'
          }
        }
      },
      'nom': {
        validators: {
          notEmpty: {
            message: 'Veuillez saisir un nom'
          }
        }
      },
      'telephone': {
        validators: {
          notEmpty: {
            message: 'Veuillez saisir un numéro de téléphone'
          }
        }
      },
      email: {
        validators: {
          emailAddress: {
            message: 'Veuillez saisir une adresse email valide'
          }
        }
      },
    },
    plugins: {

      trigger: new FormValidation.plugins.Trigger(),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.col-12';
        }
      }),
    },
  }).on('core.form.valid', function () {
    // adding or updating user when form successfully validate


    $.ajax({
      data: $('#demoForm').serialize(),
      url: `${baseUrl}adherant/update`,
      type: 'POST',
      success: function (status) {
        dt_user.draw();
        $('#editAdherant').modal('hide');

        // sweetalert
        Swal.fire({
          icon: 'success',
          title: `Mise à jour  ${status} !`,
          text: `Mise à jour des informations  ${status} .`,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      },
      error: function (err) {

        Swal.fire({
          title: 'Doublon!',
          text: 'l\'adresse mail doit être unique.',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });



  $('#user-contry').on('change', function(){
    var agenceID = $(this).val();
    $('#user-agence').empty();
    $('#user-agence').append(`<option value="0" disabled>Chargement des agences en cours..</option>`);

    if(agenceID){
      $.ajax({
        type:'GET',
        url: `${baseUrl}auth/register-basic`,
        data:'id='+agenceID,
        success:function(res){

          $('#user-agence').empty();
          $('#user-agence').append(`<option value="0" disabled>Selectionnez l'agence</option>`);
          for( let i =0; i < res.length ; i++){
            $('#user-agence').append(`<option value="${res[i]['id']}">${res[i]['nom']}</option>`);
          }


        }
      });
    }

  });

//Suppression de l'adherant

  $(document).on('click', '.delete-record', function () {
    var adherant_id = $(this).data('id'),

      dtrModal = $('.dtr-bs-modal.show');
    console.log(adherant_id);

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
          data: 'id='+ adherant_id,
          url: `${baseUrl}adherant-destroy`,
          type: 'POST',
          success: function () {
            dt_user.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert
        Swal.fire({
          icon: 'success',
          title: 'Supprimer!',
          text: 'L\'adherant a bien été Supprimé !',
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

});


