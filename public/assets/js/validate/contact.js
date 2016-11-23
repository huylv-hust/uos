var contact = function(){

    var ready = function(){
        $(function(){

        });
    };

    // event submit form
    var submit = function(){
        $('.btn-contact-submit').click(
            function(){
                $('#form-contact-index').submit();
            }
        )
    };

    //evnet confirm form
    var confirm = function(){
        $('.btn-contact-confirm').click(function(){
            $('#form-contact-confirm').submit();
        });
        $('.btn-contact-back-step1').click(function(){
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
            ready();
            submit();
            confirm();
            convert_zen2han();
        }
    };
}();

$(function(){
    contact.init();
});
