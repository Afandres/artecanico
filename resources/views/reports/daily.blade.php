<style>
    /* mismo estilo visual de la card de la tabla */
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
        font-size:15px;
        background:#fff;
        transition:.2s ease;
    }

    #report_date:focus{
        border-color:#198754;
        box-shadow:0 0 0 .2rem rgba(25,135,84,.15);
        outline:none;
    }

    @media(max-width:768px){
        #report_date{
            max-width:100%;
            width:100%;
        }
    }
</style>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reporte diario
        </h2>
    </x-slot>
        
    <div class="container py-4">
        <div class="report-filter-wrap">
            <div class="report-filter-title">Filtrar reporte por fecha</div>
            <input type="date" id="report_date" value="{{ $date }}" max="{{ date('Y-m-d') }}" class="form-control">
        </div>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4>Total del día:</h4>
                <h2 class="text-success" id="daily_total">$ {{ number_format($total,0,',','.') }}</h2>

                <table id="reports" class="display nowrap">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Mascota</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody id="report_body">
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</td>
                                <td>{{ $appointment->pet_id ? $appointment->pet->name : $appointment->pet_name_temp }}</td>
                                <td>{{ $appointment->pet->client->name ? $appointment->pet->client->name : $appointment->owner_name_temp }}</td>
                                <td>$ {{ number_format($appointment->price,0,',','.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No hay registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
$(document).ready(function(){

    $('#report_date').on('change', function(){

        let date = $(this).val();

        $.ajax({
            url: "{{ route('report.daily.ajax') }}",
            type: "GET",
            data: { date: date },

            success: function(response){

                $('#daily_total').text('$ ' + response.total);

                let html = '';

                if(response.appointments.length > 0){

                    response.appointments.forEach(item => {

                        let pet = item.pet_id
                            ? item.pet.name
                            : item.pet_name_temp;

                        let client = item.pet_id
                            ? item.pet.client.name
                            : item.owner_name_temp;

                        let price = new Intl.NumberFormat('es-CO')
                            .format(item.price);

                        let hour = new Date(item.appointment_date)
                            .toLocaleTimeString('es-CO',{
                                hour:'2-digit',
                                minute:'2-digit'
                            });

                        html += `
                            <tr>
                                <td>${hour}</td>
                                <td>${pet}</td>
                                <td>${client}</td>
                                <td>$ ${price}</td>
                            </tr>
                        `;
                    });

                }else{

                    html = `
                        <tr>
                            <td colspan="4">No hay registros</td>
                        </tr>
                    `;
                }

                $('#report_body').html(html);
            }
        });

    });

});
</script>