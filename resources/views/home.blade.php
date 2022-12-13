@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini">
    <div class="page">
        <div class="page-main">
            <div class="app-content main-content mt-0">
                <div class="side-app">
                    <div class="main-container container-fluid">
                        <div class="page-header">
                            <div>
                                <h1 class="page-title">Dashboard</h1>
                            </div>
                            <div class="ms-auto pageheader-btn">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                        @can('/usuario.index')
                        <div class="row">
                            @php
                            $counter = 0;
                            $items = [
                            0 => ['color'=>'indigo', 'icon'=> 'fa fa-user'],
                            1 => ['color'=>'primary','icon'=> 'fa fa-ra'],
                            2 => ['color'=>'info','icon'=> 'fa fa-minus'],
                            3 => ['color'=>'cyan','icon'=> 'fa fa-info']
                            ];
                            @endphp
                            @foreach ($request_status as $key => $statu)
                            <div style="display: none">
                                {{$counter = $counter + $statu->count }}
                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 class="mb-2 fw-semibold">{{$statu->count}}</h3>
                                                <p class="text-muted fs-13 mb-0">{{$statu->status}}</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div
                                                    class="counter-icon bg-{{$items[$key]['color']}} dash ms-auto box-shadow-primary">
                                                    <i class="{{$items[$key]['icon']}}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 class="mb-2 fw-semibold">{{$counter}}</h3>
                                                <p class="text-muted fs-13 mb-0">TOTAL AFILIADOS</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div class="counter-icon bg-gray dash ms-auto box-shadow-primary">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                        @can('/facturas')
                        <div id="global-loader2">
                            <img src={{asset('assets/images/loader.svg')}} class="loader-img" alt="Loader">
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 id="mtPagadas" class="mb-2 fw-semibold">
                                                </h3>
                                                <p class="text-muted fs-13 mb-0">Monto de Facturas pagadas</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div class="counter-icon bg-primary dash ms-auto box-shadow-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                                        <path
                                                            d="M12,8c-2.2091675,0-4,1.7908325-4,4s1.7908325,4,4,4c2.208252-0.0021973,3.9978027-1.791748,4-4C16,9.7908325,14.2091675,8,12,8z M12,15c-1.6568604,0-3-1.3431396-3-3s1.3431396-3,3-3c1.6561279,0.0018311,2.9981689,1.3438721,3,3C15,13.6568604,13.6568604,15,12,15z M21.960022,11.8046875C19.9189453,6.9902344,16.1025391,4,12,4s-7.9189453,2.9902344-9.960022,7.8046875c-0.0537109,0.1246948-0.0537109,0.2659302,0,0.390625C4.0810547,17.0097656,7.8974609,20,12,20s7.9190063-2.9902344,9.960022-7.8046875C22.0137329,12.0706177,22.0137329,11.9293823,21.960022,11.8046875z M12,19c-3.6396484,0-7.0556641-2.6767578-8.9550781-7C4.9443359,7.6767578,8.3603516,5,12,5s7.0556641,2.6767578,8.9550781,7C19.0556641,16.3232422,15.6396484,19,12,19z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 id="mtPorPagar" class="mb-2 fw-semibold"></h3>
                                                <p class="text-muted fs-13 mb-0">Monto de Facturas por Pagar</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div
                                                    class="counter-icon bg-secondary dash ms-auto box-shadow-secondary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                                        <path
                                                            d="M19.5,7H16V5.9169922c0-2.2091064-1.7908325-4-4-4s-4,1.7908936-4,4V7H4.5C4.4998169,7,4.4996338,7,4.4993896,7C4.2234497,7.0001831,3.9998169,7.223999,4,7.5V19c0.0018311,1.6561279,1.3438721,2.9981689,3,3h10c1.6561279-0.0018311,2.9981689-1.3438721,3-3V7.5c0-0.0001831,0-0.0003662,0-0.0006104C19.9998169,7.2234497,19.776001,6.9998169,19.5,7z M9,5.9169922c0-1.6568604,1.3431396-3,3-3s3,1.3431396,3,3V7H9V5.9169922z M19,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2H7c-1.1040039-0.0014038-1.9985962-0.8959961-2-2V8h3v2.5C8,10.776123,8.223877,11,8.5,11S9,10.776123,9,10.5V8h6v2.5c0,0.0001831,0,0.0003662,0,0.0005493C15.0001831,10.7765503,15.223999,11.0001831,15.5,11c0.0001831,0,0.0003662,0,0.0006104,0C15.7765503,10.9998169,16.0001831,10.776001,16,10.5V8h3V19z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 id="mtPagadasConNovedad" class="mb-2 fw-semibold"></h3>
                                                <p class="text-muted fs-13 mb-0">Monto de Facturas Pagadas con Novedad
                                                </p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div class="counter-icon bg-info dash ms-auto box-shadow-info">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                                        <path
                                                            d="M7.5,12C7.223877,12,7,12.223877,7,12.5v5.0005493C7.0001831,17.7765503,7.223999,18.0001831,7.5,18h0.0006104C7.7765503,17.9998169,8.0001831,17.776001,8,17.5v-5C8,12.223877,7.776123,12,7.5,12z M19,2H5C3.3438721,2.0018311,2.0018311,3.3438721,2,5v14c0.0018311,1.6561279,1.3438721,2.9981689,3,3h14c1.6561279-0.0018311,2.9981689-1.3438721,3-3V5C21.9981689,3.3438721,20.6561279,2.0018311,19,2z M21,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2H5c-1.1040039-0.0014038-1.9985962-0.8959961-2-2V5c0.0014038-1.1040039,0.8959961-1.9985962,2-2h14c1.1040039,0.0014038,1.9985962,0.8959961,2,2V19z M12,6c-0.276123,0-0.5,0.223877-0.5,0.5v11.0005493C11.5001831,17.7765503,11.723999,18.0001831,12,18h0.0006104c0.2759399-0.0001831,0.4995728-0.223999,0.4993896-0.5v-11C12.5,6.223877,12.276123,6,12,6z M16.5,10c-0.276123,0-0.5,0.223877-0.5,0.5v7.0005493C16.0001831,17.7765503,16.223999,18.0001831,16.5,18h0.0006104C16.7765503,17.9998169,17.0001831,17.776001,17,17.5v-7C17,10.223877,16.776123,10,16.5,10z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 id="totalFt" class="mb-2 fw-semibold"></h3>
                                                <p class="text-muted fs-13 mb-0">Numero Total de Facturas</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div class="counter-icon bg-warning dash ms-auto box-shadow-warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                                        <path
                                                            d="M9,10h2.5c0.276123,0,0.5-0.223877,0.5-0.5S11.776123,9,11.5,9H10V8c0-0.276123-0.223877-0.5-0.5-0.5S9,7.723877,9,8v1c-1.1045532,0-2,0.8954468-2,2s0.8954468,2,2,2h1c0.5523071,0,1,0.4476929,1,1s-0.4476929,1-1,1H7.5C7.223877,15,7,15.223877,7,15.5S7.223877,16,7.5,16H9v1.0005493C9.0001831,17.2765503,9.223999,17.5001831,9.5,17.5h0.0006104C9.7765503,17.4998169,10.0001831,17.276001,10,17v-1c1.1045532,0,2-0.8954468,2-2s-0.8954468-2-2-2H9c-0.5523071,0-1-0.4476929-1-1S8.4476929,10,9,10z M21.5,12H17V2.5c0.000061-0.0875244-0.0228882-0.1735229-0.0665283-0.2493896c-0.1375732-0.2393188-0.4431152-0.3217773-0.6824951-0.1842041l-3.2460327,1.8603516L9.7481079,2.0654297c-0.1536865-0.0878906-0.3424072-0.0878906-0.4960938,0l-3.256897,1.8613281L2.7490234,2.0664062C2.6731567,2.0227661,2.5871582,1.9998779,2.4996338,1.9998779C2.2235718,2.000061,1.9998779,2.223938,2,2.5v17c0.0012817,1.380188,1.119812,2.4987183,2.5,2.5H19c1.6561279-0.0018311,2.9981689-1.3438721,3-3v-6.5006104C21.9998169,12.2234497,21.776001,11.9998169,21.5,12z M4.5,21c-0.828064-0.0009155-1.4990845-0.671936-1.5-1.5V3.3623047l2.7412109,1.5712891c0.1575928,0.0872192,0.348877,0.0875854,0.5068359,0.0009766L9.5,3.0761719l3.2519531,1.8583984c0.157959,0.0866089,0.3492432,0.0862427,0.5068359-0.0009766L16,3.3623047V19c0.0008545,0.7719116,0.3010864,1.4684448,0.7803345,2H4.5z M21,19c0,1.1045532-0.8954468,2-2,2s-2-0.8954468-2-2v-6h4V19z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('scripts')
