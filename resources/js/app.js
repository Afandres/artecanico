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
                { targets: 0, visible: false }
            ],
            rowGroup: {
                dataSrc: 0
            }
        });
    } else {
        new DataTable('#pets', {
            responsive: true,
            scrollX: true
        });
    }
}

new DataTable('#reports', {
    responsive: true,
    scrollX: true,
});

new DataTable('#expenses', {
    responsive: true,
    scrollX: true,
});