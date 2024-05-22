@extends('layouts/layoutMaster')

@section('title', ' Modification d\'une transaction')

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
  <h4 class="py-3 mb-4"><span class="text-muted fw-light">Modification/</span>D'une transaction</h4>



  <!-- Multi Column with Form Separator -->
  <div class="card mb-4">
    <h5 class="card-header">Modification de la Transaction Nº{{$transaction->numero}}</h5>
    <form class="card-body" method="POST" action="/transaction-update">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="multicol-adherent">Selectionner l'Adherent</label>
          <select id="multicol-adherent" class="select2 form-select @error('adherant_id') is-invalid @enderror" data-allow-clear="true" name="adherant_id" autocomplete="false">
            <option value="">Select</option>
            @if(empty($adherentActuel))
              <option value="" disabled >l'adherant a été supprimé</option>
            @else
            @foreach($adherents as $adherent)
              <option value="{{$adherent->id}}" @if($adherent->id === $transaction->adherant_id) selected @endif>{{$adherent->prenom.' '.$adherent->nom.' - '.$adherent->telephone}}</option>

            @endforeach
            @endif
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="multicol-montant">Montant de la transaction</label>
          <div class="input-group input-group-merge">
            <input type="number" name="montant" id="multicol-montant" class="form-control @error('montant') is-invalid @enderror" placeholder="12300000" aria-label="100000" aria-describedby="multicol-montant"  autocomplete="false" value="{{$transaction->montant}}"/>

          </div>
        </div>
        <div class="col-md-6">

          <label class="form-label" for="multicol-type">Type de la transaction</label>
          <select id="multicol-type" class="select2 form-select @error('type') is-invalid @enderror" data-allow-clear="true" autocomplete="false" name="type" >
            <option value="" >Selectionner le type de transaction</option>
            <option value="Cheque" @if($transaction->type === "Cheque" ) selected @endif >Chèque</option>
            <option value="Espece" @if($transaction->type === "Espece" ) selected @endif >Espèce</option>
            <option value="Mobile_money" @if($transaction->type === "Mobile_money" ) selected @endif >Mobile Money</option>
            <option value="Virement_bancaire" @if($transaction->type === "Virement_bancaire" ) selected @endif >Virement Bancaire</option>
          </select>

        </div>
        <div class="col-md-6">
          <label class="form-label" for="multicol-note">Note</label>
          <input type="text" id="multicol-note" class="form-control @error('note') is-invalid @enderror" placeholder="Ex: Numero virement" name="note" value="{{$transaction->note}}"/>
          <input type="hidden" name="numero" value="{{$transaction->numero}}">
        </div>
      </div>

      <div class="row g-3 mt-2">
        <div class="col-md-6">
          <label class="form-label" for="multicol-banque">Selectionner une Banque</label>
          <select id="multicol-banque" class="select2 form-select @error('banque_id') is-invalid @enderror" data-allow-clear="true" autocomplete="false" name="banque_id" >
            <option value="">Selectionner une banque</option>
            @foreach($banques as $banque)
              <option value="{{$banque->id}}" @if($transaction->banque_id === $banque->id) selected @endif>{{$banque->nom}}</option>
            @endforeach

          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label" for="multicol-statut">Statut de la Transaction</label>
          <select name="statut" id="multicol-statut " class="form-control select2 @error('statut') is-invalid @enderror">
            <option value="Encours" @if($transaction->statut === "Encours" ) selected @endif >Encours</option>
            <option value="Terminee"  @if($transaction->statut === "Terminee" ) selected @endif>Terminée</option>
            <option value="Impayee"@if($transaction->statut === "Impayee" ) selected @endif>Impayée</option>
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
