@extends('layouts/layoutMaster')

@section('title', 'Page des Transactions')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>

@endsection

@section('page-script')
  <script src="{{asset('js/depenses-list.js')}}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Dépenses /</span> List
  </h4>

  <!-- Invoice List Widget -->

  <div class="card mb-4">
    <div class="card-widget-separator-wrapper">
      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1">

          <div class="col-sm-6 col-lg-6">
            <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
              <div>
                <h3 class="mb-1">{{$nombres}}</h3>
                <p class="mb-0">Nbr de Dépenses</p>
              </div>
              <span class="avatar me-lg-4">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-file-invoice ti-md"></i></span>
            </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none">

          </div>
          <div class="col-sm-6 col-lg-6">
            <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
              <div>
                <h3 class="mb-1">@money($total) CFA</h3>
                <p class="mb-0">Montant Total</p>
              </div>
              <span class="avatar me-sm-4">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-checks ti-md"></i></span>
            </span>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Invoice List Table -->
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="depenses-list-table table border-top">
        <thead>
        <tr>
          <th></th>
          <th>#ID</th>
          <th>Montant</th>
          <th>Description</th>

          <th>Banque</th>
          <th>Actions</th>



        </tr>
        </thead>
      </table>
    </div>
  </div>



@endsection
