// Table setup
// ------------------------------

$.extend( $.fn.dataTable.defaults, {
    language: {
        search: '<span>Поиск:</span> _INPUT_',
        lengthMenu: '<span>Показать:</span> _MENU_',
        paginate: { 'first': 'Первая', 'last': 'Последняя', 'next': '&rarr;', 'previous': '&larr;' }
    },
});

$('document').ready(function () {

    $.ajax({
        utype: "POST",
        url: '/admin/ajax-datatables/sellers-statistics',
        success: function(data) {
            console.log(data);
            prepareDataForTable(data);
            $('.sellers-list-datatable').dataTable({
                data: data,
                columns: [
                    { title: "id" },
                    { title: "Логин" },
                    { title: "Количество сделок" }
                ]
            });
        },
    }).fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });

});

function prepareDataForTable (data) {
    data.forEach(function (item, i, data) {
        item[1] = "<a href='/admin/statistics/seller/" + item[0] + "' >" + item[1] + "</a>";
        if (item[2] != 0) {
            item[2] = "<a href='/admin/statistics/orders-of-seller/" + item[0] + "'>" + item[2] + "</a>";
        }
    });
}
