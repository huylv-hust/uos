var persons = function () {
    var closed_modal = function () {
        $(document).on('closed', '.remodal', function (e) {
            $('select[name=result]').val(0);
        });
    };

    var submit_modal_employment = function () {
        $(document).on('confirmation', '#employment-modal', function () {
            var day = $('input[name=working_days]').val();
            if (!day) {
                alert('入社日を入力してください');
                return false;
            }
            if (!utility.date_format(day)) {
                alert('入社日が正しくありません');
                return false;
            }
            if (day < $('#employment-form').attr('data-application-date')) {
                alert('応募日より前の日付は指定できません');
                return false;
            }
            if (confirm('確定後は選考結果の変更ができなくなり、ご請求対象となります。よろしいですか？')) {
                $('#employment-form').submit();
            }
        });
    };

    var submit_modal_reject = function () {
        $(document).on('confirmation', '#reject-modal', function () {
            var reject_reason = $('select[name=reject_reason]').val();
            if (!reject_reason) {
                alert('不採用理由を入力してください');
                return false;
            }
            if (confirm('確定後は選考結果の変更ができなくなります。よろしいですか？')) {
                $('#reject-form').submit();
            }
        });
    };

    return {
        init: function () {
            closed_modal();
            submit_modal_employment();
            submit_modal_reject();
        }
    }
}();

$(function () {
    persons.init();
});

