/**
 * Created by leocardz on 03/05/15.
 */

(function ($) {

    $.fn.gitcase = function (options) {

        $(this).click(function () {
            $.post("oauth", {}, function (data) {
                console.log(data);
            }).done(function () {
                console.log("got");
            }).fail(function () {
                console.log("error");
            }).always(function () {
                console.log("finished");
            });
        });

    };

})(jQuery);