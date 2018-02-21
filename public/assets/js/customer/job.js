var job = function () {
    var search_shop = function () {
        $('#btn_search_shop').on('click', function () {
            var modal = $(this).closest('.remodal'),
                keyword = modal.find('.modal_keyword_search').val();
            $.ajax({
                url: baseUrl + 'ajax/common/searchSaleShop',
                method: 'POST',
                data: {
                    keyword_modal_sale_job: keyword,
                },
                dataType: 'json'
            }).success(function (data) {
                modal.find('tbody').empty();
                $.each(data, function (key, val) {
                    var item = $('<td class="list_item"></td>')
                        .attr('shop-id', val.shop_id)
                        .attr('access', val.access)
                        .attr('application_price', val.application_price)
                        .attr('employment_price', val.employment_price)
                        .text(val.shop_name)
                    ;
                    modal.find('tbody').append(
                        $('<tr></tr>').append(item)
                    );
                });

                if (data.length == 0) {
                    alert('見つかりませんでした');
                }
            });
        });

        $('form.finder').on('submit', function() {
            $('#btn_search_shop').trigger('click');
            return false;
        });
    };

    //choose shop
    var choose_shop = function () {
        $(document).on('click', '.remodal .list_item', function () {
            $('p#shop_name').html(utility.html_encode($(this).text()));
            $('input[name=shop_id]').val($(this).attr('shop-id'));
            $('input[name=shop_name]').val($(this).text());
            if ($('input[name=access]').val().length == 0) {
                $('input[name=access]').val($(this).attr('access'));
            }
            $('input[name=price_view]').val($(this).attr('employment_price'));
            $('input[name=price]').val($(this).attr('employment_price'));
            $('#shopfinder').remodal().close();
            return false;
        });
    };

    var set_enddate = function () {
        $('input[name=start_date]').on('change', function() {
            if ($('input[name=end_date]').val().length == 0) {
                $('input[name=end_date]').val(utility.get6monthAfter($(this).val()));
            }
        });
    };

    var preview = function () {
        $('#fm_btn_previes').on('click', function() {
            if ($('input[name=shop_id]').val().length == 0) {
                alert('店舗を選択してください');
                return false;
            }
            var form = $('#fm_action');
            var savedAction =  form.attr('action');
            form.attr('action', $('input[name=preview_url]').val());
            form.attr('target', '_blank');
            form.submit();
            form.attr('target', '');
            form.attr('action', savedAction);
        });
    };

    return {
        init: function () {
            search_shop();
            choose_shop();
            set_enddate();
            preview();
        }
    }
}();

var jobs = function () {
    var click_add_btn = function () {
        $('[name=add-btn]').on('click', function () {
            location.href = baseUrl + 'customer/job';
        });
    };

    var process = function () {
        $('[name=process]').on('change', function () {
            var action = $(this).val(),
                job_id = $(this).attr('job-id');
            if (action == 'edit') {
                location.href = baseUrl + 'customer/job?job_id=' + job_id;
            } else if (action == 'delete') {
                if (confirm('指定求人を削除します、よろしいですか？')) {
                    $.ajax({
                        url: baseUrl + 'customer/jobs/delete',
                        method: 'POST',
                        data: {
                            job_id: job_id
                        },
                    }).success(function (data) {
                        location.reload();
                    });
                }
            } else if ($(this).val() == 'open') {
                if ($(this).closest('tr').attr('data-status') != 2) {
                    alert('編集中もしくは掲載申請中の求人は公開できません');
                    $(this).val('');
                    return false;
                }
                if (confirm('指定求人を公開します、よろしいですか？')) {
                    $.ajax({
                        url: baseUrl + 'customer/jobs/open',
                        method: 'POST',
                        data: {
                            job_id: job_id
                        },
                    }).success(function (response) {
                        location.reload();
                    }).fail(function (response) {
                        console.log(response);
                    });
                }
            } else if ($(this).val() == 'stop') {
                if (confirm('指定求人を非公開にします、よろしいですか？')) {
                    $.ajax({
                        url: baseUrl + 'customer/jobs/stop',
                        method: 'POST',
                        data: {
                            job_id: job_id
                        },
                    }).success(function (response) {
                        location.reload();
                    }).fail(function (response) {
                        console.log(response);
                    });
                }
            } else if ($(this).val() == 'preview') {
                $('#preview-form').find('input[name=job_id]').val($(this).attr('job-id'));
                $('#preview-form').find('input[name=enc]').val($(this).attr('data-enc'));
                $('#preview-form').submit();
            }
            $(this).val('');
            return false;
        });
    };

    return {
        init: function () {
            click_add_btn();
            process();
        }
    }
}();

$(function () {
    job.init();
    jobs.init();
});

