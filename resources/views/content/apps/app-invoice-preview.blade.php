@extends('layouts/layoutMaster')

@section('title', 'Facture - Transaction')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}"/>
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice.css')}}"/>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/offcanvas-add-payment.js')}}"></script>
  <script src="{{asset('assets/js/offcanvas-send-invoice.js')}}"></script>
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
@endsection

@section('content')

  <div class="row invoice-preview">
    <!-- Invoice -->
    <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
      <div class="card invoice-preview-card">
        <div class="card-body">
          <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
            <div class="mb-xl-0 mb-4">
              <div class="mb-4">

              </div>
              <img src="{{asset('assets/img/logo/logoTransvie.png')}}" class="mb-1" alt="">
              <p class="mb-2">{{$agence->nom}}</p>
              <div class="col-md-8">
                <p class="mb-2">{{$agence->adresse}}</p>
              </div>
              <p class="mb-0">{{$agence->telephone}}</p>
            </div>
            <div>
              <h4 class="fw-light mb-2">BORDEREAU : #{{$transaction->numero}}</h4>
              <div class="">Date d'enregistrement :</div>
              <div>{{$transaction->creerle()}}</div>
              <div>Date :</div>
              <div>

                {{\Illuminate\Support\Carbon::now()->translatedFormat('d F Y')}}
              </div>


            </div>
          </div>
        </div>
        <hr class="my-0"/>
        <div class="card-body">
          <div class="row p-sm-3 p-0">
            <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
              <h6 class="mb-3">Contact :</h6>
              <p class="mb-1">{{!empty($adherant->prenom) ? $adherant->prenom : $transaction->adherant_prenom}}  {{!empty($adherant->nom )? $adherant->nom : $transaction->adherant_nom}}</p>
              <p class="mb-1">{{!empty($adherant->telephone) ? $adherant->telephone : $transaction->adherant_telephone}}</p>
              <p class="mb-1">{{!empty($adherant->adresse )? $adherant->adresse : $transaction->adherant_adresse}}</p>
              <p class="mb-1">{{!empty($adherant->email )? $adherant->email : $transaction->adherant_email}}</p>
            </div>
            <div class="col-xl-6 col-md-12 col-sm-7 col-12">
              <h6 class="mb-4">Informations Supplémentaires :</h6>
              <table>
                <tbody>
                <tr>
                  <td class="pe-4">Entreprise :</td>
                  <td class="fw-medium">{{!empty($adherant->nom_entreprise)?$adherant->nom_entreprise : $transaction->adherant_entreprise}}</td>
                </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="table-responsive border-top">
          <table class="table m-0">
            <thead>
            <tr>
              <th>TYPE</th>
              <th>Description</th>
              <th>Total</th>

            </tr>
            </thead>
            <tbody>
            <tr>
              <td class="text-nowrap">{{$transaction->type}}</td>
              <td class="text-nowrap">{{$transaction->note}}</td>
              <td>@money($transaction->montant) CFA</td>

            </tr>

            </tbody>
          </table>
          <div style="height: 300px;">

          </div>
        </div>

        <div class="card-body mx-3 ">
          <div class="row">
            <div class="col-12">
              <span class="fw-medium"></span>
              <span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Invoice -->

    <!-- Invoice Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions">
      <div class="card">
        <div class="card-body">
          <a class="btn btn-label-secondary d-grid w-100 mb-2" target="_blank" href="{{url('app/invoice/print/'.$transaction->numero)}}">
            Prints
          </a>
          <a  href="{{url('app/facture/print/'.$transaction->numero)}}" class="btn btn-primary d-grid w-100 mb-2">
            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                class="ti ti-download ti-xs me-2"></i>Télécharger</span>
          </a>


          <a href="{{url('transaction/'.$transaction->numero)}}" class="btn btn-label-secondary d-grid w-100 mb-2">
            Modifier la Transaction
          </a>
          <a href="{{url('app/facture/print/'.$transaction->numero)}}" class="btn btn-label-secondary d-grid w-100 mb-2">
            Telecharger
          </a>

        </div>
      </div>
    </div>
    <!-- /Invoice Actions -->
  </div>

  <!-- Offcanvas -->
  @include('_partials/_offcanvas/offcanvas-send-invoice')
  @include('_partials/_offcanvas/offcanvas-add-payment')
  <!-- /Offcanvas -->
@endsection
