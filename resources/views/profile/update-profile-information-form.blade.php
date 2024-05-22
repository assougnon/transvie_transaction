<x-form-section submit="updateProfileInformation">
  <x-slot name="title">
    {{ __('Profile Information') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Mettez à jour les informations de profil.') }}
  </x-slot>

  <x-slot name="form">

    <x-action-message on="saved">
      {{ __('Saved.') }}
    </x-action-message>

    <!-- Profile Photo -->
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
      <div class="mb-3" x-data="{photoName: null, photoPreview: null}">
        <!-- Profile Photo File Input -->
        <input type="file" hidden wire:model.live="photo" x-ref="photo"
          x-on:change=" photoName = $refs.photo.files[0].name; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result;}; reader.readAsDataURL($refs.photo.files[0]);" />

        <!-- Current Profile Photo -->
      {{--  <div class="mt-2" x-show="! photoPreview">
          <img src="{{ $this->user->profile_photo_url }}" class="rounded-circle" height="80px" width="80px">
        </div>
--}}
        <!-- New Profile Photo Preview -->
        <div class="mt-2" x-show="photoPreview">
          <img x-bind:src="photoPreview" class="rounded-circle" width="80px" height="80px">
        </div>

        <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
          {{ __('Select A New Photo') }}
        </x-secondary-button>

        @if ($this->user->profile_photo_path)
          <button type="button" class="btn btn-danger text-uppercase mt-2" wire:click="deleteProfilePhoto">
            {{ __('Remove Photo') }}
          </button>
        @endif

        <x-input-error for="photo" class="mt-2" />
      </div>
    @endif

    <!-- Name -->
    <div class="mb-3">
      <x-label class="form-label" for="prenom" value="{{ __('Prénom') }}" />
      <div class="input-group input-group-merge">
        <span id="basic-icon-default-phone2" class="input-group-text"><i class="ti ti-user"></i></span>
      <x-input id="prenom" type="text" class="{{ $errors->has('prenom') ? 'is-invalid' : '' }}"
        wire:model.live="state.prenom" autocomplete="prenom" />
      <x-input-error for="prenom" />
      </div>
    </div>
    <div class="mb-3">
      <x-label class="form-label" for="name" value="{{ __('Name') }}" />
      <div class="input-group input-group-merge">
        <span id="basic-icon-default-phone2" class="input-group-text"><i class="ti ti-user"></i></span>
      <x-input id="name" type="text" class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
        wire:model.live="state.name" autocomplete="name" />
      <x-input-error for="name" />
      </div>
    </div>

    <!-- Email -->
    <div class="mb-3">
      <x-label class="form-label" for="email" value="{{ __('Email') }}" />
      <div class="input-group input-group-merge">
        <span id="basic-icon-default-phone2" class="input-group-text"><i class="ti ti-mail"></i></span>
      <x-input id="email" type="email" class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
        wire:model.live="state.email" />
      <x-input-error for="email" />
      </div>
    </div>

    <div class="mb-3">
      <x-label class="form-label" for="telephone" value="{{ __('Téléphone') }}" />
      <div class="input-group input-group-merge">
        <span id="basic-icon-default-phone2" class="input-group-text"><i class="ti ti-phone-call"></i></span>
        <x-input id="telephone" type="text" class="{{ $errors->has('telephone') ? 'is-invalid' : '' }}"
                 wire:model.live="state.telephone" autocomplete="telephone" />
      <x-input-error for="telephone" />
      </div>
    </div>

    <div class="mb-3">
      <x-label class="form-label" for="adresse" value="{{ __('Adresse') }}" />
      <div class="input-group input-group-merge">
        <span id="basic-icon-default-phone2" class="input-group-text"><i class="ti ti-home"></i></span>
        <x-input id="adresse" type="text" class="{{ $errors->has('adresse') ? 'is-invalid' : '' }}"
                 wire:model.live="state.adresse" autocomplete="adresse" />
        <x-input-error for="adresse" />
      </div>

    </div>

    <div class="mb-3">
      <x-label class="form-label" for="poste" value="{{ __('Poste') }}" />
      <div class="input-group input-group-merge">
        <span id="basic-icon-default-phone2" class="input-group-text"><i class="ti ti-receipt"></i></span>
        <x-input id="poste" type="text" class="{{ $errors->has('poste') ? 'is-invalid' : '' }}"
                 wire:model.live="state.poste" autocomplete="poste" />
      <x-input-error for="poste" />
      </div>
    </div>
  </x-slot>

  <x-slot name="actions">
    <div class="d-flex align-items-baseline">
      <x-button >
        {{ __('Save') }}
      </x-button>
    </div>
  </x-slot>
</x-form-section>
