/**
 * Created by leocardz on 03/05/15.
 */

(function ($) {

    $.fn.gitcase = function (options) {

        var allRepos = [];
        var allResults = [];
        var total = 0;
        var maxCommit = 0;
        var page = 1;
        var currentRepoNumber = 0;
        var itemsPerPage = 100;
        var startDate = new Date();

        var defaults = {
            action: ''
        };

        var opts = jQuery.extend(defaults, options);

        if (opts.action === 'download') {
            $(this).click(function () {
                $.post('github/save.php', {'file': $('#finalResult').attr('src')}, function (res) {
                    window.location = "github/download.php?file=" + res.name;
                }, 'json');
            });
        } else if (opts.action === 'request') {
            $(this).click(function () {
                $.get('github/request.php', {'type': 'authorize'}, function (res) {
                    window.location = res.url;
                }, 'json');
            });
        } else if (opts.action === 'generate') {
            $(this).click(function () {

                    $('#generate').addClass('disabled');
                    $('#octal').css({'display': 'block'});
                    $('#share').css({'display': 'none'});
                    $('#download').css({'display': 'none'});

                    var finalResult = $('#finalResult');
                    finalResult.css({'display': 'none'});
                    finalResult.attr('src', '');

                    allRepos = [];
                    allResults = [];
                    total = 0;
                    maxCommit = 0;
                    page = 1;
                    currentRepoNumber = 0;

                    startDate = new Date();
                    startDate.setFullYear(startDate.getFullYear() - 1);
                    startDate = startDate.toISOString();
                    if (startDate.indexOf(".") > -1) {
                        startDate = startDate.substring(0, startDate.indexOf(".")) + "Z";
                    }

                    $.get('github/request.php', {'type': 'user'}, function (res) {

                        $.get(res.url, {'access_token': res.access_token}, function (user) {

                            var totalRepos = parseInt(user.public_repos) + parseInt(user.total_private_repos);

                            getPage($(this), user, res, totalRepos, allRepos);

                        }, 'json');

                    }, 'json');

                }
            );

        }

        function getPage(btn, user, res, totalAmount, allRepos) {
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
                    getPage(btn, user, res, totalAmount, allRepos);

                } else {

                    gatherStatistics(allRepos, user, 0, allResults, null);

                }

            }, 'json');
        }

        function gatherStatistics(allRepos, user, i, allResults, page) {
            if (i < allRepos.length) {

                $('#currentRepo').html(allRepos[i].name);


                var url = allRepos[i].commits_url.substring(0, allRepos[i].commits_url.indexOf('{'));
                console.log(url);

                var parameters = {
                    'access_token': Cookies.get('access_token'),
                    'since': startDate,
                    'per_page': 100
                };

                if (page !== null) {
                    parameters['last_sha'] = page;
                }

                console.log('page ' + page);
                $.get(url, parameters, function (res) {

                    //console.log(allRepos[i]);
                    console.log(res);

                    if (res.length === 0 || (res.length === 1 && page === res[0].sha)) {
                        i++;
                        lastCommit = null;
                    } else {
                        var lastCommit = res[0].sha;
                        for (var k = 0; k < res.length; k++) {

                            if ((res[k].author !== null && res[k].author.login === user.login)) {

                                if (res[k].commit.author.date.toString() > startDate.toString()) {
                                    console.log(res[k].commit.author.date);
                                    total++;
                                }

                            }

                            lastCommit = res[k].sha;

                        }
                    }

                    gatherStatistics(allRepos, user, i, allResults, lastCommit);

                }, 'json');
            } else {

                $('#currentRepo').html('');

                for (var k = 0; k < allResults.length; k++) {
                    for (var j = 0; j < allResults[k].days.length; j++) {
                        if (allResults[k].days[j] > maxCommit) {
                            maxCommit = allResults[k].days[j];
                        }
                    }
                }

                $.get('github/image.php', {
                    'reposAmount': allRepos.length,
                    'maxCommit': maxCommit,
                    'total': total
                }, function (image) {

                    $('#generate').removeClass('disabled');
                    $('#octal').css({'display': 'none'});
                    $('#share').css({'display': 'inline-block'});
                    $('#download').css({'display': 'inline-block'});

                    var finalResult = $('#finalResult');
                    finalResult.attr('src', image);
                    finalResult.css({'display': 'block'});

                    //console.log("allResults");
                    //console.log(allResults);
                });
            }
        }

    };

})
(jQuery);