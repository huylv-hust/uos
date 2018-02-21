var contact = function(){
    // event submit form
    var submit = function(){
        $('.btn-contact-submit').off('click').on('click', function(){
                $(this).attr('disabled', true);
                $('#form-contact-index').submit();
            }
        )
    };

    //evnet confirm form
    var confirm = function(){
        $('.btn-contact-confirm').click(function(){
            $('.submit-btn').attr('disabled', true);
            $('#form-contact-confirm').submit();
        });
        $('.btn-contact-back-step1').click(function(){
            $('.submit-btn').attr('disabled', true);
            $('#form-contact-confirm').attr('action',baseUrl+'contact/index');
            $('#form-contact-confirm').submit();
        });
    };

    var convert_zen2han = function() {
        $('#form_mobile').on('change', function () {
            utility.zen2han(this);
        });
    };


    return {
        init:function(){
            submit();
            confirm();
            convert_zen2han();
        }
    };
}();

$(function(){
    contact.init();
});
