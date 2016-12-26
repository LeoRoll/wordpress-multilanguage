jQuery(document).ready(function ($) {
    $('.assan_upload_button').click(function () {
        var strInputID = $(this).attr('input-data');
        assan_tb_interval = setInterval(function () {
            $('#TB_iframeContent').contents().find('.savesend .button').val('Use this image');
        }, 200);
        tb_show('Upload Image', 'media-upload.php?type=image&amp;TB_iframe=true');
        window.send_to_editor = function (html) {
            imgurl = $('img', html).attr('src');
            $('#' + strInputID).val(imgurl);
            tb_remove();
        };
        return false;
    });
    $("#assan_tabs").jVertTabs();
});

jQuery(document).ready(function ($) {
    'use strict',
            $('#post-formats-select input').change(checkFormate);
    function checkFormate() {
        var formate = $('#post-formats-select input:checked').attr('value');
        if (typeof formate != 'undefined') {
            $('div[class^=assan-post-meta-]').hide();
            $('div[class^=assan-post-meta-' + formate + ']').stop(true, true).fadeIn(600);
            if (formate == 'audio' || formate == 'video') {
                $('#assan_meta_boxes_post').stop(true, true).fadeIn(600);
            }
            else {
                $('#assan_meta_boxes_post').hide();
            }
        }
    }
    $(window).load(function () {
        'use strict',
                checkFormate();
    })

});