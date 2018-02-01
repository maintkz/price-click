$('document').ready(function () {

    var uri = window.location.href;
    var index = uri.lastIndexOf('/');
    var order_group_id = uri.substring(index  + 1);

    $.ajax({
        type: 'POST',
        url: '/admin/ajax-datatables/order-group-statistics',
        data: {
            "order_group_id": order_group_id
        },
        success: function (data) {
            console.log(data);
            prepareDataForTable(data);
            $('.orders-list-datatable').dataTable({
                data: data,
                columns: [
                    { title: "id" },
                    { title: "Наименование продукта" },
                    { title: "Цена" },
                    { title: "Количество товара" },
                    { title: "Сумма" },
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
        item[1] = "<a href='/admin/seller/view-product/" + item[7] + "'>" + item[1] + "</a>";
        item.pop();
    });
}