@if (Session::has('message'))
<script>
    Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: '{{Session::get('message')}}',
    })
</script>
@endif

<script>
    let Loader = function(){
        let $yourUl = $("#global-loader2");
        $yourUl.css("display", $yourUl.css("display") === 'none' ? '' : 'none');
    }
    window.onload = function() {
        $.ajax({
            type: "POST",
            url: "{{ route('supplier.number') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: "{{ Auth::user()->id}}"},
            success: function(response) {
                let data = response.data;
                if(response.success == true)
                {
                    let = plantillaMtPagadas = ''
                    let = plantillaMtPorPagar = ''
                    let = plantillaMtPagadasConNovedad = ''
                    let = plantillaTotalFt = ''

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('total') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            SupplierNumber:data,
                            PaidStatus: ['Parcialmente pagado', 'Impagado', 'Pagadas'],
                            FlagStatus: 'false'
                        },

                        success: function(response) {
                            let datos = response.data;
                            if (response.success == true) {
                                console.log(datos);
                                let dollarUSLocale = Intl.NumberFormat('en-US');
                                let mtPagadas = dollarUSLocale.format(datos[2]['Pagadas']);
                                let mtPorPagar = dollarUSLocale.format(datos[1]['Impagado']);
                                let mtPagadasConNovedad = dollarUSLocale.format(datos[0]['Parcialmente pagado']);
                                let totalFt = datos[0]['Parcialmente pagado'] + datos[1]['count Impagado'] + datos[2]['count Pagadas'];

                                plantillaMtPagadas =
                                `
                                <h3 class="mb-2 fw-semibold">$${mtPagadas}</h3>
                                `
                                $('#mtPagadas').append(plantillaMtPagadas)

                                plantillaMtPorPagar =
                                `
                                <h3 class="mb-2 fw-semibold">$${mtPorPagar}</h3>
                                `
                                $('#mtPorPagar').append(plantillaMtPorPagar)

                                plantillaMtPagadasConNovedad =
                                `
                                <h3 class="mb-2 fw-semibold">$${mtPagadasConNovedad}</h3>
                                `
                                $('#mtPagadasConNovedad').append(plantillaMtPagadasConNovedad)

                                plantillaTotalFt =
                                `
                                <h3 class="mb-2 fw-semibold">$${totalFt}</h3>
                                `
                                $('#totalFt').append(plantillaTotalFt)
                                Loader();
                                // console.log(datos[2]['Paid']);
                            }
                        },
                        error: function(error){
                            console.error(error);
                        }
                    })
                }
            }
        })
    }
</script>

@endsection
