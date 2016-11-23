var job = function(){
    var resize_window = function(){
        $(window).off('resize').on('resize',function(){
            disable_if_hide();
        });
    };

    var disable_if_hide = function() {
        $('select:hidden,input:hidden').attr('disabled', true);
        $('select:visible,input:visible').removeAttr('disabled');
        $('input.hidden_job_id').removeAttr('disabled');
    };

    var keeplist = function(){
        $('.btn-keeplist').click(function(){
            var keeplist = '<img class="imghover" src="'+baseUrl+'assets/common_img/btn_application01.png" alt="キープする" style="opacity: 1;">',
                unkeeplist = '<img alt="キープ削除" src="'+baseUrl+'assets/common_img/btn_application01_2.png" class="imghover" style="opacity: 1;">',
                job_id = $(this).attr('value');
            _process_keeplist(keeplist,unkeeplist,job_id);
        });
    };

    var _process_keeplist = function(keeplist,unkeeplist,job_id){
        $.ajax({
            url: baseUrl+'keeplist/keeplist',
            type: 'post',
            data: {job_id: job_id},
            dataType: 'json',
            success:function(data) {
                if( ! data)
                {
                    alert('応募可能期間が終了しています。');
                    location.reload();
                }
                if(data.flag == 'limitkeeplist')
                {
                    alert('キープリストへの追加は20件までとなります。');
                    return;
                }
                if (data.flag == 'bookmark') {
                    $('.keeplist' + job_id).html(unkeeplist);
                }
                else {
                    $('.keeplist' + job_id).html(keeplist);
                    $('#page_keeplist #item-job-' + job_id).slideUp("slow");
                }
                var data_keeplist = data.keeplist;
                var count = 0;
                for (var k in data_keeplist) {
                    if (data_keeplist.hasOwnProperty(k)) {
                        ++count;
                    }
                }
                $('.common-keeplist em').text(count);
                $('#keeplist_count_job').text(count);
            }
        });
    };

    var submit_apply_job = function(){
        $('.btn_submit_apply_job').off('click').on('click',function(){
            var form = $(this).closest('form'),
                job_id = form.find('.hidden_job_id').val();
            $.ajax({
                url: baseUrl+'keeplist/check_time',
                type: 'post',
                data: {job_id: job_id},
                dataType: 'json',
                success:function(data) {
                    if(data.message == true){
                        form.submit();
                    }
                    else {
                        alert('応募可能期間が終了しています。');
                        location.reload();
                    }
                }
            });
        });
    };

    var search_keyword = function(){
        $('#btn_keyword_search').off('click').on('click',function(){
            var trim_keyword = $('#keyword').val().trim();
            if(trim_keyword == '') return false;
            $('#keyword').val(trim_keyword);
            $(this).closest('form').submit();
        });
    };

    return {
        init:function(){
            keeplist();
            disable_if_hide();
            resize_window();
            submit_apply_job();
            search_keyword();
        }
    }
}();

$(function(){
    job.init();
});
