$(function() {
    $('.dateform').datepicker({
        dateFormat: "yy-mm-dd"
    });

    $('button[name=filter-clear-btn]').on('click', function()
    {
        window.location.href = window.location.href.replace(/\?.*$/, '');
    });
});
