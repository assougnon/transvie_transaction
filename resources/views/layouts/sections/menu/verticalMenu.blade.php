@php
  $configData = Helper::appClasses();
  $user = \Illuminate\Support\Facades\Auth::user();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  @if(!isset($navbarFull))
    <div class="app-brand demo">
      <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        @include('_partials.macros',["height"=>20])
      </span>
        <span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
      </a>
    </div>
  @endif


  <div class="menu-inner-shadow"></div>

  {{-- <ul class="menu-inner py-1">
     @foreach ($menuData[0]->menu as $menu)

       --}}{{-- adding active and open class if child is active --}}{{--

       --}}{{-- menu headers --}}{{--
       @if (isset($menu->menuHeader))
         <li class="menu-header small text-uppercase">
           <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
         </li>

       @else

         --}}{{-- active menu method --}}{{--
         @php
           $activeClass = null;
           $currentRouteName = Route::currentRouteName();

           if ($currentRouteName === $menu->slug) {
           $activeClass = 'active';
           }
           elseif (isset($menu->submenu)) {
           if (gettype($menu->slug) === 'array') {
           foreach($menu->slug as $slug){
           if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
           $activeClass = 'active open';
           }
           }
           }
           else{
           if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
           $activeClass = 'active open';
           }
           }

           }
         @endphp

         --}}{{-- main menu --}}{{--

         <li class="menu-item {{$activeClass}}">
           <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
              class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
              @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
             @isset($menu->icon)
               <i class="{{ $menu->icon }}"></i>
             @endisset
             <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
             @isset($menu->badge)
               <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>

             @endisset
           </a>

           --}}{{-- submenu --}}{{--
           @isset($menu->submenu)
             @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
           @endisset
         </li>
       @endif
     @endforeach

     <li class="menu-item">
       <a href="" class="menu-link menu-toggle" target="_blank">

         <i class=" menu-icon fa-solid fa-money-bill"></i>
         <div>Dépenses</div>
         <div class="badge rounded-pill ms-auto"></div>
       </a>
       <ul class="menu-sub">


         <li class="menu-item ">
           <a href="{{env('APP_URL','http://127.0.0.1:8000')}}/add/depense" class="menu-link">
             <div>Ajouter une dépense</div>
           </a>
         </li>
         <li class="menu-item ">
           <a href="{{env('APP_URL','http://127.0.0.1:8000')}}/depenses" class="menu-link">
             <div>Liste des dépenses</div>
           </a>
         </li>

       </ul>
     </li>

   </ul>--}}
  <ul class="menu-inner py-1 ps">

    @can('manage dashbord')
    <li class="menu-item" style="">
      <a href="javascript:void(0);" class="menu-link menu-toggle" data-bcup-haslogintext="no">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div>Tableaux de bord</div>
      </a>


      <ul class="menu-sub">


        <li class="menu-item ">
          <a href="{{url('/rapport')}}" class="menu-link" data-bcup-haslogintext="no">
            <div>Rapports</div>
          </a>


        </li>
      </ul>
    </li>

    @endcan
    @can('manage adherent')
    <li class="menu-item ">
      <a href="javascript:void(0);" class="menu-link menu-toggle" data-bcup-haslogintext="no">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div>Adhérant</div>
      </a>


      <ul class="menu-sub">


        <li class="menu-item ">
          <a href="{{url('/adherant')}}" class="menu-link" data-bcup-haslogintext="no">
            <div>Liste Des Adhérants</div>
          </a>


        </li>


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/adherant/create" class="menu-link" data-bcup-haslogintext="no">
            <div>Ajouter</div>
          </a>


        </li>
      </ul>
    </li>
      @endcan
    @can('manage transaction')
    <li class="menu-item ">
      <a href="javascript:void(0);" class="menu-link menu-toggle" data-bcup-haslogintext="no">
        <i class="menu-icon tf-icons ti ti-wallet"></i>
        <div>Transaction</div>
      </a>


      <ul class="menu-sub">


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/transaction" class="menu-link" data-bcup-haslogintext="no">
            <div>Liste des Transactions</div>
          </a>
        </li>

        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/transaction" class="menu-link" data-bcup-haslogintext="no">
            <div>Transactions Générales</div>
          </a>
        </li>


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/transaction-list/create" class="menu-link" data-bcup-haslogintext="no">
            <div>Ajouter une Transaction</div>
          </a>


        </li>
      </ul>
    </li>
      @endcan
      @can('manage bank')
    <li class="menu-item ">
      <a href="javascript:void(0);" class="menu-link menu-toggle" data-bcup-haslogintext="no">
        <i class="menu-icon tf-icons ti ti-building-bank"></i>
        <div>Banques</div>
      </a>


      <ul class="menu-sub">


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/banques/create" class="menu-link" data-bcup-haslogintext="no">
            <div>Ajouter une banque</div>
          </a>


        </li>


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/banques" class="menu-link" data-bcup-haslogintext="no">
            <div>Liste des Banques</div>
          </a>


        </li>
      </ul>
    </li>
      @endcan
    @can('manage users')
    <li class="menu-item ">
      <a href="javascript:void(0);" class="menu-link menu-toggle" data-bcup-haslogintext="no">
        <i class="menu-icon tf-icons ti ti-settings"></i>
        <div>Utilisateurs</div>
      </a>


      <ul class="menu-sub">


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/laravel/user-management" class="menu-link" data-bcup-haslogintext="no">
            <div>Gestion des Utilisateurs</div>
          </a>


        </li>


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/gestion-role" class="menu-link" data-bcup-haslogintext="no">
            <div>Gestion des Roles</div>
          </a>


        </li>
      </ul>
    </li>
      @endcan
    @can('manage remises')
    <li class="menu-item ">
      <a href="javascript:void(0);" class="menu-link menu-toggle" data-bcup-haslogintext="no">
        <i class="menu-icon tf-icons ti ti-file"></i>
        <div>Remises</div>
      </a>


      <ul class="menu-sub">


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/remise/create" class="menu-link" data-bcup-haslogintext="no">
            <div>Ajouter une remise</div>
          </a>


        </li>


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/remise" class="menu-link" data-bcup-haslogintext="no">
            <div>Liste des remises</div>
          </a>


        </li>
      </ul>
    </li>
      @endcan
      @can('manage depense')
    <li class="menu-item">
      <a href="" class="menu-link menu-toggle" target="_blank" data-bcup-haslogintext="no">

        <i class=" menu-icon fa-solid fa-money-bill"></i>
        <div>Dépenses</div>
        <div class="badge rounded-pill ms-auto"></div>
      </a>
      <ul class="menu-sub">


        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/add/depense" class="menu-link" data-bcup-haslogintext="no">
            <div>Ajouter une dépense</div>
          </a>
        </li>
        <li class="menu-item ">
          <a href="http://127.0.0.1:8000/depenses" class="menu-link" data-bcup-haslogintext="no">
            <div>Liste des dépenses</div>
          </a>
        </li>

      </ul>
    </li>
      @endcan
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
      <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
    </div>
    <div class="ps__rail-y" style="top: 0px; right: 4px;">
      <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
    </div>
  </ul>
</aside>
