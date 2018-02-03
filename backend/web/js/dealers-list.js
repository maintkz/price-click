// Table setup
// ------------------------------

$.extend( $.fn.dataTable.defaults, {
    columnDefs: [{
        orderable: false,
        width: '100px',
        targets: [ 5 ]
    }],
    language: {
        search: '<span>Поиск:</span> _INPUT_',
        lengthMenu: '<span>Показать:</span> _MENU_',
        paginate: { 'first': 'Первая', 'last': 'Последняя', 'next': '&rarr;', 'previous': '&larr;' }
    },
});

$('document').ready(function () {

    $.ajax({
        utype: "POST",
        url: '/admin/ajax-datatables/dealers-list',
        success: function(data) {
            prepareDataForTable(data, 4);
            $('.dealers-list-datatable').dataTable({
                data: data,
                columns: [
                    { title: "id" },
                    { title: "Логин" },
                    { title: "email" },
                    { title: "Телефон" },
                    { title: "Статус" },
                    { title: "Действие" }
                ]
            });
        },
    }).fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });

});

function prepareDataForTable (data, status) {
    data.forEach(function (item, i, data) {
        if (item[status] == 1) {
            item[status] = "<span class='label label-success'>Активный</span>";
        } else if (item[status] == 0) {
            item[status] = "<span class='label label-default'>Неактивный</span>";
        }
        item.push("<a href='/admin/administrator/view-dealer/" + item[0] + "' class='view-dealer-button' data-dealer-id='" + item[0] + "'><i class='icon-eye'></i></a><a href='/admin/administrator/edit-dealer/" + item[0] + "' class='edit-dealer-button'><i class='icon-pencil4'></i></a><a href='#' class='delete-dealer-button' data-dealer-id='" + item[0] + "'><i class='icon-cross2'></i></a>");
    });
}
