<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Reporte diario
    </h2>
</x-slot>

<style>
.report-filter-wrap{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:12px;
    box-shadow:0 .125rem .25rem rgba(0,0,0,.075);
    padding:18px 20px;
    margin-bottom:18px;
}

.report-filter-title{
    font-size:15px;
    font-weight:600;
    color:#374151;
    margin-bottom:10px;
}

#report_date{
    max-width:260px;
    border:1px solid #d1d5db;
    border-radius:10px;
    padding:10px 14px;
}

.payment-mini-card{
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    border-radius:14px;
    padding:14px;
    height:100%;
    color:#fff;
}

.payment-mini-card:hover{
    transform:translateY(-2px);
}

.payment-logo{
    width:32px;
    height:32px;
    object-fit:contain;
    background:#fff;
    padding:5px;
    border-radius:50%;
}

.payment-mini-card small{
    display:block;
    color:rgba(255,255,255,.9);
    margin-bottom:4px;
}

.payment-mini-card h6{
    margin:0;
    color:#fff;
    font-weight:700;
}

/* Colores */
.bg-efectivo{
    background:#16a34a;
}

.bg-nequi{
    background:#7c3aed;
}

.bg-daviplata{
    background:#dc2626;
}

.bg-tarjeta{
    background:#2563eb;
}

.bg-default{
    background:#6b7280;
}

@media(max-width:768px){
    #report_date{
        max-width:100%;
        width:100%;
    }
}
</style>

<div class="container py-4">

    {{-- FILTRO --}}
    <div class="report-filter-wrap">
        <div class="report-filter-title">Filtrar reporte por fecha</div>

        <input
            type="date"
            id="report_date"
            class="form-control"
            value="{{ $date }}"
            max="{{ date('Y-m-d') }}"
        >
    </div>

    {{-- CARD --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

           <div class="row align-items-center g-4 mb-4">

            {{-- TOTAL --}}
            <div class="col-md-3">
                <h6 class="text-muted mb-1">Total del día</h6>

                <h2 class="text-success fw-bold mb-0" id="daily_total">
                    $ {{ number_format($total,0,',','.') }}
                </h2>
            </div>

            {{-- TARJETAS --}}
            <div class="col-md-9">
                <div class="row g-3" id="payment_cards"></div>
            </div>

        </div>


            <table id="reports" class="table table-striped align-middle w-100">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Mascota</th>
                        <th>Cliente</th>
                        <th>Metodo de pago</th>
                        <th>Valor</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</td>
                            <td>{{ $appointment->pet_id ? $appointment->pet->name : $appointment->pet_name_temp }}</td>
                            <td>{{ $appointment->pet_id ? $appointment->pet->client->name : $appointment->owner_name_temp }}</td>
                            <td>{{ $appointment->payment_method_label  }}</td>
                            <td>$ {{ number_format($appointment->price,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

</x-app-layout>

<script>
$(document).ready(function(){

    const table = $('#reports').DataTable();

    $('#report_date').on('change', function(){

        let date = $(this).val();

        $.ajax({
            url: "{{ route('report.daily.ajax') }}",
            type: "GET",
            data: { date: date },

            success: function(response){
                let cards = '';

                for (let method in response.payments) {

                    let amount = new Intl.NumberFormat('es-CO')
                        .format(response.payments[method]);

                    let label = method.replaceAll('_',' ');

                    let bgClass = 'bg-default';
                    let icon = '<i class="fa-brands fa-cash-app"></i>';

                    if(method === 'Efectivo'){
                        bgClass = 'bg-efectivo';
                        icon = '<i class="fa-brands fa-cash-app"></i>';
                    }
                    else if(method === 'Nequi' || method === 'Llave_nequi'){
                        bgClass = 'bg-nequi';
                        icon = `<img src="/images/payments/nequi.png" class="payment-logo">`;
                    }
                    else if(method === 'Daviplata' || method === 'Llave_daviplata'){
                        bgClass = 'bg-daviplata';
                        icon = `<img src="/images/payments/daviplata.png" class="payment-logo">`;
                    }
                    else if(method === 'Tarjeta'){
                        bgClass = 'bg-tarjeta';
                        icon = '<i class="fa-solid fa-credit-card"></i>';
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
                if(response.appointments.length > 0){

                    response.appointments.forEach(item => {

                        let pet = item.pet_id
                            ? item.pet.name
                            : item.pet_name_temp;

                        let client = item.pet_id
                            ? item.pet.client.name
                            : item.owner_name_temp;
                        
                        let payment_method = item.payment_method_label;

                        let price = new Intl.NumberFormat('es-CO')
                            .format(item.price);

                        let hour = new Date(item.appointment_date)
                            .toLocaleTimeString('es-CO',{
                                hour:'2-digit',
                                minute:'2-digit'
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