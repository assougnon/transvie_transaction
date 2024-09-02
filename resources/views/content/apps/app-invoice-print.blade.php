<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Document</title>
  <link rel="stylesheet" href="{{public_path('assets/vendor/css/pages/app-invoice-print.css')}}" />
  <link rel="stylesheet" href="{{public_path('assets/css/bootstrap.min.css')}}" />

</head>
<body>
<div class="invoice-print p-5">
<img src="{{public_path('assets/img/logo/logoTransvie.jpeg')}}"  alt="">

  <div class="d-flex justify-content-between flex-row">
    <div class="mb-4">

      <p class="mb-2">{{$agence->nom}}</p>
      <p class="mb-2">{{$agence->adresse}}</p>
      <p class="mb-0">{{$agence->telephone}}</p>
    </div>
    <div>
      <h4 class="fw-medium">BORDEREAU : #{{$transaction->numero}}</h4>
      <div class="mb-2">
        <div class="text-muted">Date d'enregistrement :</div>
        <span class="fw-medium">{{$transaction->creerle()}}</span>
      </div>
      <div>
        <span class="text-muted">Date :</span>
        <span class="fw-medium">{{$date}}</span>
      </div>
    </div>
  </div>

  <hr />

  <div class="row d-flex justify-content-between mb-4">
    <div class="col-sm-6 w-50">
      <h6 class="mb-3">Contact :</h6>
      <p class="mb-1">{{$adherant->prenom}}  {{$adherant->nom}}</p>
      <p class="mb-1">{{$adherant->telephone}}</p>
      <p class="mb-1">{{$adherant->adresse}}</p>
      <p class="mb-1">{{$adherant->email}}</p>
    </div>
    <div class="col-sm-6 w-50">
      <h6 class="mb-4">Informations Supplémentaires :</h6>
      <table>
        <tbody>
        <tr>
          <td class="">Entreprise :</td>
          <td class="fw-medium">{{$adherant->nom_entreprise}}</td>
        </tr>

        </tbody>
      </table>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table m-0">
      <thead class="thead-light">
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
  </div>


</div>

</body>
</html>



{{--

@extends('layouts/layoutMaster')

@section('title', 'Bordereau (version imprimable)')

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-invoice-print.css')}}" />
@endsection

@section('page-script')
<script src="{{asset('assets/js/app-invoice-print.js')}}"></script>
@endsection

@section('content')
<div class="invoice-print p-5">

  <div class="d-flex justify-content-between flex-row">
    <div class="mb-4">
      <div class="">
       --}}
{{-- <img src="{{url('/assets/img/logo/logoTransvie.png')}}" class="mb-1" alt="">--}}{{--

      </div>
      <p class="mb-2">{{$agence->nom}}</p>
      <p class="mb-2">{{$agence->adresse}}</p>
      <p class="mb-0">{{$agence->telephone}}</p>
    </div>
    <div>
      <h4 class="fw-medium">BORDEREAU : #{{$transaction->numero}}</h4>
      <div class="mb-2">
        <div class="text-muted">Date d'enregistrement :</div>
        <span class="fw-medium">{{$transaction->creerle()}}</span>
      </div>
      <div>
        <span class="text-muted">Date :</span>
        <span class="fw-medium">{{$date}}</span>
      </div>
    </div>
  </div>

  <hr />

  <div class="row d-flex justify-content-between mb-4">
    <div class="col-sm-6 w-50">
      <h6 class="mb-3">Contact :</h6>
      <p class="mb-1">{{$adherant->prenom}}  {{$adherant->nom}}</p>
      <p class="mb-1">{{$adherant->telephone}}</p>
      <p class="mb-1">{{$adherant->adresse}}</p>
      <p class="mb-1">{{$adherant->email}}</p>
    </div>
    <div class="col-sm-6 w-50">
      <h6 class="mb-4">Informations Supplémentaires :</h6>
      <table>
        <tbody>
        <tr>
          <td class="pe-4">Entreprise :</td>
          <td class="fw-medium">{{$adherant->nom_entreprise}}</td>
        </tr>

        </tbody>
      </table>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table m-0">
      <thead class="table-light">
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
  </div>

  <div class="row">
    <div class="col-12">
      <span class="fw-medium">Note:</span>
      <span> Thank You!</span>
    </div>
  </div>
</div>
@endsection
--}}
