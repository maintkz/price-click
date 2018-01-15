// $('#apartments-phone').mask('+7 (999) 999-99-99');

// $('body').on('click', '#apartment-submit', function(e) {
//     e.preventDefault();
//
// });

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



    // Setup validation
    // ------------------------------

    // Initialize
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

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo( element.parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("Успешно.");
        },
        rules: {

            maximum_characters: {
                maxlength: 10
            },
            minimum_number: {
                min: 10
            },
            maximum_number: {
                max: 10
            },
            url: {
                url: true
            },
            date: {
                date: true
            },
        },
        messages: {
            custom: {
                required: "This is a custom error message",
            }
        }
    });


    // Reset form
    $('#reset').on('click', function() {
        validator.resetForm();
    });


});
