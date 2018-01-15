// Table setup
// ------------------------------

// Setting datatable defaults
$.extend( $.fn.dataTable.defaults, {
    autoWidth: false,
    columnDefs: [{
        orderable: false,
        width: '100px',
        targets: [ 5 ]
    }],
    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    language: {
        search: '<span>Filter:</span> _INPUT_',
        lengthMenu: '<span>Show:</span> _MENU_',
        paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
    },
    drawCallback: function () {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
    },
    preDrawCallback: function() {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
    }
});

var csrf = $('[name="_csrf-backend"]').val();

// AJAX sourced data
$('.products-list-datatable').dataTable({
    ajax: "/admin/ajax/get-products-list"
});

$.ajax({
    url: '/admin/ajax/get-products-list',
    method: 'POST',
    data: {
        '_csrf-backend': csrf
    },
    success: function(response) {
        console.log(response);
    }
});

//
// Form initialisation
//
$('.select').select2();


//
// Select with icons
//

// Format icon
function iconFormat(icon) {
    var originalOption = icon.element;
    if (!icon.id) { return icon.text; }
    var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;

    return $icon;
}

/* ---------------------------------------------------*/
/* ----------------- Html sections -------------------*/
/* ---------------------------------------------------*/
function renderModalBodyProduct(data) {
    return modalBodyHtml = "<div class=\"col-md-12\">" +
        "                        <div class=\"col-md-6\">" +
        "                            <p><i>Раздел</i></p>" +
        "                            <h6 class=\"text-semibold\">" + data.section_name + "</h6>" +
        "                        </div>" +
        "                        <div class=\"col-md-6\">" +
        "                            <p><i>Категория</i></p>" +
        "                            <h6 class=\"text-semibold\">" + data.category_name + "</h6>" +
        "                        </div>" +
        "                        <div class=\"col-md-6\">" +
        "                            <p><i>Подкатегория</i></p>" +
        "                            <h6 class=\"text-semibold\">" + data.subcategory_name + "</h6>" +
        "                        </div>" +
        "                    </div>" +
        "                    <div class=\"col-md-12\">" +
        "                        <hr />" +
        "                    </div>" +
        "                    <div class=\"col-md-12\">" +
        "                        <div class=\"col-md-6\">" +
        "                            <p><i>Наименование</i></p>" +
        "                            <h6 class=\"text-semibold\">" + data.product_name + "</h6>" +
        "                        </div>" +
        "                        <div class=\"col-md-6\">" +
        "                            <p><i>Параметры</i></p>" +
        "                            <h6 class=\"text-semibold\">" + data.product_parameters + "</h6>" +
        "                        </div>" +
        "                        <div class=\"col-md-6\">" +
        "                            <p><i>Цена</i></p>" +
        "                            <h6 class=\"text-semibold\">" + data.product_price + "</h6>" +
        "                        </div>" +
        "                        <div class=\"col-md-6\">" +
        "                            <p><i>Количество</i></p>" +
        "                            <h6 class=\"text-semibold\">" + data.product_list_count + "</h6>" +
        "                        </div>" +
        "                        <div class=\"col-md-6\">" +
        "                            <p><i>Статус</i></p>" +
        "                            <h6 class=\"text-semibold\">" + data.product_list_status + "</h6>" +
        "                        </div>" +
        "                        <div class=\"col-md-12\">" +
        "                            <p><i>Описание</i></p>" +
        "                            <h6 class=\"text-semibold\">" + nl2br(data.product_description) + "</h6>" +
        "                        </div>" +
        "                    </div>";
}

/* ---------------------------------------------------*/
/* ---------------- View product modal ---------------*/
/* ---------------------------------------------------*/
var modal = $('#modal');
$('body').on('click', '.show-product-button', function(e) {
    e.preventDefault();

    var listId = $(this).data('list-id');
    var productId = $(this).data('product-id');
    $.ajax({
        type: "POST",
        url: '/admin/ajax/get-product',
        data: {
            list_id: listId,
            product_id: productId,
            "_csrf-backend": csrf
        },
        beforeSend: function() {
            modal.find('.modal-body').html("<div style=text-align:center;\"> <image src='/backend/web/images/ajax-loader.gif' alt='ajax-loader' /> </div>");
        },
        success: function(response) {
            var data = response;
            modal.find('.modal-body').html(renderModalBodyProduct(data[0]));
            modal.modal('show');
        },
    }).fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });
});
/* ---------------------------------------------------*/
/* ------------------- Edit modal --------------------*/
/* ---------------------------------------------------*/


/* ---------------------------------------------------*/
/* ------------------- Functions --------------------*/
/* ---------------------------------------------------*/
function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}