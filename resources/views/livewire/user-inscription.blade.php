@section('title', 'Register Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">

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


@endsection



<div>




    <div class="row">


      <div class="app-brand mb-4">
        <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">@include('_partials.macros',["height"=>70,"withbg"=>'fill: #fff;'])</span>
        </a>
      </div>
      <h3 class="mb-1">L'aventure commence ici 🚀</h3>
      <div class="card mb-4">
        <h5 class="card-header">Ajout d'un utilisateur</h5>
        <form class="card-body"  wire:submit="save"  >

          <h6>1. Account Details</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="multicol-first-name">Prenom</label>
              <input type="text" id="multicol-first-name" class="form-control @error('prenom') is-invalid @enderror" placeholder="John" name="prenom" />
              @error('prenom')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label" for="multicol-last-name">Nom</label>
              <input type="text" id="multicol-last-name " class="form-control @error('name') is-invalid @enderror" placeholder="Doe" name="name" />
              @error('name')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john.doe@transvie.sn" value="{{ old('email') }}" />
              @error('email')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label" for="multicol-first-name">Poste</label>
              <input type="text" id="multicol-first-second-name " class="form-control @error('poste') is-invalid @enderror" placeholder="Comptable" name="poste"/>
              @error('poste')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
            <div class="col-md-6">
              <div class="form-password-toggle">


                <label class="form-label" for="password">Mot de passe</label>
                <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer">
                <i class="ti ti-eye-off"></i>
              </span>
                </div>
              </div>
              @error('password')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
            <div class="col-md-6">
              <div class="form-password-toggle">
                <label class="form-label" for="password-confirm">Confirm Password</label>
                <div class="input-group input-group-merge  @error('password_confirmation') is-invalid @enderror">
                  <input type="password" id="password-confirm" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <span class="input-group-text cursor-pointer">
                <i class="ti ti-eye-off"></i>
              </span>
                </div>
              </div>
              @error('password_confirmation')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
          </div>


          <div class="row g-3 mt-2">

            <div class="col-md-6">
              <label class="form-label" for="multicol-country">Pays / Country</label>
              <select id="multicol-country" class="select2 form-select @error('pays') is-invalid @enderror" data-allow-clear="true" name="pays">
                <option value="">Select</option>
                @foreach($country as $pays)
                  <option value="{{$pays->id}}">{{$pays->nom}}</option>

                @endforeach



              </select>
              @error('pays')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
            <div class="col-md-6 select2-primary" id="">
              <label class="form-label" for="">Agence</label>
              <select id="agence" class="select2 form-select @error('agence') is-invalid @enderror" data-allow-clear="true" name="agence">

              </select>
              @error('agence')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label" for="multicol-phone">Numéro de Téléphone</label>
              <input type="text" id="multicol-phone" class="form-control phone-mask  @error('telephone') is-invalid @enderror" name="telephone" placeholder="771234567" aria-label="771234567" />
              @error('telephone')
              <span class="invalid-feedback" role="alert">
              <span class="fw-medium">{{ $message }}</span>
            </span>
              @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label" for="multicol-adresse">Adresse</label>
              <input type="text" id="multicol-adresse" class="form-control phone-mask" name="adresse" placeholder="Zone de captage villa No 1826" aria-label="Zone de captage villa No 1826"  />
            </div>
          </div>
          <div class="pt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Envoyer</button>
            <button type="reset" class="btn btn-label-secondary" wire:confirm="Are you sure you want to delete this post?">Annuler</button>
          </div>
        </form>
      </div>

    </div>

</div>

@script
<script>
  $('#multicol-country').on('change', function(){
    var agenceID = $(this).val();
    $('#agence').empty();
    $('#agence').append(`<option value="0" disabled>Chargement des agences en cours..</option>`);

    if(agenceID){
      $.ajax({
        type:'GET',
        url: `${baseUrl}auth/register-basic`,
        data:'id='+agenceID,
        success:function(res){

          $('#agence').empty();
          $('#agence').append(`<option value="0" disabled>Selectionnez l'agence</option>`);
          for( let i =0; i < res.length ; i++){
            $('#agence').append(`<option value="${res[i]['id']}">${res[i]['nom']}</option>`);
          }


        }
      });
    }

  });


</script>
@endscript
