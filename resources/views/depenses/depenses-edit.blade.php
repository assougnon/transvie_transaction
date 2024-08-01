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
  <h4 class="py-3 mb-4"><span class="text-muted fw-light">Enregistrement/</span>D'une dépense</h4>



  <!-- Multi Column with Form Separator -->
  <div class="card mb-4">
    <h5 class="card-header">Enregistrement d'une dépense'</h5>
    <form class="card-body" method="POST" action="/update/depense/{{$depense->id}}">
      @csrf
      @method('PATCH')
      <div class="row g-3">

        <div class="col-md-6">
          <label class="form-label" for="multicol-montant">Montant de la Dépense</label>
          <div class="input-group input-group-merge">
            <input type="number" name="depense" id="multicol-montant" class="form-control @error('depense') is-invalid @enderror" placeholder="12300000" aria-label="100000" aria-describedby="multicol-montant" value="{{$depense->montant}}" autocomplete="false"/>
            @error('depense')
            <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
            @enderror
          </div>

        </div>

        <div class="col-md-6">
          <label class="form-label" for="multicol-note">Description de la dépense</label>
          <input type="text" id="multicol-note" class="form-control @error('description') is-invalid @enderror" placeholder="Ex: Numero virement" name="description" value="{{$depense->description}}" />
          @error('description')
          <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
          @enderror
        </div>
      </div>

      <div class="row g-3 mt-2">
        <div class="col-md-12">
          <label class="form-label" for="multicol-banque">Selectionner une Banque</label>
          <select id="multicol-banque" class="select2 form-select @error('banque_id') is-invalid @enderror" data-allow-clear="true" autocomplete="false" name="banque_id" >
            <option value="">Selectionner une banque</option>
            @foreach($banques as $banque)
              <option value="{{$banque->id}}"  @if($banque->id === $depense->banque_id) selected @endif >{{$depense->banque_id}} {{$banque->nom}}</option>

            @endforeach

          </select>
          @error('banque_id')
          <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
          @enderror
        </div>


      </div>
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
        <button type="reset" class="btn btn-label-secondary">Annuler</button>
      </div>
    </form>
  </div>






@endsection
