$(function() {

    /* ----------------------------- */
    /* ajax for populate city select */
    /* ----------------------------- */
    $.ajax({
        type: 'POST',
        url: '/admin/ajax/get-cities',
        success: function (cities) {
            console.log(cities);
            var length = cities.length;
            var i;
            var options = '';
            for (i = 0; i < length; i ++) {
                options += '<option value="' + cities[i].city_id + '">' + cities[i].city_name + '</option>';
            }
            $('#cities').html(options);
            $('#cities').selectpicker();
        }
    }).fail(function (xhr, textStatus, errorThrown) {
        console.log(xhr.responseText);
    });
    /* ----------------------------- */
    /* ----------------------------- */
    /* ----------------------------- */


    /* ----------------------------- */
    /*     ajax for adding seller    */
    /* ----------------------------- */
    $('#add-seller-button').on('click', function (e) {
        e.preventDefault();
        var form = document.getElementById('add-seller-form');
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
            url: '/admin/ajax/add-seller',
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
                        window.location.href = '/admin/dealer/sellers-list';
                    });
                }
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    });

});
