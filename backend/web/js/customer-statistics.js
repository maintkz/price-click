$('document').ready(function () {

    var uri = window.location.href;
    var index = uri.lastIndexOf('/');
    var mobile_user_id = uri.substring(index  + 1);

    $.ajax({
        type: 'POST',
        url: '/admin/ajax-datatables/customer-statistics',
        data: {
            "mobile_user_id": mobile_user_id
        },
        success: function (data) {
            console.log(data);
            prepareDataForTable(data);
            $('.dealers-list-datatable').dataTable({
                data: data,
                columns: [
                    { title: "id" },
                    { title: "Количество купленных товаров" },
                    { title: "Общая сумма" },
                    { title: "Телефон покупателя" },
                    { title: "Статус" },
                    { title: "Дата" }
                ]
            });
        }
    }).fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });

});

function prepareDataForTable (data) {
    data.forEach(function (item, i, data) {
        item[1] = "<a href='/admin/statistics/order/" + item[0] + "'>" + item[1] + "</a>";
        item[0] = "<a href='/admin/statistics/order/" + item[0] + "'>" + item[0] + "</a>";
        // item[3] = "<a href='/admin/statistics/customer/" + item[0] + "'>" + item[3] + "</a>";
    });
}