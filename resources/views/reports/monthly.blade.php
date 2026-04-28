<x-app-layout>
    <h2 class="page-title font-semibold text-xl text-gray-800 leading-tight">Ingresos y gastos en el mes</h2>

    <style>
        .payment-mini-card {
            border-radius: 18px;
            padding: 18px;
            color: #fff;
            height: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(0, 0, 0, .12);
            transition: .25s ease;
        }

        .payment-mini-card:hover,
        .payment-method-mini-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, .16);
        }

        .payment-mini-card small,
        .payment-method-mini-card small {
            display: block;
            font-size: 13px;
            opacity: .92;
            margin-bottom: 8px;
            letter-spacing: .3px;
        }

        .payment-mini-card h5 {
            margin: 0;
            font-weight: 700;
            font-size: 28px;
        }

        .payment-method-mini-card h5 {
            margin: 0;
            font-weight: 700;
            font-size: 28px;
            color: white
        }

        .payment-mini-card i {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 22px;
            opacity: .15;
        }

        .payment-method-mini-card i {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 22px;
        }

        .payment-method-mini-card {
            border-radius: 18px;
            padding: 18px;
            color: #fff;
            height: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(0, 0, 0, .10);
        }

        .payment-logo {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 34px;
            height: 34px;
            object-fit: contain;
            background: #fff;
            padding: 5px;
            border-radius: 50%;
            box-shadow: 0 6px 14px rgba(0, 0, 0, .14);
        }

        .card-income {
            background: #ffffff;
            color: #111827;
            border: 1px solid #e5e7eb;
        }

        .card-expense {
            background: #ffffff;
            color: #111827;
            border: 1px solid #e5e7eb;
        }

        .card-profit {
            background: #ffffff;
            color: #111827;
            border: 1px solid #e5e7eb;
        }

        .card-income i {
            color: #059669;
            opacity: .12;
        }

        .card-expense i {
            color: #dc2626;
            opacity: .12;
        }

        .card-profit i {
            color: #2563eb;
            opacity: .12;
        }

        .card-income h5 {
            color: #059669;
        }

        .card-expense h5 {
            color: #dc2626;
        }

        .card-profit h5 {
            color: #2563eb;
        }

        .card-income small,
        .card-expense small,
        .card-profit small {
            color: #6b7280;
        }

        .bg-efectivo {
            background: #16a34a;
        }

        .bg-nequi {
            background: #7c3aed;
        }

        .bg-daviplata {
            background: #dc2626;
        }

        .bg-tarjeta {
            background: #2563eb;
        }

        .bg-default {
            background: #6b7280;
        }
    </style>

    <div class="container py-4">

        <form method="GET" class="row g-2 mb-4">

            @php
                \Carbon\Carbon::setLocale('es');
            @endphp

            <div class="col-md-3">
                <select name="month" class="form-control">
                    @for ($i = 1; $i <= 12; $i++)
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
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="payment-mini-card card-income">
                    <i class="fa-solid fa-sack-dollar"></i>
                    <small>Ingresos del mes</small>
                    <h5>$ {{ number_format($total, 0, ',', '.') }}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="payment-mini-card card-expense">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                    <small>Gastos del mes</small>
                    <h5>$ {{ number_format($totalExpenses, 0, ',', '.') }}</h5>
                </div>
            </div>

            <div class="col-md-4">
                <div class="payment-mini-card card-profit">
                    <i class="fa-solid fa-chart-line"></i>
                    <small>Utilidad</small>
                    <h5>$ {{ number_format($profit, 0, ',', '.') }}</h5>
                </div>
            </div>

        </div>

        <div class="row g-3 mb-4">

            @foreach ($payments as $method => $amount)
                @php
                    $class = 'bg-secondary';
                    $icon = '<i class="fa-solid fa-money-bill"></i>';

                    if ($method == 'Efectivo') {
                        $class = 'bg-efectivo';
                        $icon = '<i class="fa-brands fa-cash-app"></i>';
                    } elseif ($method == 'Nequi' || $method == 'Llave_nequi') {
                        $class = 'bg-nequi';
                        $icon = '<img src="/images/payments/nequi.png" class="payment-logo">';
                    } elseif ($method == 'Daviplata' || $method == 'Llave_daviplata') {
                        $class = 'bg-daviplata';
                        $icon = '<img src="/images/payments/daviplata.png" class="payment-logo">';
                    } elseif ($method == 'Tarjeta') {
                        $class = 'bg-tarjeta';
                        $icon = '<i class="fa-solid fa-credit-card"></i>';
                    }
                @endphp

                <div class="col-md-3 col-6">
                    <div class="payment-method-mini-card {{ $class }}">
                        {!! $icon !!}
                        <small>{{ str_replace('_', ' ', $method) }}</small>
                        <h5>$ {{ number_format($amount, 0, ',', '.') }}</h5>
                    </div>
                </div>
            @endforeach

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

            series: [{
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
                    @for ($i = 1; $i <= $daysInMonth; $i++)
                        "{{ $i }}",
                    @endfor
                ]
            },

            colors: ['#059669', '#ef4444'],

            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '50%'
                }
            },

            dataLabels: {
                enabled: false
            },

            stroke: {
                show: true,
                width: 1
            },

            yaxis: {
                labels: {
                    formatter: function(val) {
                        return '$ ' + new Intl.NumberFormat('es-CO').format(val);
                    }
                }
            },

            tooltip: {
                y: {
                    formatter: function(val) {
                        return '$ ' + new Intl.NumberFormat('es-CO').format(val);
                    }
                }
            },

            legend: {
                position: 'top'
            }
        };

        new ApexCharts(document.querySelector("#monthlyChart"), options).render();
    </script>

</x-app-layout>
