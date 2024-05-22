@extends('layouts/layoutMaster')

@section('title', 'User Management - Crud App')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave.js')}}"></script>
<script src="{{asset('assets/vendor/libs/cleavejs/cleave-phone.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/laravel-user-management.js')}}"></script>
@endsection

@section('content')

<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Users</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$totalUser}}</h3>
              <small class="text-success">(100%)</small>
            </div>
            <small>Total des Utilisateurs </small>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="ti ti-user ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Utilisateurs Vérifiés</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$verified}}</h3>
              <small class="text-success">(+95%)</small>
            </div>
            <small>Récent </small>
          </div>
          <span class="badge bg-label-success rounded p-2">
            <i class="ti ti-user-check ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Utilisateur en Doublon</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$userDuplicates}}</h3>
              <small class="text-success">(0%)</small>
            </div>
            <small>Analyses Récentes</small>
          </div>
          <span class="badge bg-label-danger rounded p-2">
            <i class="ti ti-users ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>En Attente de vérification</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">{{$notVerified}}</h3>
              <small class="text-danger">(+6%)</small>
            </div>
            <small>Analyses Récentes</small>
          </div>
          <span class="badge bg-label-warning rounded p-2">
            <i class="ti ti-user-circle ti-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Users List Table -->
<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0">Filtre de recherche</h5>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="border-top">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Prenom & Nom</th>
          <th>Email</th>
          <th>Telephone</th>
          <th>Pays</th>
          <th>Vérifiés</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- Offcanvas to add new user -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header">
      <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Ajouter un utilisateur</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0">
      <form class="add-new-user pt-0" id="addNewUserForm">
        <input type="hidden" name="id" id="user_id">
        <div class="mb-3">
          <label class="form-label" for="add-user-fullname">Prenom</label>
          <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe" name="prenom" aria-label="John Doe" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-fullname">NOM</label>
          <input type="text" class="form-control" id="add-user-name" placeholder="John Doe" name="name" aria-label="John Doe" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-email">Email</label>
          <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email" />
        </div>
        <div class="mb-3">
          <label class="form-label" for="add-user-contact">Telephone</label>
          <input type="text" id="add-user-contact" class="form-control phone-mask" placeholder="+1 (609) 988-44-11" aria-label="john.doe@example.com" name="telephone" />
        </div>
        <div class="mb-3">
          <div class="form-password-toggle">


            <label class="form-label" for="password">Mot de passe</label>
            <div class="input-group input-group-merge ">
              <input type="password" id="password" class="form-control "
                     name="password"
                     placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                     aria-describedby="password"/>
              <span class="input-group-text cursor-pointer">
                <i class="ti ti-eye-off"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="user-role">Poste</label>
          <select id="user-poste" class="form-select" name="poste">
            <option value="Directrice Commerciale et Recouvrement">Directrice Commerciale et Recouvrement</option>
            <option value="Agent Comptable">Agent Comptable</option>
            <option value="Directeur Commercial">Directeur Commercial</option>
            <option value="Directrice Marketing et Com">Directrice Marketing et Com</option>
            <option value="Directeur Exploitation">Directeur Exploitation</option>
            <option value="Directrice  Sinistre">Directrice  Sinistre</option>
            <option value="Assistante de Direction">Assistante de Direction  </option>
            <option value="Responsable Agence">Responsable Agence</option>
            <option value="Responsable Agence">Responsable Agence</option>
            <option value="Gestionnaire d'Agence">Gestionnaire d'Agence</option>
            <option value="Gestionnaire prestations">Gestionnaire prestations</option>
            <option value="Gestionnaire production">Gestionnaire production</option>
            <option value="Commercial(e)">Commercial(e)</option>
            <option value="Responsable Commercial(e)">Responsable Commercial(e)</option>
            <option value="Réceptionniste">Réceptionniste</option>
            <option value="Agent de recouvrement">Agent de recouvrement</option>
            <option value="Gestionnaire Pôle Professionnel">Gestionnaire Pôle Professionnel</option>
            <option value="Directrice Comptable et Financière">Directrice Comptable et Financière</option>
            <option value="Chauffeur">Chauffeur</option>
            <option value="Coursier">Coursier</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="form-label" for="user-plan">Pays</label>
          <select id="user-contry" class="form-select" name="pays">
            <option value="" disabled>Veuillez selectionner un pays</option>
            @foreach($pays as $pays)
              <option value="{{$pays->id}}">{{$pays->nom}}</option>
            @endforeach

          </select>
        </div>
        <div class="mb-4">
          <label class="form-label" for="user-plan">Agences</label>
          <select name="agence" id="user-agence" class="form-select">

          </select>
        </div>
        <div class="mb-4">
          <label class="form-label" for="user-adresse">Adresse</label>
          <input type="text" name="adresse" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Envoyer</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Annuler</button>
      </form>
    </div>
  </div>
</div>



@endsection
