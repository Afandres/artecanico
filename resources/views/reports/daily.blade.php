<x-app-layout>
    <h2 class="page-title font-semibold text-xl text-gray-800 leading-tight">Reporte diario</h2>

    <style>
        /* ============================================
           REPORTE DIARIO - MISMO ESTILO QUE LA APP
        ============================================ */
        
        /* Filtro */
        .report-filter-wrap {
            background: #fff;
            border-radius: 24px;
            border: 1.5px solid #fce7f0;
            padding: 18px 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 14px rgba(196, 79, 128, .07);
        }

        .report-filter-title {
            font-size: 13px;
            font-weight: 700;
            color: #5a2a3a;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 12px;
            font-family: 'Quicksand', sans-serif;
        }

        #report_date {
            max-width: 260px;
            border: 1.5px solid #fce7f0;
            border-radius: 12px;
            padding: 10px 14px;
            font-family: 'Quicksand', sans-serif;
            transition: all .2s;
        }

        #report_date:focus {
            border-color: #c44f80;
            outline: none;
            box-shadow: 0 0 0 2px rgba(196, 79, 128, .2);
        }

        /* Card principal */
        .card {
            border-radius: 24px !important;
            border: 1.5px solid #fce7f0 !important;
            overflow: hidden;
        }

        .card-body {
            padding: 20px;
        }

        /* Total del día */
        .text-muted {
            font-size: 11.5px;
            font-weight: 700;
            color: #b08090 !important;
            text-transform: uppercase;
            letter-spacing: .4px;
            font-family: 'Quicksand', sans-serif;
        }

        .text-success {
            font-family: 'Fredoka One', cursive !important;
            font-size: 26px !important;
            color: #10b981 !important;
        }

        /* Tarjetas de métodos de pago */
        .payment-mini-card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-radius: 16px;
            padding: 16px 12px;
            height: 100%;
            color: #fff;
            transition: all .2s;
        }

        .payment-mini-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .payment-mini-card .icon {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .payment-logo {
            width: 32px;
            height: 32px;
            object-fit: contain;
            background: #fff;
            padding: 5px;
            border-radius: 50%;
            margin-bottom: 8px;
        }

        .payment-mini-card small {
            display: block;
            color: rgba(255, 255, 255, .9);
            margin-bottom: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .payment-mini-card h6 {
            margin: 0;
            color: #fff;
            font-weight: 700;
            font-size: 18px;
        }

        /* Colores métodos de pago */
        .bg-efectivo { background: linear-gradient(135deg, #16a34a, #15803d); }
        .bg-nequi { background: linear-gradient(135deg, #7c3aed, #6d28d9); }
        .bg-daviplata { background: linear-gradient(135deg, #dc2626, #b91c1c); }
        .bg-tarjeta { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
        .bg-default { background: linear-gradient(135deg, #6b7280, #4b5563); }

        /* DataTable */
        .dataTables_wrapper {
            font-family: 'Quicksand', sans-serif;
        }
        
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 1.5px solid #fce7f0;
            border-radius: 12px;
            padding: 6px 12px;
            font-family: 'Quicksand', sans-serif;
        }
        
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #c44f80;
            outline: none;
            box-shadow: 0 0 0 2px rgba(196, 79, 128, .2);
        }
        
        table.dataTable {
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        
        table.dataTable thead th {
            background: linear-gradient(135deg, #fff8fb, #fff);
            border-bottom: 2px solid #fce7f0 !important;
            font-family: 'Quicksand', cursive;
            font-size: 14px;
            color: #3d1a28;
            padding: 15px 12px;
        }
        
        table.dataTable tbody td {
            background: #fff;
            border: 1.5px solid #fce7f0;
            border-top: none;
            padding: 12px;
            vertical-align: middle;
        }
        
        table.dataTable tbody tr:first-child td {
            border-top: 1.5px solid #fce7f0;
        }
        
        table.dataTable tbody tr:hover td {
            background: #fff5f9;
        }
        
        /* Paginación */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 10px !important;
            margin: 0 3px;
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;
            padding: 6px 12px !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #f48fba, #c44f80) !important;
            border: none !important;
            color: white !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(135deg, #fce7f0, #f48fba) !important;
            border: none !important;
            color: #3d1a28 !important;
        }

        @media(max-width:768px) {
            #report_date {
                max-width: 100%;
                width: 100%;
            }
        }
    </style>

    <div class="container py-4">

        {{-- FILTRO --}}
        <div class="report-filter-wrap">
            <div class="report-filter-title">Filtrar reporte por fecha</div>
            <input type="date" id="report_date" class="form-control" value="{{ $date }}"
                max="{{ date('Y-m-d') }}">
        </div>

        {{-- CARD --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <div class="row align-items-center g-4 mb-4">

                    {{-- TOTAL --}}
                    <div class="col-md-3">
                        <h6 class="text-muted mb-1">Total del día</h6>
                        <h2 class="text-success fw-bold mb-0" id="daily_total">
                            $ {{ number_format($total, 0, ',', '.') }}
                        </h2>
                    </div>

                    {{-- TARJETAS --}}
                    <div class="col-md-9">
                        <div class="row g-3" id="payment_cards"></div>
                    </div>

                </div>

                <table id="reports" class="display nowrap w-100">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Mascota</th>
                            <th>Cliente</th>
                            <th>Método de pago</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</td>
                                <td>{{ $appointment->pet_id ? $appointment->pet->name : $appointment->pet_name_temp }}
                                </td>
                                <td>{{ $appointment->pet_id ? $appointment->pet->client->name : $appointment->owner_name_temp }}
                                </td>
                                <td>{{ $appointment->payment_method_label }}</td>
                                <td>$ {{ number_format($appointment->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</x-app-layout>

<script>
    $(document).ready(function() {

        const table = $('#reports').DataTable();

        $('#report_date').on('change', function() {

            let date = $(this).val();

            $.ajax({
                url: "{{ route('report.daily.ajax') }}",
                type: "GET",
                data: {
                    date: date
                },

                success: function(response) {
                    let cards = '';

                    for (let method in response.payments) {

                        let amount = new Intl.NumberFormat('es-CO')
                            .format(response.payments[method]);

                        let label = method.replaceAll('_', ' ');

                        let bgClass = 'bg-default';
                        let icon = '<i class="fa-solid fa-coins"></i>';

                        if (method === 'Efectivo') {
                            bgClass = 'bg-efectivo';
                            icon = '<i class="fa-solid fa-money-bill-wave"></i>';
                        } else if (method === 'Nequi' || method === 'Llave_nequi') {
                            bgClass = 'bg-nequi';
                            icon =
                                `<img src="/images/payments/nequi.png" class="payment-logo">`;
                        } else if (method === 'Daviplata' || method === 'Llave_daviplata') {
                            bgClass = 'bg-daviplata';
                            icon =
                                `<img src="/images/payments/daviplata.png" class="payment-logo">`;
                        } else if (method === 'Tarjeta') {
                            bgClass = 'bg-tarjeta';
                            icon = '<i class="fa-regular fa-credit-card"></i>';
                        }

                        cards += `
                        <div class="col-md-3 col-6">
                            <div class="payment-mini-card ${bgClass}">
                                <span class="icon">${icon}</span>
                                <small>${label}</small>
                                <h6>$ ${amount}</h6>
                            </div>
                        </div>
                    `;
                    }

                    $('#payment_cards').html(cards);

                    // TOTAL
                    $('#daily_total').text('$ ' + response.total);

                    // LIMPIAR TABLA
                    table.clear();

                    // SI HAY DATOS
                    if (response.appointments.length > 0) {

                        response.appointments.forEach(item => {

                            let pet = item.pet_id ?
                                item.pet.name :
                                item.pet_name_temp;

                            let client = item.pet_id ?
                                item.pet.client.name :
                                item.owner_name_temp;

                            let payment_method = item.payment_method_label;

                            let price = new Intl.NumberFormat('es-CO')
                                .format(item.price);

                            let hour = new Date(item.appointment_date)
                                .toLocaleTimeString('es-CO', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                            table.row.add([
                                hour,
                                pet,
                                client,
                                payment_method,
                                '$ ' + price
                            ]);

                        });
                    }

                    // REDIBUJAR
                    table.draw();

                }
            });

        });

    });
</script>