@extends('layouts/layoutMaster')

@section('title', 'Remises')

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
  <script src="{{asset('js/remise-liste.js')}}"></script>
@endsection

@section('content')
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="remise-list-table table border-top">
        <thead>
        <tr>
          <th></th>
          <th>#ID</th>
          <th>Client</th>
          <th><i class='ti ti-building-bank text-secondary'></i> Remise</th>
          <th>Total</th>
          <th class="text-truncate">Date</th>
          <th>Statut</th>


          <th class="cell-fit">Actions</th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
  <div class="card mt-3">
    <div class="card-datatable table-responsive">
      <table class="rm-list-table table border-top">
        <thead>
        <tr>

          <th>#ID</th>
          <th>Image Remise</th>
          <th class="cell-fit">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($datas as $data)
        <tr>
          <td>{{$data['id']}}</td>
          <td>
            <div class="avatar-wrapper">
              <div class="avatar me-2">

                <img src="{{asset($data['image_url'])}}" alt="" data-id="{{$data['image_url']}}" data-bs-toggle="modal" data-bs-target="#pricingModal" class="show-modal rounded-pill">
              </div>
            </div>
          </td>
          <td>
            <form action="{{ route('remise.destroy', $data['id']) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
          </td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal fade" id="pricingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-pricing">
      <div class="modal-content p-2 p-md-5">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <!-- Pricing Plans -->
          <div class="pb-sm-5 pb-2 rounded-top">
            <h2 class="text-center mb-2">Remise</h2>
            <div class="row" id="imageRemise"></div>

          </div>
          <!--/ Pricing Plans -->
        </div>
      </div>
    </div>
  </div>
@endsection
