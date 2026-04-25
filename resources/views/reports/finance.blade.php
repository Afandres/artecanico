<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard Financiero
    </h2>
</x-slot>

<div class="container py-4">

<form method="GET" class="row g-2 mb-4">

    <div class="col-md-3">
        <input type="number" name="year" value="{{ $year }}" class="form-control">
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
    </div>

</form>

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card shadow border-0 rounded-4 p-4">
            <small>Ingresos</small>
            <h2 class="text-success fw-bold">
                $ {{ number_format($income,0,',','.') }}
            </h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0 rounded-4 p-4">
            <small>Gastos</small>
            <h2 class="text-danger fw-bold">
                $ {{ number_format($expenses,0,',','.') }}
            </h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0 rounded-4 p-4">
            <small>Ganancia Neta</small>
            <h2 class="text-primary fw-bold">
                $ {{ number_format($profit,0,',','.') }}
            </h2>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-md-5">
        <div class="card shadow border-0 rounded-4 p-4">
            <h5 class="mb-4">Distribución</h5>
            <div id="donutChart"></div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow border-0 rounded-4 p-4">
            <h5 class="mb-4">Ingresos vs Gastos por Mes</h5>
            <div id="barChart"></div>
        </div>
    </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
/* DONA */

var options = {
    chart:{
        type:'donut',
        height:350
    },

    series:[
        {{ $income }},
        {{ $expenses }},
        {{ $profit }}
    ],

    labels:[
        'Ingresos',
        'Gastos',
        'Ganancia'
    ],

    colors:[
        '#10b981',
        '#ef4444',
        '#3b82f6'
    ]
};

new ApexCharts(document.querySelector("#donutChart"), options).render();


/* BARRAS */

var options2 = {

    chart:{
        type:'bar',
        height:380,
        toolbar:{
            show:false
        }
    },

    series:[
        {
            name:'Ingresos',
            data:@json($monthlyIncome)
        },
        {
            name:'Gastos',
            data:@json($monthlyExpenses)
        }
    ],

    xaxis:{
        categories:[
            'Ene','Feb','Mar','Abr','May','Jun',
            'Jul','Ago','Sep','Oct','Nov','Dic'
        ]
    },

    colors:[
        '#10b981',
        '#ef4444'
    ],

    plotOptions:{
        bar:{
            borderRadius:6,
            columnWidth:'55%'
        }
    },

     dataLabels:{
        enabled:false
    },

    stroke:{
        show:true,
        width:2,
        colors:['transparent']
    },

    yaxis:{
        labels:{
            formatter:function(val){
                return '$ ' + new Intl.NumberFormat('es-CO').format(val);
            }
        }
    },

    tooltip:{
        y:{
            formatter:function(val){
                return '$ ' + new Intl.NumberFormat('es-CO').format(val);
            }
        }
    },
    legend:{
        position:'bottom'
    },

    grid:{
        borderColor:'#f1f1f1'
    }
};

new ApexCharts(document.querySelector("#barChart"), options2).render();
</script>

</x-app-layout>