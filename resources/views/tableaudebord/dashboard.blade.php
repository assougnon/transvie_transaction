@extends('layouts/layoutMaster')

@section('title', 'Rapport')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
@endsection

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-advance.css')}}">
@endsection

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/swiper/swiper.js')}}"></script>
  <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/tableaudebord.js')}}" ></script>
@endsection

@section('content')

  <div class="row " >


    <!-- Sales for Gambie -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <img src="{{asset('assets/img/flag/gambia-flag.png')}}" alt="Chrome" height="84" class=" rounded">
          <h4 class="mt-1">GAMBIE</h4>
          <span class="text-primary fw-bold fs-5" id="montantGambie"></span><span class="text-primary fw-bold fs-5"> CFA</span>
        </div>
      </div>
    </div>

    <!-- Sessions Last month -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <img src="{{asset('assets/img/flag/ivory-coast-flag.png')}}" alt="Chrome" height="87" class=" rounded">
          <h4 CLASS="text-uppercase">Côte d'Ivoire</h4>
          <span class="text-primary fw-bold fs-5" id="montantCote"></span><span class="text-primary fw-bold fs-5"> CFA</span>
        </div>
      </div>
    </div>

    <!-- Revenue Growth -->


    <!-- Total Profit -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <img src="{{asset('assets/img/flag/benin-flag.png')}}" alt="Chrome" height="80" class=" rounded">
          <h4 class="mt-1">BÉNIN</h4>
          <span class="text-primary fw-bold fs-5" id="montantBenin"></span><span class="text-primary fw-bold fs-5"> CFA</span>
        </div>
      </div>
    </div>

    <!-- Total Sales -->
    <div class="col-xl-2 col-md-4 col-6 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <img src="{{asset('assets/img/flag/togo-flag.png')}}" alt="Chrome" height="80" class=" rounded">
          <h4 class="mt-1">TOGO</h4>
          <span class="text-primary fw-bold fs-5" id="montantTogo"></span><span class="text-primary fw-bold fs-5"> CFA</span>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-md-8 mb-4">
      <div class="card">
        <div class="card-body text-center">
          <img src="{{asset('assets/img/flag/senegal-flag.png')}}" alt="Chrome" height="82" class=" rounded">

          <h4 CLASS="mt-1">SÉNÉGAL</h4>
          <span class="text-primary fw-bold fs-5" id="montantSenegal">@money($montantSenegal) </span><span class="text-primary fw-bold fs-5"> CFA</span>
        </div>
      </div>
    </div>


  </div>


<div class="row">


  <div class="col-12 col-xl-8 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
        <h5 class="card-title mb-0">Données Analytiques du SÉNÉGAL</h5>

      </div>
      <div class="card-body">
        <div id="barChart"></div>
      </div>
    </div>
  </div>


  <!-- Sales last 6 months -->
  <div class="col-md-6 col-xl-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="mb-0">TOTAL DES TRANSACTIONS DU SENEGAL</h5>
          <small class="text-muted">Données du mois {{\Carbon\Carbon::now()->format('F')}}</small>
        </div>

      </div>
      <div class="card-body">
        <div id="donutChart"></div>
      </div>
    </div>
  </div>
  <div class="col-12 ">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
        <h5 class="card-title mb-0">Répartition des données par Agence (SÉNÉGAL) Mois En cours</h5>

      </div>
      <div class="card-body">
        <div id="agenceChart"></div>
      </div>
    </div>
  </div>


  <div class="col-lg-12 mt-4">
    <div class="card h-100">
      <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
        <div class="card-title mb-0">
          <h5 class="mb-0">Banque du SÉNÉGAL</h5>
          <small class="text-muted">Aperçu des gains mensuels</small>
        </div>

        <!-- </div> -->
      </div>
      <div class="card-body">
        <div class="border rounded p-3 mt-4" >
          <div class="row gap-4 gap-sm-0 " id="banquesenegal">


          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="col-xl-4 col-md-6 mt-3   order-1 order-xl-0">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Population par Pays</h5>

        </div>

      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          <li class="d-flex align-items-center mb-4">
            <img src="{{asset('assets/img/flag/gambia-flag.png')}}" alt="User" class="rounded-circle me-3" width="34">
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">GAMBIE</h6>

                </div>

              </div>
              <div class="user-progress d-flex align-items-center gap-2">
                <h4 class="mb-0">{{$populationGambie}} </h4>Adherent(s)
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center mb-4">
            <img src="{{asset('assets/img/flag/senegal-flag.png')}}" alt="User" class="rounded-circle me-3" width="34">
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">SÉNÉGAL</h6>

                </div>

              </div>
              <div class="user-progress d-flex align-items-center gap-2">
                <h4 class="mb-0">{{$populationSenegal}} </h4>Adherent(s)
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center mb-4">
            <img src="{{asset('assets/img/flag/ivory-coast-flag.png')}}" alt="User" class="rounded-circle me-3" width="34">
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">CÔTE D'IVOIRE</h6>

                </div>

              </div>
              <div class="user-progress d-flex align-items-center gap-2">
                <h4 class="mb-0">{{$populationCote}} </h4>Adherent(s)
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center mb-4">
            <img src="{{asset('assets/img/flag/benin-flag.png')}}" alt="User" class="rounded-circle me-3" width="34">
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">BENIN</h6>

                </div>

              </div>
              <div class="user-progress d-flex align-items-center gap-2">
                <h4 class="mb-0">{{$populationBenin}} </h4>Adherent(s)
              </div>
            </div>
          </li>
          <li class="d-flex align-items-center mb-4">
            <img src="{{asset('assets/img/flag/togo-flag.png')}}" alt="User" class="rounded-circle me-3" width="34">
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">TOGO</h6>

                </div>

              </div>
              <div class="user-progress d-flex align-items-center gap-2">
                <h4 class="mb-0">{{$populationTogo}} </h4>Adherent(s)
              </div>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </div>


  <div class="col-12 col-xl-8  mt-3">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
        <h5 class="card-title mb-0">Données Analytiques du Benin</h5>

      </div>
      <div class="card-body">
        <div id="barChartBenin"></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-xl-6 mt-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
        <h5 class="card-title mb-0">Données Analytiques du CÔTE D'IVOIRE</h5>

      </div>
      <div class="card-body">
        <div id="barCoteIvoire"></div>
      </div>
    </div>
  </div>

  <div class="col-6 col-xl-6 mt-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
        <h5 class="card-title mb-0">Données Analytiques du TOGO</h5>

      </div>
      <div class="card-body">
        <div id="barTogo"></div>
      </div>
    </div>
  </div>
  <div class="col-12 col-xl-12 mt-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
        <h5 class="card-title mb-0">Données Analytiques de la GAMBIE</h5>

      </div>
      <div class="card-body">
        <div id="barGambie"></div>
      </div>
    </div>
  </div>

</div>

@endsection
