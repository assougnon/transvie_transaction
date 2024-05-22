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

  <div class="card mb-4">
    <h5 class="card-header">Multi Column with Form Separator</h5>
    <form class="card-body" method="POST" action="{{route('banques.store')}}" enctype="multipart/form-data">
      @csrf
      <h6>2. Personal Info</h6>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="nom-banque">Nom de la Banque</label>
          <input type="text" id="nom-banque" class="form-control @error('nom') is-invalid @enderror " value="{{old('nom')}}" placeholder="Ora Bank" name="nom" />
          @error('nom')
          <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
          @enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="telephone-banque">Telephone</label>
          <input type="text" id="telephone-banque" class="form-control @error('telephone') is-invalid @enderror " value="{{old('telephone')}}" placeholder="Doe" name="telephone"/>
          @error('nom')
          <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
          @enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="pays-banque">Pays</label>
          <select id="pays-banque" class="select2 form-select @error('pays_id') is-invalid @enderror " value="{{old('pays_id')}}" data-allow-clear="true" name="pays_id">
            <option value="">Select</option>
            @foreach($pays as $pays)
              <option value="{{$pays->id}}"  >{{$pays->nom}}</option>

            @endforeach

          </select>
          @error('pays_id')
          <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
          @enderror
        </div>

        <div class="col-md-6">
          <label class="form-label" for="adresse-banque">Adresse</label>
          <input type="text" id="adresse-banque" class="form-control @error('adresse') is-invalid @enderror " value="{{old('adresse')}}" placeholder="Avenue 123 Place " name="adresse" />
          @error('adresse')
          <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
          @enderror
        </div>
        <div class="col-md-6">

            <label for="formFile" class="form-label ">Choisir l'image de la banque</label>
            <input class="form-control @error('image_url') is-invalid @enderror " type="file" id="formFile" name="image_url">
          @error('image_url')
          <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
          @enderror

        </div>
      </div>
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Envoyer</button>
        <button type="reset" class="btn btn-label-secondary">Annuler</button>
      </div>
    </form>
  </div>


@endsection
