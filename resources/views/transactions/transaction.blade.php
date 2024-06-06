@extends('layouts/layoutMaster')

@section('title', 'Page des Transactions')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>

@endsection

@section('page-script')
  <script src="{{asset('js/transaction-list.js')}}"></script>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Transaction /</span> List
  </h4>

  <!-- Invoice List Widget -->

  <div class="card mb-4">
    <div class="card-widget-separator-wrapper">
      <div class="card-body card-widget-separator">
        <div class="row gy-4 gy-sm-1">
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
              <div>
                <h3 class="mb-1">{{$clients}}</h3>
                <p class="mb-0">Clients</p>
              </div>
              <span class="avatar me-sm-4">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-user ti-md"></i></span>
            </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none me-4">
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
              <div>
                <h3 class="mb-1">{{$factures}}</h3>
                <p class="mb-0">Factures</p>
              </div>
              <span class="avatar me-lg-4">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-file-invoice ti-md"></i></span>
            </span>
            </div>
            <hr class="d-none d-sm-block d-lg-none">

          </div>
          <div class="col-sm-6 col-lg-3">
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
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <h3 class="mb-1 col text-danger">@money($impayees) CFA</h3>
                <p class="mb-0">Impayées</p>
              </div>
              <span class="avatar">
              <span class="avatar-initial bg-label-secondary rounded"><i class="ti ti-circle-off ti-md"></i></span>
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
      <table class="invoice-list-table table border-top">
        <thead>
        <tr>
          <th></th>
          <th>#ID</th>
          <th>Client</th>
          <th><i class='ti ti-building-bank text-secondary'></i></th>
          <th>Total</th>
          <th class="text-truncate">Date</th>
          <th>Statut</th>


          <th class="cell-fit">Actions</th>
        </tr>
        </thead>
      </table>
    </div>
  </div>


{{--  <div class="card mt-2">
    <h5 class="card-header">Advanced Search</h5>
    <!--Search Form -->
    <div class="card-body">
      <form class="dt_adv_search" method="POST">
        <div class="row">
          <div class="col-12">
            <div class="row g-3">
              <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label">Numéro:</label>
                <input type="text" class="form-control dt-input dt-full-name" data-column=1 placeholder="09998374LA" data-column-index="0">
              </div>
              <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label">Adherent:</label>
                <input type="text" class="form-control dt-input" data-column=2 placeholder="Alaric Beslier" data-column-index="1">
              </div>
              <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label">Banque:</label>
                <input type="text" class="form-control dt-input" data-column=3 placeholder="Bnque" data-column-index="2">
              </div>
              <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label">Montant:</label>
                <input type="text" class="form-control dt-input" data-column=4 placeholder="120800" data-column-index="3">
              </div>
              <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label">Date:</label>
                <div class="mb-0">
                  <input type="text" class="form-control dt-date flatpickr-range dt-input" data-column="5" placeholder="dateDépart à la  DateFin" data-column-index="4" name="dt_date" />
                  <input type="hidden" class="form-control dt-date start_date dt-input" data-column="5" data-column-index="4" name="value_from_start_date" />
                  <input type="hidden" class="form-control dt-date end_date dt-input" name="value_from_end_date" data-column="5" data-column-index="4" />
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label">Statut:</label>
                <input type="text" class="form-control dt-input" data-column=6 placeholder="Encours" data-column-index="5">
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <hr class="mt-0">
    <div class="card-datatable table-responsive">
      <table class="dt-advanced-search table">
        <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Email</th>
          <th>Post</th>
          <th>City</th>
          <th>Date</th>
          <th>Salary</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Email</th>
          <th>Post</th>
          <th>City</th>
          <th>Date</th>
          <th>Salary</th>
        </tr>
        </tfoot>
      </table>
    </div>
  </div>--}}
@endsection
