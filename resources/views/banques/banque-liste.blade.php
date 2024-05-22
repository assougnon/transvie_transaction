@extends('layouts/layoutMaster')

@section('title', 'User Management - Crud App')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('js/banque-management.js')}}"></script>
@endsection

@section('content')

  <div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Users</span>
              <div class="d-flex align-items-end mt-2">
                <h3 class="mb-0 me-2"></h3>
                <small class="text-success">(100%)</small>
              </div>
              <small>Total des Utilisateurs </small>
            </div>
            <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Utilisateurs Vérifiés</span>
              <div class="d-flex align-items-end mt-2">
                <h3 class="mb-0 me-2"></h3>
                <small class="text-success">(+95%)</small>
              </div>
              <small>Récent </small>
            </div>
            <span class="badge bg-label-success rounded p-2">
            <i class="ti ti-user-check ti-sm"></i>
          </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>Utilisateur en Doublon</span>
              <div class="d-flex align-items-end mt-2">
                <h3 class="mb-0 me-2"></h3>
                <small class="text-success">(0%)</small>
              </div>
              <small>Analyses Récentes</small>
            </div>
            <span class="badge bg-label-danger rounded p-2">
            <i class="ti ti-users ti-sm"></i>
          </span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-start justify-content-between">
            <div class="content-left">
              <span>En Attente de vérification</span>
              <div class="d-flex align-items-end mt-2">
                <h3 class="mb-0 me-2"></h3>
                <small class="text-danger">(+6%)</small>
              </div>
              <small>Analyses Récentes</small>
            </div>
            <span class="badge bg-label-warning rounded p-2">
            <i class="ti ti-user-circle ti-sm"></i>
          </span>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Users List Table -->
  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">Filtre de recherche</h5>
    </div>
    <div class="card-datatable table-responsive">
      <table class="datatables-users table">
        <thead class="border-top">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Nom de la banque</th>
          <th>Telephone</th>
          <th>Adresse</th>
          <th>Pays</th>
          <th>Action</th>
        </tr>
        </thead>
      </table>
    </div>
    <!-- Offcanvas to add new user -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
      <div class="offcanvas-header">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Modification de la banque</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body mx-0 flex-grow-0">
        <form class="add-new-usr pt-0" id="addNewUserForm" enctype="multipart/form-data" >
          <div class="mb-3">

          </div>

          <div class="mb-3">

          </div>

          <div class="mb-4">

          </div>
          <div class="mb-4">

          </div>
          <div class="mb-4">

          </div>
          <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit" id="but_upload">Envoyer</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Annuler</button>
        </form>
      </div>
    </div>



    <div class="modal fade" id="editBanque" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-simple modal-edit-user">
        <div class="modal-content p-3 p-md-5">
          <div class="modal-body">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="text-center mb-4">
              <h3 class="mb-2">Modification de la Banque</h3>

            </div>
            <form id="editForm" class="row g-3"  >
              @csrf
              <div class="col-12 col-md-6">
                <label class="form-label" for="add-user-fullname">Nom de la Banque</label>
                <input type="text" class="form-control" id="add-user-fullname" placeholder="ORABANK" name="nom" aria-label="Ora BANK" />
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label" for="add-user-contact">Telephone</label>
                <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="+1 (609) 988-44-11" aria-label="9874556" name="telephone" />
              </div>
              <div class="col-12">
                <label class="form-label" for="user-plan">Pays</label>
                <select id="user-contry" class="form-select" name="pays">
                  <option value="" disabled>Veuillez selectionner un pays</option>
                  @foreach($pays as $pays)
                    <option value="{{$pays->id}}">{{$pays->nom}}</option>
                  @endforeach

                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label" for="user-adresse">Adresse</label>
                <input type="text" name="adresse" class="form-control" id="user-adresse">
              </div>
              <div class="col-12 col-md-6">
                <label for="formFile" class="form-label ">Choisir l'image de la banque</label>
                <input class="form-control" type="file" id="formFile" name="image_url">
              </div>

              <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>



@endsection
