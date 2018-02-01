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
// $('.products-list-datatable').dataTable({
//     ajax: "/admin/ajax/get-products-list"
// });

$.ajax({
    url: '/admin/ajax/get-products-list',
    method: 'POST',
    data: {
        '_csrf-backend': csrf
    },
    success: function(response) {
        console.log(response);
    }
}).fail(function (xhr) {
    console.log(xhr.responseText);
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
/* ------------------- Functions --------------------*/
/* ---------------------------------------------------*/
function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}