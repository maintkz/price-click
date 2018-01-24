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



    /* -------------------------------------------------------------------- */
    /* custom js */
    /* -------------------------------------------------------------------- */

});


/* -------------------------------------------------------------------- */
/* ajax loading sections, categories, subcategories */
/* -------------------------------------------------------------------- */
$('document').ready(function() {
    var csrf = $('[name="_csrf-backend"]').val();
    var structure = {};
    var selectedSectionId;
    var selectedCategoryId;
    $.ajax({
        type: 'POST',
        url: '/admin/ajax/get-categories-structure',
        data: {
            "_csrf-backend": csrf
        },
        success: function(response){
            console.log(response);
            structure = response;
            var i = 0;
            $.each(response, function(index, value) {
                if(i == 0) firstSectionId = index; i++;
                $('#product-section').append("<option value='" + index + "'>" + value.section_name + "</option>");
            });
            $('#product-section').selectpicker('refresh');

            i = 0;
            console.log(structure);
            $.each(structure[ firstSectionId ].categories, function(index, value) {
                if(i == 0) firstCategoryId = index; i++;
                $('#product-category').append("<option value='" + index + "'>" + value.category_name + "</option>").selectpicker('refresh');
            });

            $.each(structure[ firstSectionId ].categories[ firstCategoryId ].subcategories, function(index, value) {
                $('#product-subcategory').append("<option value='" + index + "'>" + value + "</option>").selectpicker('refresh');
            });
        }
    }).fail(function (xhr, textStatus, errorThrown) {
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
