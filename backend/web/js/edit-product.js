/* ------------------------------------------------------------------------------
*
*  # Bootstrap multiple file uploader
*
*  Specific JS code additions for uploader_bootstrap.html page
*
*  Version: 1.2
*  Latest update: Aug 10, 2016
*
* ---------------------------------------------------------------------------- */

$(function() {

    // Modal template
    var modalTemplate = '<div class="modal-dialog modal-lg" role="document">\n' +
        '  <div class="modal-content">\n' +
        '    <div class="modal-header">\n' +
        '      <div class="kv-zoom-actions btn-group">{toggleheader}{fullscreen}{borderless}{close}</div>\n' +
        '      <h6 class="modal-title">{heading} <small><span class="kv-zoom-title"></span></small></h6>\n' +
        '    </div>\n' +
        '    <div class="modal-body">\n' +
        '      <div class="floating-buttons btn-group"></div>\n' +
        '      <div class="kv-zoom-body file-zoom-content"></div>\n' + '{prev} {next}\n' +
        '    </div>\n' +
        '  </div>\n' +
        '</div>\n';

    // Buttons inside zoom modal
    var previewZoomButtonClasses = {
        toggleheader: 'btn btn-default btn-icon btn-xs btn-header-toggle',
        fullscreen: 'btn btn-default btn-icon btn-xs',
        borderless: 'btn btn-default btn-icon btn-xs',
        close: 'btn btn-default btn-icon btn-xs'
    };

    // Icons inside zoom modal classes
    var previewZoomButtonIcons = {
        prev: '<i class="icon-arrow-left32"></i>',
        next: '<i class="icon-arrow-right32"></i>',
        toggleheader: '<i class="icon-menu-open"></i>',
        fullscreen: '<i class="icon-screen-full"></i>',
        borderless: '<i class="icon-alignment-unalign"></i>',
        close: '<i class="icon-cross3"></i>'
    };

    // File actions
    var fileActionSettings = {
        zoomClass: 'btn btn-link btn-xs btn-icon',
        zoomIcon: '<i class="icon-zoomin3"></i>',
        dragClass: 'btn btn-link btn-xs btn-icon',
        dragIcon: '<i class="icon-three-bars"></i>',
        removeClass: 'btn btn-link btn-icon btn-xs',
        removeIcon: '<i class="icon-trash"></i>',
        indicatorNew: '<i class="icon-file-plus text-slate"></i>',
        indicatorSuccess: '<i class="icon-checkmark3 file-icon-large text-success"></i>',
        indicatorError: '<i class="icon-cross2 text-danger"></i>',
        indicatorLoading: '<i class="icon-spinner2 spinner text-muted"></i>'
    };

    $('.file-input').fileinput({
        browseLabel: 'Browse',
        browseIcon: '<i class="icon-file-plus"></i>',
        uploadIcon: '<i class="icon-file-upload2"></i>',
        removeIcon: '<i class="icon-cross3"></i>',
        layoutTemplates: {
            icon: '<i class="icon-file-check"></i>',
            modal: modalTemplate
        },
        initialCaption: "Ни одна картинка не выбрана",
        previewZoomButtonClasses: previewZoomButtonClasses,
        previewZoomButtonIcons: previewZoomButtonIcons,
        fileActionSettings: fileActionSettings
    });


    //
    // select pickers
    //
    // Override defaults
    $.fn.selectpicker.defaults = {
        iconBase: '',
        tickIcon: 'icon-checkmark3'
    }

    // Basic select
    $('.bootstrap-select').selectpicker();

    /* -------------------------------------------------------------------- */
    /* validator */
    /* -------------------------------------------------------------------- */

    var validator = $(".form-validate-jquery").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Input group, styled file input
            if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("Успешно.")
        },
        rules: {
            "ProductsList['section_id']": {
                required: true
            },
            "Products[product_name]": {
                required: true
            },
            "Products[product_price]": {
                required: true,
                digits: true
            },
            "ProductsList[product_list_count]": {
                required: true,
                digits: true
            },
            "parameter[name][]": {
                required: true
            },
            "parameter[value][]": {
                required: true
            },
            "size": {
                required: true
            }
        },
        messages: {
            custom: {
                required: "This is a custom error message",
            }
        },
        submitHandler: function(e) {

            var productParameters = {};

            var productSize = [];
            if(typeof $('[name="size"]').val() !== 'undefined') {
                var productSize = $('[name="size"]').val();
                productSize = productSize.split(/\s*,\s*/);
            }

            var productColor = [];
            if(typeof $('.sp-preview-inner').val() !== 'undefined') {
                $('.sp-preview-inner').each(function() {
                    var rgb = $(this).css('background-color');
                    rgb = rgb.substr(4, rgb.length - 5);    // rgb(255, 255, 255) => 255, 255, 255
                    rgb = rgb.split(/\s*,\s*/);             // 255, 255, 255 => [255, 255, 255]
                    hex = rgbToHex(rgb[0], rgb[1], rgb[2]);
                    productColor.push(hex);
                });
            }
            var anotherParameters = {};
            var productParametersName = [];
            var productParametersValue = [];
            if(typeof $('[name="parameter[name][]"]').val() !== 'undefined' && typeof $('[name="parameter[value][]"]').val() !== 'undefined') {
                $('[name="parameter[name][]"]').each(function() {
                    productParametersName.push($(this).val());
                });
                $('[name="parameter[value][]"]').each(function() {
                    productParametersValue.push($(this).val());
                });
                productParametersName.forEach(function(item, i, productParametersName) {
                    anotherParameters[productParametersName[i]] = productParametersValue[i];
                });
            }

            productParameters.productColor = productColor;
            productParameters.productSize = productSize;
            productParameters.productParameters = anotherParameters;

            var form = document.getElementById('add-product-form');
            var formData = new FormData(form);
            formData.append("Products[product_parameters]", JSON.stringify(productParameters));
            // console.log(productSize);
            $.ajax({
                beforeSend: function() {
                    swal({
                        title: "Ваш запрос обрабатывается",
                        text: "<image src='/backend/web/images/ajax-loader.gif' alt='ajax-loader'>",
                        html: true,
                        showSpinner: true,
                        confirmButtonColor: "#2196F3",
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                },
                type: 'POST',
                url: '/admin/seller/add-product-ajax',
                // cache : false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response){
                    console.log(response);
                    swal({
                        title: "Товар добавлен!",
                        confirmButtonColor: "#66BB6A",
                        type: "success"
                    });
                }
            }).fail(function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            });

        }
    });

    /* -------------------------------------------------------------------- */
    /* custom js */
    /* -------------------------------------------------------------------- */

    // Color picker
    var palette = [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ]

    var colorParameterHtml = "<!-- Color -->" +
        "                <div class='form-group'>" +
        "                    <label class='control-label col-lg-3'>Цвета</label>" +
        "                    <div class='col-lg-2'>" +
        "                        <input type='text' class='form-control' readonly='readonly' value='color'>" +
        "                    </div>" +
        "                    <label class='control-label col-lg-3'>Выберите цвет</label>" +
        "                    <div class='col-lg-3'>" +
        "                        <input type='text' class='form-control colorpicker-palette-only' value='#27ADCA'>" +
        "                        <div id='color-insert-helper' style='display: inline-block; width: 0'></div>" +
        "                        <button id='add-color-button' class='btn btn-primary' type='button'>+</button>" +
        "                    </div>" +
        "                    <div class='col-lg-1'>" +
        "                        <button id='remove-color-button' class='btn btn-danger' type='button'>X</button>" +
        "                    </div>" +
        "                </div>" +
        "                <!-- /Color -->";

    var addColorHtml = "<input type='text' class='form-control colorpicker-palette-only' value='#27ADCA'>";

    var sizeParameterHtml = "<!-- Size -->" +
        "                <div class='form-group'>" +
        "                    <label class='control-label col-lg-3'>Размеры</label>" +
        "                    <div class='col-lg-2'>" +
        "                        <input type='text' class='form-control' readonly='readonly' value='size'>" +
        "                    </div>" +
        "                    <label class='control-label col-lg-3'>Перечислите размеры через запятую  <span class='text-danger'>*</span></label>" +
        "                    <div class='col-lg-3'>" +
        "                        <input type='text' name='size' class='form-control' placeholder='например: 48, 49, 50'>" +
        "                    </div>" +
        "                    <div class='col-lg-1'>" +
        "                        <button id='remove-size-button' class='btn btn-danger' type='button'>X</button>" +
        "                    </div>" +
        "                </div>" +
        "                <!-- /size -->";

    var customParameterHtml = "<!-- Parameter -->" +
        "                <div class='form-group'>" +
        "                    <label class='control-label col-lg-3'>Название параметра <span class='text-danger'>*</span></label>" +
        "                    <div class='col-lg-2'>" +
        "                        <input type='text' name='parameter[name][]' class='form-control' placeholder='Название параметра'>" +
        "                    </div>" +
        "                    <label class='control-label col-lg-3'>Значение параметра <span class='text-danger'>*</span></label>" +
        "                    <div class='col-lg-3'>" +
        "                        <input type='text' name='parameter[value][]' class='form-control' placeholder='Значение параметра'>" +
        "                    </div>" +
        "                    <div class='col-lg-1'>" +
        "                        <button id='remove-parameter-button' class='btn btn-danger' type='button'>X</button>" +
        "                    </div>" +
        "                </div>" +
        "                <!-- /parameter -->";

    var colorAdded = false;
    var sizeAdded = false;

    $('body').on('click', '#add-parameter-button', function(e) {
        e.preventDefault();
        var addParameterName = $('#add-parameter-select').val();

        if(addParameterName == 'color' && !colorAdded) {
            $('#parameter-insert-helper').before(colorParameterHtml);
            $(".colorpicker-palette-only").spectrum({
                showPalette: true,
                showPaletteOnly: true,
                palette: palette
            });
            colorAdded = true;
        } else if(addParameterName == 'size' && !sizeAdded) {
            $('#parameter-insert-helper').before(sizeParameterHtml);
            sizeAdded = true;
        } else if(addParameterName == 'custom') {
            $('#parameter-insert-helper').before(customParameterHtml);
        }
    });

    /* color buttons */
    $('body').on('click', '#add-color-button', function(e) {
        e.preventDefault();

        $('#color-insert-helper').before(addColorHtml);
        $(".colorpicker-palette-only").spectrum({
            showPalette: true,
            showPaletteOnly: true,
            palette: palette
        });
    });
    $('body').on('click', '#remove-color-button', function(e) {
        e.preventDefault();

        $(this).closest('.form-group').remove();
        colorAdded = false;
    });
    /* size remove button */
    $('body').on('click', '#remove-size-button', function(e) {
        e.preventDefault();

        $(this).closest('.form-group').remove();
        sizeAdded = false;
    });
    /* size parameter button */
    $('body').on('click', '#remove-parameter-button', function(e) {
        e.preventDefault();

        $(this).closest('.form-group').remove();
        colorAdded = false;
    });
});


