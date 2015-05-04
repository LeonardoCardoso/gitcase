/**
 * Created by leocardz on 03/05/15.
 */

(function ($) {

    $.fn.gitcase = function (options) {

        var defaults = {
            action: ""
        };

        var opts = jQuery.extend(defaults, options);

        if (opts.action === "request") {
            $(this).click(function () {
                $.get('github/request.php', {}, function (res) {
                    window.location = res.url;
                }, "json");
            });
        } else if (opts.action === "generate") {
            $(this).click(function () {
                $.get('github/generate.php', {}, function (res) {
                    console.log(res);
                }, "json");
            });
        }

    };

})(jQuery);