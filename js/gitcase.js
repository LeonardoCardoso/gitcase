/**
 * Created by leocardz on 03/05/15.
 */

(function ($) {

    $.fn.gitcase = function (options) {

        var allRepos = [];
        var allResults = [];
        var datesArray = {};
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
                    datesArray = {};
                    total = 0;
                    maxCommit = 0;
                    page = 1;
                    currentRepoNumber = 0;

                    buildDatesArray();

                    $.get('github/request.php', {'type': 'user'}, function (res) {

                        $.get(res.url, {'access_token': Cookies.get('access_token')}, function (user) {

                            var totalRepos = parseInt(user.public_repos) + parseInt(user.total_private_repos);

                            getRepositoriesByPage($(this), user, res, totalRepos, allRepos);

                        }, 'json');

                    }, 'json');

                }
            );

        }

        function buildDatesArray() {
            var now = new Date();
            startDate = new Date();
            startDate.setFullYear(startDate.getFullYear() - 1);
            startDate.setDate(startDate.getDate() - 1);
            var nowString = removeMS(now);
            var startDateString = removeMS(startDate);

            while (nowString !== startDateString) {
                datesArray[nowString.substring(0, nowString.indexOf('T'))] = 0;
                var backInTime = now
                backInTime.setDate(backInTime.getDate() - 1);
                nowString = removeMS(backInTime);
            }

            startDate = startDate.toISOString();
        }

        function removeMS(date) {
            date = date.toISOString();
            if (date.indexOf(".") > -1) {
                date = date.substring(0, date.indexOf(".")) + "Z";
            }
            return date;
        }

        function getRepositoriesByPage(btn, user, res, totalAmount, allRepos) {
            $.get(res.repos_url, {
                'access_token': Cookies.get('access_token'),
                'page': page,
                'per_page': itemsPerPage
            }, function (repos) {

                for (var i = 0; i < repos.length; i++) {
                    currentRepoNumber++;
                    allRepos.push(repos[i]);
                }

                if (currentRepoNumber < totalAmount && totalAmount > page * itemsPerPage) {
                    // pagination
                    page++;
                    getRepositoriesByPage(btn, user, res, totalAmount, allRepos);

                } else {
                    // repository list reaches its end
                    gatherStatistics(allRepos, user, 0, allResults, null);

                }

            }, 'json');
        }

        function gatherStatistics(allRepos, user, i, allResults, page) {
            if (i < allRepos.length) {

                $('#currentRepo').html(allRepos[i].name);

                var url = allRepos[i].commits_url.substring(0, allRepos[i].commits_url.indexOf('{'));

                var parameters = {
                    'access_token': Cookies.get('access_token'),
                    'since': startDate,
                    'per_page': 100
                };

                if (page !== null) {
                    parameters['last_sha'] = page;
                }

                $.get(url, parameters, function (res) {

                    if (res.length === 0 || (res.length === 1 && page === res[0].sha)) {
                        // stop pagination
                        i++;
                        lastCommit = null;
                    } else {
                        var lastCommit = res[0].sha;
                        for (var k = 0; k < res.length; k++) {

                            if ((res[k].author !== null && res[k].author.login === user.login)) {

                                if (res[k].commit.author.date.toString() > startDate.toString()) {
                                    updateDateString(res[k].commit.author.date.toString());
                                    total++;
                                }

                            }

                            lastCommit = res[k].sha;

                        }
                    }

                    gatherStatistics(allRepos, user, i, allResults, lastCommit);

                }, 'json');
            } else {

                gatherIssues(0);

            }
        }

        function updateDateString(dateString) {
            dateString = dateString.substring(0, dateString.indexOf('T'));
            datesArray[dateString]++;

            if(maxCommit < datesArray[dateString]){
                maxCommit = datesArray[dateString];
            }
        }

        function gatherIssues(page) {
            $.get('github/request.php', {'type': 'issues'}, function (res) {
                $.get(res.url, {
                    'access_token': Cookies.get('access_token'),
                    'since': startDate,
                    'filter': 'created',
                    'state': 'all',
                    'per_page': 100,
                    'page': page
                }, function (res) {

                    $('#currentRepo').html('');

                    if (res.length === 0) {

                        $.post('github/image.php', {
                            'reposAmount': allRepos.length,
                            'maxCommit': maxCommit,
                            'total': total,
                            'datesArray': datesArray
                        }, function (image) {

                            $('#generate').removeClass('disabled');
                            $('#octal').css({'display': 'none'});
                            $('#share').css({'display': 'inline-block'});
                            $('#download').css({'display': 'inline-block'});

                            var finalResult = $('#finalResult');
                            finalResult.attr('src', image);
                            finalResult.css({'display': 'block'});

                        });
                    } else {

                        for (var k = 0; k < res.length; k++) {
                            if (res[k].updated_at.toString() > startDate.toString()) {
                                updateDateString(res[k].updated_at.toString());
                                total++;
                            }
                        }

                        gatherIssues(++page);
                    }


                }, 'json');
            }, 'json');
        }

    };

})
(jQuery);