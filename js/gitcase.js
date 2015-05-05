/**
 * Created by leocardz on 03/05/15.
 */

(function ($) {

    $.fn.gitcase = function (options) {

        var allRepos = [];
        var page = 1;
        var currentRepoNumber = 0;
        var itemsPerPage = 100;

        var defaults = {
            action: ''
        };

        var opts = jQuery.extend(defaults, options);

        if (opts.action === 'request') {
            $(this).click(function () {
                $.get('github/request.php', {'type': 'authorize'}, function (res) {
                    window.location = res.url;
                }, 'json');
            });
        } else if (opts.action === 'generate') {
            $(this).click(function () {

                    $(this).attr('disabled', 'disabled');
                    allRepos = [];
                    page = 1;
                    currentRepoNumber = 0;

                    $.get('github/request.php', {'type': 'user'}, function (res) {

                        $.get(res.url, {'access_token': res.access_token}, function (user) {

                            var totalRepos = parseInt(user.public_repos) + parseInt(user.total_private_repos);

                            getPage($(this), res, totalRepos, allRepos);

                        }, 'json');

                    }, 'json');

                }
            );

        }

        function getPage(btn, res, totalAmount, allRepos) {
            $.get(res.repos_url, {
                'access_token': res.access_token,
                'page': page,
                'per_page': itemsPerPage
            }, function (repos) {

                for (var i = 0; i < repos.length; i++) {
                    currentRepoNumber++;
                    allRepos.push(repos[i]);
                }

                if (currentRepoNumber < totalAmount && totalAmount > page * itemsPerPage) {
                    page++;
                    getPage(btn, res, totalAmount, allRepos);
                } else {

                    btn.removeAttr('disabled');

                    for (i = 0; i < allRepos.length; i++) {
                        console.log(allRepos[i]);
                    }
                }

            }, 'json');
        }

    };

})
(jQuery);