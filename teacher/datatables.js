$(document).ready(function () {
    $('#students').DataTable({
        columnDefs: [
        {
            targets: [3],
            orderData: [3,2,1],
        },
        {
            targets: [4],
            orderData: [4,2,1],
        },
        {
            targets: [5],
            orderData: [5,2,1],
        }
    ]}
    );
});