/* -------------------------------------------------------------------- */
/* ajax loading sections, categories, subcategories */
/* -------------------------------------------------------------------- */

$('document').ready(function() {
    var csrf = $('[name="_csrf-backend"]').val();
    var productListId = $('[name="product_list_id"]').val();
    var structure = {};
    var selectedSectionId;
    var selectedCategoryId;
    var categories;

    // load section category and subcategory of product
    $.ajax({
        type: 'POST',
        url: '/admin/ajax/get-product-subcategory',
        data: {
            "_csrf-backend": csrf,
            "product_list_id": productListId
        },
        success: function(response){
            categories = response;
            console.log(categories);

        }
    })
    .done(function() {
        $.ajax({
            type: 'POST',
            url: '/admin/ajax/get-categories-structure',
            data: {
                "_csrf-backend": csrf
            },
            success: function(response){
                structure = response;
                $.each(response, function(index, value) {
                    firstSectionId = categories.section_id;
                    $('#product-section').append("<option value='" + index + "'>" + value.section_name + "</option>");
                });
                $('#product-section').selectpicker('refresh').selectpicker('val', categories.section_id);

                i = 0;
                $.each(structure[ firstSectionId ].categories, function(index, value) {
                    firstCategoryId = categories.category_id;
                    $('#product-category').append("<option value='" + index + "'>" + value.category_name + "</option>").selectpicker('refresh');
                });
                $('#product-category').selectpicker('refresh').selectpicker('val', categories.category_id);

                $.each(structure[ firstSectionId ].categories[ firstCategoryId ].subcategories, function(index, value) {
                    $('#product-subcategory').append("<option value='" + index + "'>" + value + "</option>").selectpicker('refresh').selectpicker('val', 3);
                });
                $('#product-subcategory').selectpicker('refresh').selectpicker('val', categories.subcategory_id);
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    })
    .fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });

    $('body').on('change', "#product-section", function () {
        i = 0;
        selectedSectionId = $(this).val();
        $('#product-category').empty();
        $('#product-subcategory').empty();
        $.each(structure[ selectedSectionId ].categories, function(index, value) {
            if(i == 0) firstCategoryId = index; i++;
            $('#product-category').append("<option value='" + index + "'>" + value.category_name + "</option>").selectpicker('refresh');;
        });
        $.each(structure[ selectedSectionId ].categories[ firstCategoryId ].subcategories, function(index, value) {
            $('#product-subcategory').append("<option value='" + index + "'>" + value + "</option>").selectpicker('refresh');;
        });
    });

    $('body').on('change', '#product-category', function() {
        selectedSectionId = $('#product-section').val();
        selectedCategoryId = $(this).val();
        $('#product-subcategory').empty();
        $.each(structure[ selectedSectionId ].categories[ selectedCategoryId ].subcategories, function(index, value) {
            $('#product-subcategory').append("<option value='" + index + "'>" + value + "</option>").selectpicker('refresh');;
        });
    });

});


/* functions */
function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}
function rgbToHex(r, g, b) {
    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}