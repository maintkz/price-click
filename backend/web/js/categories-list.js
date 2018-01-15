$('document').ready(function() {

    var structure = {};
    var categoryHtml = '';
    var subcategoryHtml = '';
    var csrf = $('[name="_csrf-backend"]').val();
    $.ajax({
        url: '/admin/ajax/get-categories-structure',
        method: 'POST',
        data: {
            '_csrf-backend': csrf
        },
        success: function(response) {
            structure = response;
        },
    });

    //on click to sections categories subcategories list
    $('body').on('click', '#table-section td', function() {
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('#table-category tbody').empty();
            $('#table-subcategory tbody').empty();
        } else {
            $(this).parent().parent().find('td').removeClass('active');
            $(this).addClass('active');
            $('#table-category tbody').empty();
            $('#table-subcategory tbody').empty();
            var sectionId = $(this).data('section-id');
            $.ajax({
                url: '/admin/ajax/get-categories',
                method: 'POST',
                data: {
                    '_csrf-backend': csrf,
                    'section_id': sectionId
                },
                success: function(response) {
                    console.log(response);
                    var categoryHtml = "";
                    $.each(response, function(index, value) {
                        categoryHtml += "<tr>" +
                                "<td data-section-id='" + sectionId + "' data-category-id='" + value.category_id + "'>" + value.category_name + "</td>" +
                            "</tr>";
                    });
                    $('#table-category tbody').empty().html(categoryHtml);
                }
            });
        }
    });

    $('body').on('click', '#table-category td', function() {
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('#table-subcategory tbody').empty();
        } else {
            $(this).parent().parent().find('td').removeClass('active');
            $(this).addClass('active');
            $('#table-subcategory tbody').empty();
            var sectionId = $(this).data('section-id');
            var categoryId = $(this).data('category-id');
            $.ajax({
                url: '/admin/ajax/get-subcategories',
                method: 'POST',
                data: {
                    '_csrf-backend': csrf,
                    'section_id': sectionId,
                    'category_id': categoryId
                },
                success: function(response) {
                    console.log(response);
                    var subcategoryHtml = "";
                    $.each(response, function(index, value) {
                        subcategoryHtml += "<tr>" +
                            "<td data-subcategory-id='" + value.subcategory_id + "'>" + value.subcategory_name + "</td>" +
                            "</tr>";
                    });
                    $('#table-subcategory tbody').empty().html(subcategoryHtml);
                }
            });
        }
    });

    $('body').on('click', '#table-subcategory td', function() {
        $(this).parent().parent().find('td').removeClass('active');
        $(this).addClass('active');
    });

    // ---------------------------------------------------- //
    // add section, category. subcategory
    var title = '';
    var placeholder = '';
    var data = {};
    $('body').on('click', '.add-ctg-btn', function(e) {
        e.preventDefault();
        var addError = '';
        var name = $(this).data('name');
        if(name == 'section') {
            title = 'Добавление раздела';
            text = '';
            placeholder = 'Название раздела';
        } else if(name == 'category') {
            section_id = $('#table-section td.active').data('section-id');
            section_name = $('#table-section td.active').text();
            title = 'Добавление категории';
            text = 'Добавление категории в Раздел: "' + section_name + '"';
            placeholder = 'Название категории';
            if(typeof section_id == 'undefined') addError = 'Выберите Раздел';
        } else if(name == 'subcategory') {
            section_id = $('#table-section td.active').data('section-id');
            section_name = $('#table-section td.active').text();
            category_id = $('#table-category td.active').data('category-id');
            category_name = $('#table-category td.active').text();

            title = 'Добавление подкатегории';
            text = 'Добавление подкатегории в "' + section_name + '" => "' + category_name + '"';
            placeholder = 'Название подкатегории';
            if(typeof section_id == 'undefined' || section_name == '') {
                addError = 'Выберите Раздел и Категорию';
            } else if(typeof category_id == 'undefined' || category_name == '') {
                addError = 'Выберите Категорию';
            }
        }
        if(addError != '') {
            swal({
                title: addError,
                confirmButtonColor: "#66BB6A",
                type: "warning"
            });
        } else {
            swal({
                title: title,
                text: text,
                type: "input",
                showCancelButton: true,
                confirmButtonColor: "#2196F3",
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: placeholder,
                showLoaderOnConfirm: true
            },
            function(inputValue){
                if(name == 'section') {
                    data = {
                        'type': 'section',
                        'section_name': inputValue
                    };
                } else if(name == 'category') {
                    data = {
                        'type': 'category',
                        'section_id': section_id,
                        'category_name': inputValue
                    };
                } else if(name == 'subcategory') {
                    data = {
                        'type': 'subcategory',
                        'section_id': section_id,
                        'section_name': section_name,
                        'category_id': category_id,
                        'category_name': category_name,
                        'subcategory_name': inputValue
                    };
                }

                if (inputValue === false) return false;
                if (inputValue === "") {
                    swal.showInputError("Необходимо ввести название раздела");
                    return false;
                } else {
                    $.ajax({
                        url: '/admin/ajax/add-to-structure',
                        method: 'POST',
                        data: {
                            '_csrf-backend': csrf,
                            data: data
                        },
                        success: function(response) {
                            console.log(response);
                            if(response.status == 'success') {
                                swal({
                                    title: "Успешно добавлено",
                                    type: "success",
                                    confirmButtonColor: "#2196F3"
                                }, function() {
                                    window.location.href = '/admin/administrator/categories-list';
                                });
                            } else if(response.status == 'fail') {
                                swal({
                                    title: "Произошла ошибка",
                                    text: response.error,
                                    type: "error",
                                });
                            }
                        },
                    }).fail(function (xhr, textStatus, errorThrown) {
                        console.log(xhr.responseText);
                    });
                }
            });
        };
    });

    // ---------------------------------------------------- //
    // remove sections categories subcategories
    var delId = '';
    var warningText = '';
    $('body').on('click', '.remove-ctg-btn', function() {
        var name = $(this).data('name');
        if(name == 'section') {
            warningText = 'Выберите Раздел для удаления';
            confirmText = 'Внимание вместе с разделом будут удалены все категории и подкатегории, а также товары в них входящие!';
            delId = $('#table-section').find('td.active').data('section-id');
            data = {
                'name': 'section',
                'section_id': delId
            };
        } else if (name == 'category') {
            warningText = 'Выберите Категорию для удаления';
            confirmText = 'Внимание вместе с категорией будут удалены все подкатегории, а также товары в них входящие!';
            delId = $('#table-category').find('td.active').data('category-id');
            data = {
                'name': 'category',
                'category_id': delId
            };
        } else if(name == 'subcategory') {
            warningText = 'Выберите Подкатегорию для удаления';
            confirmText = 'Подкатегория будет удалена';
            delId = $('#table-subcategory').find('td.active').data('subcategory-id');
            data = {
                'name': 'subcategory',
                'subcategory_id': delId
            };
        }

        if(typeof delId == 'undefined') {
            swal({
                title: warningText,
                confirmButtonColor: "#66BB6A",
                type: "warning"
            });
        } else {
            swal({
                title: "Вы уверены?",
                text: confirmText,
                showCancelButton: true,
                confirmButtonColor: "#2196F3",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function() {
                $.ajax({
                    url: '/admin/ajax/remove-from-structure',
                    method: 'POST',
                    data: {
                        '_csrf-backend': csrf,
                        'data': data
                    },
                    success: function(response) {
                        console.log(response);
                        if(response.status == 'success') {
                            swal({
                                title: "Успешно удалено",
                                type: "success",
                                confirmButtonColor: "#2196F3"
                            }, function() {
                                window.location.href = '/admin/administrator/categories-list';
                            });
                        } else if(response.status == 'fail') {
                            swal({
                                title: "Произошла ошибка",
                                text: response.error,
                                type: "error",
                            });
                        }
                    }
                });
            });
        }
    });
});
