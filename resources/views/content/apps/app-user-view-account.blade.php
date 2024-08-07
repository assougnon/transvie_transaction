@extends('layouts/layoutMaster')

@section('title', ' Utilisateurs')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-user-view.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/modal-edit-user.js')}}"></script>
<script src="{{asset('assets/js/app-user-view.js')}}"></script>
<script src="{{asset('js/userTransaction.js')}}"></script>
@endsection

@section('content')
<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Compte /</span> Utilisateur
</h4>
<div class="row">
  <!-- User Sidebar -->
  <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
    <!-- User Card -->
    <div class="card mb-4">
      <div class="card-body">
        <div class="user-avatar-section">
          <div class=" d-flex align-items-center flex-column">
            <img src="{{ $user_infos ? $user_infos->profile_photo_url : asset('assets/img/avatars/1.png') }}" alt="user image" class="img-fluid rounded mb-3 pt-1 mt-4 rounded user-profile-img" height="100" width="100">
            <div class="user-info text-center">
              <h4 class="mb-2">{{$user_infos->prenom.' '.$user_infos->name}}</h4>
              <input type="hidden" name="userID" value="{{$user_infos->id}}" id="userInputT">

            </div>
          </div>
        </div>
        <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4 border-bottom">
          <div class="d-flex align-items-start me-4 mt-3 gap-2">
            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-checkbox ti-sm'></i></span>
            <div>
              <p class="mb-0 fw-medium">1.23k</p>
              <small>Tasks Done</small>
            </div>
          </div>
          <div class="d-flex align-items-start mt-3 gap-2">
            <span class="badge bg-label-primary p-2 rounded"><i class='ti ti-moneybag ti-sm'></i></span>
            <div>
              <p class="mb-0 fw-medium">{{$total_transaction}}</p>
              <small>Total Transaction</small>
            </div>
          </div>
        </div>
        <p class="mt-4 small text-uppercase text-muted">Détails de l'utilisateur</p>
        <div class="info-container">
          <ul class="list-unstyled">

            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Email:</span>
              <span>{{$user_infos->email}}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Status:</span>
              <span class="badge bg-label-success">Active</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Intitulé de poste:</span>
              <span>{{$user_infos->poste}}</span>
            </li>

            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Telephone:</span>
              <span>{{$user_infos->telephone}}</span>
            </li>
            <li class="mb-2 pt-1">
              <span class="fw-medium me-1">Adresse:</span>
              <span>{{$user_infos->adresse}}</span>
            </li>
            <li class="pt-1">
              <span class="fw-medium me-1">Pays:</span>
              <span>{{$user_infos->agence->pays->nom}}</span>
            </li>
            <li class="pt-1">
              <span class="fw-medium me-1">Agence:</span>
              <span>{{$user_infos->agence->nom}}</span>
            </li>
            <li class="pt-1">
              <span class="fw-medium me-1">Adresse de l'Agence:</span>
              <span>{{$user_infos->agence->adresse}}</span>
            </li>
          </ul>
          <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-label-danger suspend-user">Suspendre</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /User Card -->
    <!-- Plan Card -->
   {{-- <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <span class="badge bg-label-primary">Standard</span>
          <div class="d-flex justify-content-center">
            <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary fw-normal">$</sup>
            <h1 class="mb-0 text-primary">99</h1>
            <sub class="h6 pricing-duration mt-auto mb-2 text-muted fw-normal">/month</sub>
          </div>
        </div>
        <ul class="ps-3 g-2 my-3">
          <li class="mb-2">10 Users</li>
          <li class="mb-2">Up to 10 GB storage</li>
          <li>Basic Support</li>
        </ul>
        <div class="d-flex justify-content-between align-items-center mb-1 fw-medium text-heading">
          <span>Days</span>
          <span>65% Completed</span>
        </div>
        <div class="progress mb-1" style="height: 8px;">
          <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <span>4 days remaining</span>
        <div class="d-grid w-100 mt-4">
          <button class="btn btn-primary" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">Upgrade Plan</button>
        </div>
      </div>
    </div>--}}
    <!-- /Plan Card -->
  </div>
  <!--/ User Sidebar -->


  <!-- User Content -->
  <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">


    <!-- Invoice table -->
    <div class="card mb-4">
      <h5 class="card-header">Transactions enregistrées par  l'Utilisateur {{$user_infos->prenom.' '.$user_infos->name}}</h5>
      <div class="table-responsive mb-3">
        <table class="table datatable-invoice border-top">
          <thead>
            <tr>
              <th></th>
              <th>ID</th>
              <th>Nom de l'Adherent</th>
              <th>Montant</th>
              <th>Statut</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!-- /Invoice table -->
  </div>
  <!--/ User Content -->
</div>

<!-- Modal -->
@include('_partials/_modals/modal-edit-user')
@include('_partials/_modals/modal-upgrade-plan')
<!-- /Modal -->
@endsection
