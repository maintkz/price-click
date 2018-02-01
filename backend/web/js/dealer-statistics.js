$('document').ready(function () {

    var uri = window.location.href;
    var index = uri.lastIndexOf('/');
    var dealer_id = uri.substring(index  + 1);

    $.ajax({
        type: 'POST',
        url: '/admin/ajax-datatables/sellers-of-dealer-statistics',
        data: {
            "dealer_id": dealer_id
        },
        success: function (data) {
            console.log(data);
            prepareDataForTable(data);
            $('.dealers-list-datatable').dataTable({
                "language": {
                    "url": "/admin/js/ru-datatable.json"
                },
                data: data,
                columns: [
                    { title: "id" },
                    { title: "Логин магазина" },
                    { title: "Процент монетизации" },
                    { title: "Ответственный" },
                    { title: "Доход" },
                    { title: "Прибыль" }
                ]
            });
        }
    }).fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });

});

function prepareDataForTable (data) {
    data.forEach(function (item, i, data) {
        item[1] = "<a href='/admin/statistics/seller/" + item[0] + "'>" + item[1] + "</a>";
        item[2] = item[2] + ' %';
    });
}