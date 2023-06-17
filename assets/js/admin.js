(function($) {
    $(function () {
        $(document).on('click', '.send-test', function () {
            $.post(ajaxurl, {
                '_wpnonce': $('#_wpnonce').val(),
                'action': 'resend_test'
            }, function (response) {

            });
        });
    });
})(jQuery);
