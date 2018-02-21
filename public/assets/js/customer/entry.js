var entry = function(){
    /* SCREEN CREATE ENTRY */

    var convert_zen2han = function() {
        $('input[name = "email"]').on('change',function(){
            utility.zen2han(this);
        });
        $('input[name = "zipcode1"]').on('change',function(){
            utility.zen2han(this);
        });
        $('input[name = "zipcode2"]').on('change',function(){
            utility.zen2han(this);
        });
        $('input[name = "tel1"]').on('change',function(){
            utility.zen2han(this);
        });
        $('input[name = "tel2"]').on('change',function(){
            utility.zen2han(this);
        });
        $('input[name = "tel3"]').on('change',function(){
            utility.zen2han(this);
        });
        $('input[name = "fax1"]').on('change',function(){
            utility.zen2han(this);
        });
        $('input[name = "fax2"]').on('change',function(){
            utility.zen2han(this);
        });
        $('input[name = "fax3"]').on('change',function(){
            utility.zen2han(this);
        });
    };

    var submit = function () {
        $('#fm_btn_confirm').off('click').on('click', function(){
                $(this).attr('disabled', true);
                $('#fm_action').submit();
            }
        )
    };

    return {
        init:function(){
            convert_zen2han();
            submit();
        }
    };
}();

$(function(){
    entry.init();
});
