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
  <h4 class="py-3 mb-4"><span class="text-muted fw-light">Enregistrement/</span>D'une transaction</h4>



  <!-- Multi Column with Form Separator -->
  <div class="card mb-4">
    <h5 class="card-header">Enregistrement de la Transaction Nº{{$transaction_id}}</h5>
    <form class="card-body" method="POST" action="/transaction-list">
    @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="multicol-adherent">Selectionner l'Adherent</label>
          <select id="multicol-adherent" class="select2 form-select @error('adherant_id') is-invalid @enderror" data-allow-clear="true" name="adherant_id" autocomplete="false">
            <option value="">Select</option>
            @foreach($adherents as $adherent)
              <option value="{{$adherent->id}}">{{$adherent->prenom.' '.$adherent->nom.' - '.$adherent->telephone}}</option>
            @endforeach

          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="multicol-montant">Montant de la transaction</label>
          <div class="input-group input-group-merge">
            <input type="number" name="montant" id="multicol-montant" class="form-control @error('montant') is-invalid @enderror" placeholder="12300000" aria-label="100000" aria-describedby="multicol-montant"  autocomplete="false"/>

          </div>
        </div>
        <div class="col-md-6">

            <label class="form-label" for="multicol-type">Type de la transaction</label>
            <select id="multicol-type" class="select2 form-select @error('type') is-invalid @enderror" data-allow-clear="true" autocomplete="false" name="type" >
              <option value="" >Selectionner le type de transaction</option>
              <option value="Cheque" >Chèque</option>
              <option value="Espece" >Espèce</option>
              <option value="Mobile_money">Mobile Money</option>
              <option value="Virement_bancaire">Virement Bancaire</option>
            </select>

        </div>
        <div class="col-md-6">
          <label class="form-label" for="multicol-note">Note</label>
          <input type="text" id="multicol-note" class="form-control @error('note') is-invalid @enderror" placeholder="Ex: Numero virement" name="note" />
        </div>
      </div>

      <div class="row g-3 mt-2">
        <div class="col-md-12">
          <label class="form-label" for="multicol-banque">Selectionner une Banque</label>
          <select id="multicol-banque" class="select2 form-select @error('banque_id') is-invalid @enderror" data-allow-clear="true" autocomplete="false" name="banque_id" >
            <option value="">Selectionner une banque</option>
            @foreach($banques as $banque)
              <option value="{{$banque->id}}">{{$banque->nom}}</option>
            @endforeach

          </select>
        </div>


      </div>
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
        <button type="reset" class="btn btn-label-secondary">Annuler</button>
      </div>
    </form>
  </div>






@endsection
