@php
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Adherant')
@section('page-script')
  <script src="{{asset('js/adherent-form.js')}}"></script>
@endsection
@section('content')

  <div class="row">

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Ajout d'un Adhérant / Entreprise</h5>
          <small class="text-muted float-end"></small>
        </div>
        <div class="card-body">
          <form action="{{route('adherant')}}" method="POST"  >
            @csrf
            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-fullname">Prénom</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-fullname1" class="input-group-text @error('prenom')  border-danger text-danger @enderror"><i class="ti ti-user"></i></span>
                <input type="text" class="form-control @error('prenom') is-invalid @enderror " value="{{old('prenom')}}" id="basic-icon-default-fullname" placeholder="John Doe" name="prenom" aria-label="John Doe" aria-describedby="basic-icon-default-fullname1" />
                @error('prenom')
                <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
                @enderror
              </div>

            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-fullname">Nom</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-fullname2" class="input-group-text @error('nom')  border-danger text-danger @enderror"><i class="ti ti-user"></i></span>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" value="{{old('nom')}}" id="basic-icon-default-name" placeholder="John Doe" name="nom" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                @error('nom')
                <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
                @enderror
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-company">Entrerise</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-company2" class="input-group-text @error('entreprise')  border-danger text-danger @enderror"><i class="ti ti-building"></i></span>
                <input type="text" id="basic-icon-default-company" class="form-control @error('entreprise') is-invalid @enderror" value="{{old('entreprise')}}" placeholder="ACME Inc." name="entreprise" aria-label="ACME Inc." aria-describedby="basic-icon-default-company2" />
                @error('entreprise')
                <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
                @enderror
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-phone">Numéro de téléphone</label>
              <div class="input-group ">

                <input type="tel" id="basic-icon-default-phone" class="form-control  @error('telephone') is-invalid @enderror" value="{{old('telephone')}}" name="telephone"   />
                @error('telephone')
                <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
                </span>
                @enderror
                <input type="hidden" name="telephone2" id="telephone2">

              </div>

            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-email">E-mail</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text @error('email')  border-danger text-danger @enderror"><i class="ti ti-mail"></i></span>
                <input type="text" id="basic-icon-default-email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" placeholder="john.doe@transvie.sn" name="email" aria-label="john.doe" aria-describedby="basic-icon-default-email2" />
                @error('email')
                <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
                @enderror
              </div>
{{--                place error message--}}
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-phone">Population</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-population1" class="input-group-text @error('population')  border-danger text-danger @enderror"><i class="ti ti-users"></i></span>
                <input type="text" id="basic-icon-default-population" class="form-control phone-mask @error('population') is-invalid @enderror" value="{{old('population')}}" name="population" placeholder="658" aria-label="658" aria-describedby="basic-icon-default-population1" />
                @error('population')
                <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
                @enderror
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-phone">Montant Attendu</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-population1" class="input-group-text @error('montant')  border-danger text-danger @enderror"><i class="ti ti-wallet"></i></span>
                <input type="text" id="basic-icon-default-population" class="form-control phone-mask @error('montant') is-invalid @enderror" value="{{old('montant')}}" name="montant" placeholder="150000" aria-label="15000" aria-describedby="basic-icon-default-population2" />
                @error('montant')
                <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
                @enderror
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="basic-icon-default-adresse">Adresse</label>
              <div class="input-group input-group-merge">
                <span id="basic-icon-default-adresse1" class="input-group-text @error('adresse')  border-danger text-danger @enderror"><i class="ti ti-home"></i></span>
                <input type="text" id="basic-icon-default-adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{old('adresse')}}" placeholder="Avenue 123 " aria-label="Avenue 123" name="adresse" aria-describedby="basic-icon-default-adresse1" />
                @error('adresse')
                <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
                @enderror
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </form>
        </div>
      </div>

  </div>

@endsection
