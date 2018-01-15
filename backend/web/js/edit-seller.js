$(function() {

    // Switchery toggles
    // if (Array.prototype.forEach) {
    //     var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));
    //     elems.forEach(function(html) {
    //         var switchery = new Switchery(html);
    //     });
    // }
    // else {
    //     var elems = document.querySelectorAll('.switchery');
    //     for (var i = 0; i < elems.length; i++) {
    //         var switchery = new Switchery(elems[i]);
    //     }
    // }

    //switchery
    $('#status').bootstrapSwitch();

    // csrf and user_id
    var csrf = $('[name="_csrf-backend"]').val();
    var user_id = $('#user_id').val();

    var initUsername = $('#username').val();
    var initEmail = $('#email').val();
    var initStatus = $('#status').bootstrapSwitch('state');

    // edit username
    $('#edit-username-button').on('click', function(e) {
        e.preventDefault();
        var username = $('#username').val();
        if(initUsername == username) {
            swal({
                title: "Успешно изменено!",
                confirmButtonColor: "#66BB6A",
                type: "success"
            });
        } else {
            $.ajax({
                method: 'POST',
                data: {
                    '_csrf-backend': csrf,
                    username: username,
                    user_id: user_id
                },
                url: '/admin/ajax/edit-seller-username',
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
                success: function(response) {
                    if(response.status == 'success') {
                        swal({
                            title: "Успешно изменено!",
                            confirmButtonColor: "#66BB6A",
                            type: "success"
                        });
                        initUsername = username;
                    } else if(response.status == 'fail') {
                        swal({
                            title: "При изменении произошла ошибка!",
                            confirmButtonColor: "#66BB6A",
                            type: "error"
                        });
                    }
                }
            }).fail(function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            });
        }

    });

    // edit email
    $('#edit-email-button').on('click', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        if(initEmail == email) {
            swal({
                title: "Успешно изменено!",
                confirmButtonColor: "#66BB6A",
                type: "success"
            });
        } else {
            $.ajax({
                method: 'POST',
                data: {
                    '_csrf-backend': csrf,
                    email: email,
                    user_id: user_id
                },
                url: '/admin/ajax/edit-seller-email',
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
                success: function(response) {
                    if(response.status == 'success') {
                        swal({
                            title: "Успешно изменено!",
                            confirmButtonColor: "#66BB6A",
                            type: "success"
                        });
                        initEmail = email;
                    } else if(response.status == 'fail') {
                        swal({
                            title: "При изменении произошла ошибка!",
                            confirmButtonColor: "#66BB6A",
                            type: "error"
                        });
                    }
                }
            }).fail(function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            });
        }
    });

    // edit password
    $('#edit-password-button').on('click', function(e) {
        e.preventDefault();
        var password = $('#password').val();
        $.ajax({
            method: 'POST',
            data: {
                '_csrf-backend': csrf,
                password: password,
                user_id: user_id
            },
            url: '/admin/ajax/edit-seller-password',
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
            success: function(response) {
                if (typeof response.error !== 'undefined') {
                    swal({
                        title: response.error,
                        confirmButtonColor: "#66BB6A",
                        type: "error"
                    });
                } else if(response.status == 'success') {
                    swal({
                        title: "Успешно изменено!",
                        confirmButtonColor: "#66BB6A",
                        type: "success"
                    });
                    initEmail = email;
                } else if(response.status == 'fail') {
                    swal({
                        title: "При изменении произошла ошибка!",
                        confirmButtonColor: "#66BB6A",
                        type: "error"
                    });
                }
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    });

    // edit status
    $('#edit-status-button').on('click', function(e) {
        e.preventDefault();
        var status = $('#status').bootstrapSwitch('state');
        if(initStatus == status) {
            swal({
                title: "Успешно изменено!",
                confirmButtonColor: "#66BB6A",
                type: "success"
            });
        } else {
            $.ajax({
                method: 'POST',
                data: {
                    '_csrf-backend': csrf,
                    status: status,
                    user_id: user_id
                },
                url: '/admin/ajax/edit-seller-status',
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
                success: function(response) {
                    if(response.status == 'success') {
                        swal({
                            title: "Успешно изменено!",
                            confirmButtonColor: "#66BB6A",
                            type: "success"
                        });
                        initStatus = status;
                    } else if(response.status == 'fail') {
                        swal({
                            title: "При изменении произошла ошибка!",
                            confirmButtonColor: "#66BB6A",
                            type: "error"
                        });
                    }
                }
            }).fail(function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            });
        }
    });

});
