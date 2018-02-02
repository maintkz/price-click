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


    $('#add-shop-button').on('click', function (e) {
        e.preventDefault();
        var form = document.getElementById('add-shop-form');
        var formData = new FormData(form);
        // for (var pair of formData.entries()) {
        //     console.log(pair[0]+ ', ' + pair[1]);
        // }
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
            url: '/admin/ajax/add-shop',
            contentType: false,
            processData: false,
            data: formData,
            success: function(response){
                console.log(response);
                if (response.status_code == 400) {
                    $('.validation-error-label').remove();
                    $.each(response.error, function (key, value) {
                        var name = response.target + '[' + key + ']';
                        $('[name="' + name + '"]').after('<label class="validation-error-label">' + value + '</label>');
                        console.log(name);
                    });
                    swal({
                        title: "Заполните поля правильно!",
                        type: "error"
                    });
                } else if (response.status_code == 500) {
                    swal({
                        title: "Не сохранено. Попробуйте еще раз.",
                        type: "error"
                    });
                } else if (response.status_code == 403) {
                    swal({
                        title: "Не сохранено. У вас нет прав.",
                        type: "error"
                    });
                } else if (response.status_code == 201) {
                    swal({
                        title: "Продавец добавлен!",
                        confirmButtonColor: "#66BB6A",
                        type: "success"
                    }, function() {
                        window.location.href = '/admin';
                    });
                }
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    });

});