// Table setup
// ------------------------------

$.extend( $.fn.dataTable.defaults, {
    "language": {
        "url": "/admin/js/ru-datatable.json"
    },
});
$('document').ready(function () {
    $.ajax({
        utype: "POST",
        url: '/admin/ajax-datatables/customers-statistics',
        success: function(data) {
            console.log(data);
            prepareDataForTable(data);
            $('.customers-list-datatable').dataTable({
                data: data,
                columns: [
                    { title: "id" },
                    { title: "Логин" },
                    { title: "email" },
                    { title: "Телефон" },
                    { title: "Адрес" },
                    { title: "Город" }
                ]
            });
        },
    }).fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });
});

function prepareDataForTable (data) {
    data.forEach(function (item, i, data) {
        item[1] = "<a href='/admin/statistics/customer/" + item[0] + "' >" + item[1] + "</a>";
    });
}
