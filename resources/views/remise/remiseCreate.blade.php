@extends('layouts/layoutMaster')

@section('title', ' Vertical Layouts - Forms')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/form-layouts.js')}}"></script>
@endsection

@section('content')

<div class="row">
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Remises disponibles</h5>
      <small class="text-muted float-end"></small>
    </div>
    <div class="card-body">
      <form action="/remise" method="POST" enctype="multipart/form-data" >
    @csrf
    <div class="col-xl-12">
      <div class="mb-5 ">
        <label for="formFile" class="form-label">Importez la remise</label>
        <input class="form-control" type="file" id="formFile" name="remisePhoto" >
        @error('remisePhoto')

              <span class="fw-medium text-danger">{{ $message }}</span>

        @enderror
      </div>

      <div class="row">
        @foreach($transaction as $key => $item)
          <div class="col-md-4 mb-md-0 mb-2">
            <div class="form-check custom-option custom-option-basic">
              <label class="form-check-label custom-option-content" for="customCheckTemp{{$key}}">
                <input class="form-check-input" type="checkbox" value="{{$item->id}}" name="remise[]" id="customCheckTemp{{$key}}"  />
                <span class="custom-option-header">
                  <span class="h6 mb-0">{{$item->adherant_prenom}} {{$item->adherant_nom}} / {{$item->adherant_entreprise}}</span>
                  <span class="text-muted"></span>
                </span>
                <span class="custom-option-body">
                  <strong class="option-text text-primary">@money($item->montant) </strong>
                </span>
              </label>
            </div>
          </div>
        @endforeach


      </div>
    </div>

        <button type="submit" class="form-control btn-primary mt-3">Envoyer</button>
      </form>
    </div>
  </div>
</div>
@endsection
