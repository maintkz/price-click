// Setting datatable defaults
$.extend( $.fn.dataTable.defaults, {
    "language": {
        "url": "/admin/js/ru-datatable.json"
    },
});

var csrf = $('[name="_csrf-backend"]').val();

$.ajax({
    utype: "POST",
    url: '/admin/ajax/get-products-list',
    success: function(data) {
        console.log(data);
        prepareDataForTable(data, 5);
        $('.products-list-datatable').dataTable({
            data: data,
            columns: [
                { title: "ID" },
                { title: "Подкатегория" },
                { title: "Наименование" },
                { title: "Цена" },
                { title: "Количество" },
                { title: "Статус" },
                { title: "Действие" }
            ]
        });
    },
}).fail(function (xhr, textStatus, errorThrown) {
    console.log(xhr.responseText);
});

/* ---------------------------------------------------*/
/* ------------------- Functions --------------------*/
/* ---------------------------------------------------*/
function prepareDataForTable (data, status) {
    data.forEach(function (item, i, data) {
        if (item[status] == 1) {
            item[status] = "<span class='label label-success'>Активный</span>";
        } else if (item[status] == 0) {
            item[status] = "<span class='label label-default'>Неактивный</span>";
        }

        item[2] = "<a href='/admin/seller/view-product/" + item[0] + "'>" + item[2] + "</a>";

        item.push("<a href='/admin/administrator/view-dealer/" + item[0] + "' class='view-dealer-button' data-dealer-id='" + item[0] + "'><i class='icon-eye'></i></a>");
    });
}


function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}