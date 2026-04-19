import './bootstrap';
	
new DataTable('#breeds', {
    responsive: true,
    scrollX: true,
});

new DataTable('#treatments', {
    responsive: true,
    scrollX: true,
});

new DataTable('#pets', {
    responsive: true,
    scrollX: true,

    order: [[0, 'asc']], // ordenar por dueño

    columnDefs: [
        { targets: 0, visible: false } // ocultar columna dueño repetida
    ],

    rowGroup: {
        dataSrc: 0
    }
});