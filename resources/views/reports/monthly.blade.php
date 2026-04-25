<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Ingresos y gastos en el mes
    </h2>
</x-slot>

<div class="container py-4">

    <form method="GET" class="row g-2 mb-4">

        @php
            \Carbon\Carbon::setLocale('es');
        @endphp

        <div class="col-md-3">
            <select name="month" class="form-control">
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-3">
            <input type="number" name="year" value="{{ $year }}" class="form-control">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="fa-solid fa-magnifying-glass"></i> Buscar
            </button>
        </div>

    </form>

    <!-- TARJETAS -->
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 p-4">
                <small>Total vendido</small>
                <h2 class="text-success fw-bold">
                    $ {{ number_format($total,0,',','.') }}
                </h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 p-4">
                <small>Total gastos</small>
                <h2 class="text-danger fw-bold">
                    $ {{ number_format($totalExpenses,0,',','.') }}
                </h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow border-0 rounded-4 p-4">
                <small>Ganancia neta</small>
                <h2 class="text-primary fw-bold">
                    $ {{ number_format($profit,0,',','.') }}
                </h2>
            </div>
        </div>

    </div>

    <!-- GRAFICA -->
    <div class="card shadow border-0 rounded-4 p-4">
        <h5 class="mb-4">Ingresos vs Gastos por Día</h5>
        <div id="monthlyChart"></div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
var options = {

    chart: {
        type: 'bar',
        height: 430,
        toolbar: {
            show: true
        }
    },

    series: [
        {
            name: 'Ingresos',
            data: @json($dailyTotals)
        },
        {
            name: 'Gastos',
            data: @json($dailyExpenses)
        }
    ],

    xaxis: {
        categories: [
            @for($i=1;$i<=$daysInMonth;$i++)
                "{{ $i }}",
            @endfor
        ]
    },

    colors: ['#059669', '#ef4444'],

    plotOptions:{
        bar:{
            borderRadius:6,
            columnWidth:'50%'
        }
    },

    dataLabels:{
        enabled:false
    },

    stroke:{
        show:true,
        width:1
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
        position:'top'
    }
};

new ApexCharts(document.querySelector("#monthlyChart"), options).render();
</script>

</x-app-layout>