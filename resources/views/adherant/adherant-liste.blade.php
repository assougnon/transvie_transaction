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
  <script src="{{asset('js/adherant-management.js')}}"></script>
@endsection

@section('content')
  <!-- Users List Table -->
  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">Liste des Adhérants | Filtre de recherche</h5>
    </div>
    <div class="card-datatable table-responsive">
      <table class="datatables-adherant table">
        <thead class="border-top">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Prenom & Nom</th>
          <th>Email</th>
          <th>Telephone</th>
          <th>Entreprise</th>
          <th>Population</th>
          <th>Agence</th>
          <th>Actions</th>

        </tr>
        </thead>
      </table>
    </div>

  </div>

  <div class="modal fade" id="editAdherant" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
      <div class="modal-content p-3 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="text-center mb-4">
            <h3 class="address-title mb-2">Modification d'un Adherant</h3>

          </div>
          <form id="demoForm" class="row g-3 "  >
            @csrf

            <input type="hidden" id="oldnumber" name="oldnumber"  />

            <div class="col-12 col-md-6">
              <label class="form-label" for="prenom1">PrEnom</label>
              <input type="text" id="prenom1" name="prenom_adh" class="form-control" placeholder="John" />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="nom1">Nom</label>
              <input type="text" id="nom1" name="nom" class="form-control" placeholder="Doe" />
            </div>

            <div class="col-12 ">
              <label class="form-label" for="email1">Email</label>
              <input type="text" id="email1" name="email" class="form-control" placeholder="john.doe@transvie.sn" />
            </div>
            <div class="col-12">
              <label class="form-label" for="user-contry">Pays</label>
              <select id="user-contry" name="pays" class=" form-select " data-allow-clear="true">
                <option value="" selected>Selectionner un Pays</option>
                @foreach($pays as $pays)
                  <option value="{{$pays->id}}">{{$pays->nom}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <label class="form-label" for="user-agence">Agence</label>
              <select id="user-agence" name="agence" class=" form-select" data-allow-clear="true">

              </select>
            </div>
            <div class="col-12">
              <label class="form-label" for="entreprise1">Entreprise</label>
              <input type="text" name="entreprise" class="form-control" id="entreprise1">
            </div>
            <div class="col-12 col-md-6 ">
              <label class="form-label" for="telephone1">Telephone</label>
              <input type="text" id="telephone1" name="telephone" class="form-control" placeholder="771234567" />
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label" for="population1">Population</label>
              <input type="text" id="population1" name="population" class="form-control" placeholder="Ex:1" />
            </div>
            <div class="col-12">
              <label class="form-label" for="adresse1">Adresse</label>
              <input type="text" id="adresse1" name="adresse" class="form-control" placeholder="25 Rue, Avenue....." />
            </div>


            <div class="col-12 text-center">

              @can('edit adherent')
              <button type="submit" class="btn btn-primary me-sm-3 me-1 " id="submit1" >Modifier</button>
              @endcan
              <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
