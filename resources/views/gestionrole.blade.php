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
    <h5 class="card-header">Roles des Utilisateurs </h5>
    <form class="card-body" action="{{route('create-role')}}" method="POST" >
      @csrf

      <h6></h6>



      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="multicol-country">Utilisateur</label>
          <select id="multicol-user" class="select2 form-select" data-allow-clear="true" name="utilisateur">
            <option value="">Choisir l'utilisateur</option>
            @foreach($users as $user)
              <option value="{{$user->id}}">{{$user->prenom}} {{$user->name}}</option>
            @endforeach
          </select>
          @error('utilisateur')

          <span class="fw-medium text-danger">{{ $message }}</span>

          @enderror
        </div>
        <div class="col-md-6 select2-primary">
          <label class="form-label" for="multicol-language">Rôles</label>
          <select id="multicol-role" class="select2 form-select" name="role" >
            <option value="">Choisir le Rôle</option>
            @foreach($roles as $role)
              <option value="{{$role->name}}">{{$role->name}}</option>
            @endforeach

          </select>
          @error('role')

          <span class="fw-medium text-danger">{{ $message }}</span>

          @enderror
        </div>

      </div>
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Assigner le Rôle</button>

      </div>
    </form>
  </div>
  <div class="card">
    <h5 class="card-header">Utilisateurs </h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
        <tr>
          <th>Prenom</th>
          <th>Nom</th>
          <th>Pays</th>
          <th>Agence</th>
          <th>Role</th>

        </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        @foreach($users as $user)
        <tr>
          <td> <span class="fw-medium">{{$user->prenom}}</span></td>
          <td>{{$user->name}}</td>
          <td>{{$user->agence->pays->nom}}</td>
          <td>{{$user->agence->nom}}</td>
          <td>{{$user->getRoleNames()}}</td>

        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

@endsection
