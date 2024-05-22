<div>
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Profile Utilisateur </span>
  </h4>


  <!-- Header -->
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="user-profile-header-banner">
          <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top">
        </div>
        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
          <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
            <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img" >
          </div>
          <div class="flex-grow-1 mt-3 mt-sm-5">
            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
              <div class="user-profile-info">
                <h4>{{$userinfo->prenom.' '.$userinfo->name}}</h4>
                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                  <li class="list-inline-item d-flex gap-1">
                    <i class='ti ti-color-swatch'></i> {{Auth::user()->poste}}
                  </li>
                  <li class="list-inline-item d-flex gap-1">
                    <i class='ti ti-map-pin'></i> {{Auth::user()->adresse}}
                  </li>
                  <li class="list-inline-item d-flex gap-1">
                    <i class='ti ti-calendar'></i> Inscrit le {{$userinfo->date_for_human}}
                  </li>
                </ul>
              </div>
              <a href="javascript:void(0)" class="btn btn-primary" wire:click="testsms">
                <i class='ti ti-check me-1'></i>Connected
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Header -->

  <!-- Navbar pills -->
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-pills flex-column flex-sm-row mb-4">
        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class='ti-xs ti ti-user-check me-1'></i> Profile</a></li>

      </ul>
    </div>
  </div>
  <!--/ Navbar pills -->

  <!-- User Profile Content -->
  <div class="row">

    <div class="col-xl-8 col-lg-7 col-md-7">
      @if (Laravel\Fortify\Features::canUpdateProfileInformation())
        <div class="mb-4">
          @livewire('profile.update-profile-information-form')
        </div>
      @endif

    </div>
    <div class="col-xl-4 col-lg-5 col-md-5">
      <!-- About User -->
      <div class="card mb-4">
        <div class="card-body">
          <small class="card-text text-uppercase">A-propos</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3"><i class="ti ti-user text-heading"></i><span class="fw-medium mx-2 text-heading">Prénom :</span> <span>{{$userinfo->prenom}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-user text-heading"></i><span class="fw-medium mx-2 text-heading">Nom:</span> <span>{{$userinfo->name}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-check text-heading"></i><span class="fw-medium mx-2 text-heading">Status:</span> <span>{{$userinfo->statut === 1 ? 'active' : 'inactive'}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-crown text-heading"></i><span class="fw-medium mx-2 text-heading">Poste:</span> <span>{{$userinfo->poste}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-flag text-heading"></i><span class="fw-medium mx-2 text-heading">Pays / Country:</span> <span>{{$userinfo->agence->pays->nom}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-home text-heading"></i><span class="fw-medium mx-2 text-heading">Adresse :</span> <span>{{$userinfo->adresse}}</span></li>
          </ul>
          <small class="card-text text-uppercase">Contact</small>
          <ul class="list-unstyled mb-4 mt-3">
            <li class="d-flex align-items-center mb-3"><i class="ti ti-phone-call"></i><span class="fw-medium mx-2 text-heading">Téléphone :</span> <span>{{$userinfo->telephone}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-mail"></i><span class="fw-medium mx-2 text-heading">E-mail:</span> <span>{{$userinfo->email}}</span></li>
          </ul>

        </div>
      </div>
      <!--/ About User -->
      <!-- Profile Overview -->
      <div class="card mb-4">
        <div class="card-body">
          <p class="card-text text-uppercase">Agence</p>
          <ul class="list-unstyled mb-0">
            <li class="d-flex align-items-center mb-3"><i class="ti ti-check"></i><span class="fw-medium mx-2">Nom :</span> <span>{{$userinfo->agence->nom}}</span></li>
            <li class="d-flex align-items-center mb-3"><i class="ti ti-home"></i><span class="fw-medium mx-2">Adresse:</span> <span>{{$userinfo->agence->adresse}}</span></li>
          </ul>
        </div>
      </div>
      <!--/ Profile Overview -->
    </div>
  </div>

</div>
