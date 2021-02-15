
$(function () {
    // init: side menu for current page
    // init: side menu for current page
    $('li#menu-companies').addClass('menu-open active');
    $('li#menu-companies').find('.treeview-menu').css('display', 'block');
    $('li#menu-companies').find('.treeview-menu').find('.add-companies a').addClass('sub-menu-active');


    $('#user-form').validationEngine('attach', {
        promptPosition: 'topLeft',
        scroll: false


    });

    // init: show tooltip on hover
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    // show password field only after 'change password' is clicked
    $('#reset-button').click(function (e) {
        $('#reset-field').removeClass('hide');
        $('#show-password-check').removeClass('hide');
        // to always uncheck the checkbox after button click
        $('#show-password').prop('checked', false);
    });

    $(function () {
        $(":file").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    function imageIsLoaded(e) {
        $('#images').attr('src', e.target.result);
        $('#yourImage').attr('src', e.target.result);
    };

});

function autofill() {
    var postcode = $("#postcode").val();
    //alert(postcode);
    $.ajax({
        url: '/autocomplete',
        data: 'postcode=' + postcode,
        success: function (data) {
            var json = data;
            obj = JSON.parse(json);
            $("#city").val(obj.city);
            $("#local").val(obj.local);
            $("#prefecture").val(obj.id);
            
            
        }

    });

};