<div>
  <input wire:model.live="search">
    <x-table>

      <x-slot name="head">
          <x-table.heading> </x-table.heading>
          <x-table.heading> Prénom</x-table.heading>
          <x-table.heading> Nom</x-table.heading>
          <x-table.heading> Email</x-table.heading>
          <x-table.heading> Telephone</x-table.heading>
          <x-table.heading> Pays</x-table.heading>

          <x-table.heading> Poste</x-table.heading>
          <x-table.heading> Action</x-table.heading>

      </x-slot>
      <x-slot name="body">
        @foreach($users as $user)
          <x-table.row>
            <x-table.cell><img src="{{$user->profile_photo_url}}" alt="Avatar" class=" avatar avatar-online rounded-circle"></x-table.cell>
            <x-table.cell>{{''.$user->prenom}}</x-table.cell>
            <x-table.cell> {{$user->name}}</x-table.cell>
            <x-table.cell> {{$user->email}}</x-table.cell>
            <x-table.cell> {{$user->telephone}}</x-table.cell>
            <x-table.cell> {{$user->pays}}</x-table.cell>
            <x-table.cell> {{$user->poste}}</x-table.cell>
            <x-table.cell> </x-table.cell>

          </x-table.row>
        @endforeach
      </x-slot>
    </x-table>





</div>
