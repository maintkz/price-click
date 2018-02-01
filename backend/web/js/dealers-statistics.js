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
        url: '/admin/ajax-datatables/dealers-statistics',
        success: function(data) {
            prepareDataForTable(data);
            $('.dealers-list-datatable').dataTable({
                data: data,
                columns: [
                    { title: "id" },
                    { title: "Логин" },
                    { title: "Количество магазинов" }
                ]
            });
        },
    }).fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });

});

function prepareDataForTable (data) {
    data.forEach(function (item, i, data) {
        item[1] = "<a href='/admin/statistics/dealer/" + item[0] + "' >" + item[1] + "</a>";
    });
}
