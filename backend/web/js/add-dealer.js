$(function() {
    // Form components
    // ------------------------------

    // Switchery toggles
    var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
    elems.forEach(function(html) {
        var switchery = new Switchery(html);
    });

    // Bootstrap switch
    $(".switch").bootstrapSwitch();

    // Bootstrap multiselect
    $('.multiselect').multiselect({
        checkboxName: 'vali'
    });

    // Touchspin
    $(".touchspin-postfix").TouchSpin({
        min: 0,
        max: 100,
        step: 0.1,
        decimals: 2,
        postfix: '%'
    });

    // Select2 select
    $('.select').select2({
        minimumResultsForSearch: Infinity
    });

    // Styled checkboxes, radios
    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice' });

    // Styled file input
    $(".file-styled").uniform({
        fileButtonClass: 'action btn bg-blue'
    });



    // Submit form
    $('#add-dealer-submit').on('click', function (e) {
        e.preventDefault();
        var form = document.getElementById('add-dealer-form');
        var formData = new FormData(form);
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
            url: '/admin/ajax/add-dealer',
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
                } else if (response.status_code == 201) {
                    swal({
                        title: "Дилер добавлен!",
                        confirmButtonColor: "#66BB6A",
                        type: "success"
                    }, function() {
                        document.location.reload();
                    });
                }
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    });


    // Reset form
    $('#reset').on('click', function() {

    });

});
