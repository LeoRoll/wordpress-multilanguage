/* <![CDATA[ */
var clearpath = assanSettings.clearpath,
        assan_saving_text = assanSettings.assan_saving_text,
        ctassan_data_saved_text = assanSettings.ctassan_data_saved_text;

jQuery(document).ready(function() {
    var $display_message = jQuery("#options-ajax-saving");

    jQuery('input#assan_save').click(function($) {
        var options_fromform = jQuery('#main_options_form').formSerialize(),
                add_nonce = '&_ajax_nonce=' + assanSettings.assan_nonce;

        options_fromform += add_nonce;
        var save_button = jQuery(this);
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: options_fromform,
            beforeSend: function(xhr) {
                $display_message.children("img").css("display", "block");
                $display_message.children("span").css("margin", "6px 0px 0px 30px").html(assan_saving_text);
                $display_message.fadeIn('fast');
            },
            success: function(response) {
                $display_message.children("img").css("display", "none");
                $display_message.children("span").css("margin", "0px").html(ctassan_data_saved_text);

                save_button.blur();

                setTimeout(function() {
                    $display_message.fadeOut("slow");
                }, 500);
            }
        });

        return false;
    });
});
/* ]]> */