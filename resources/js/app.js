import './bootstrap';
	
new DataTable('#breeds', {
    responsive: true,
    scrollX: true,
});

new DataTable('#treatments', {
    responsive: true,
    scrollX: true,
});

const petsTable = document.getElementById('pets');

if (petsTable) {

    let isAuth = petsTable.dataset.auth;

    if (isAuth == 1) {

        new DataTable('#pets', {
            responsive: true,
            scrollX: true,

            order: [[0, 'asc']],

            columnDefs: [

                // Dueño oculto pero sí searchable
                {
                    targets: 0,
                    visible: false,
                    searchable: true
                },

                // Foto no buscar
                {
                    targets: 1,
                    searchable: false,
                    orderable: false
                },

                // Acciones no buscar ni ordenar
                {
                    targets: 8,
                    searchable: false,
                    orderable: false
                }

            ],

            rowGroup: {
                dataSrc: 0
            },

            language: {
                search: "Buscar:",
                zeroRecords: "No se encontraron resultados",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ mascotas",
                infoEmpty: "Sin registros",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }

        });

    } else {

        new DataTable('#pets', {
            responsive: true,
            scrollX: true,

            columnDefs: [

                // Foto
                {
                    targets: 0,
                    searchable: false,
                    orderable: false
                },

                // Acciones
                {
                    targets: 7,
                    searchable: false,
                    orderable: false
                }

            ],

            language: {
                search: "Buscar:",
                zeroRecords: "No se encontraron resultados",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_ mascotas",
                infoEmpty: "Sin registros",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }

        });

    }
}
const reportsTable = document.getElementById('reports');

if (reportsTable) {

    new DataTable('#reports', {
        responsive:true,
        scrollX:true,
        language:{
            emptyTable:"No hay registros",
            zeroRecords:"No se encontraron resultados",
            search:"Buscar:",
            lengthMenu:"Mostrar _MENU_ registros",
            info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
            paginate:{
                first:"Primero",
                last:"Último",
                next:"Siguiente",
                previous:"Anterior"
            }
        }
    });

}
new DataTable('#expenses', {
    responsive: true,
    scrollX: true,
});