# GitCase

[![Build Status](https://travis-ci.org/LeonardoCardoso/gitcase.svg)](https://travis-ci.org/LeonardoCardoso/gitcase)

Developed by <a href='https://github.com/LeonardoCardoso' target='_blank'>@LeonardoCardoso</a>. 

Sometimes you work only with private repos in GitHub but your public profile is so empty. To solve that issue we've created this.

It's PHPs based project shares the information of all contributions (private and public) as you seen when you are logged in your GitHub profile.

<b>All times are calculated in GMT</b>

## As seen publicly

![Public](http://i.imgur.com/wKe6Swi.png)

## As seen privately

![Complete](http://i.imgur.com/KP009wz.png)

## Important

This API only shows the info, not the data.

## Live Example

You can found it here http://gitcase.leocardz.com

## Important

Create a file in the folder statics named credentials.php and add the following:


    <?php
    $clientID = YOUR CLIENT ID;
    $clientSecret = YOUR CLIENT SECRET;
    $callbackURL = CALLBACK URL YOU REGISTERED YOUR APPLICATION ON GITHUB;


Make sure the library <b>php5-curl</b> and <b>php5-gd</b> are installed and enabled on the server, either locally or remotely. 

- Linux
```bash
$ sudo apt-get install php5-gd php5-curl
$ sudo service apache2 restart
```
- Mac (via [macports](https://www.macports.org/))
```bash
$ sudo port install php5-curl php5-gd 
$ sudo apachectl restart
```


## Statistics

From [Github docs](https://help.github.com/articles/viewing-contributions-on-your-profile-page/):

Whenever you commit to a project's default branch (or the gh-pages branch), open an issue, or propose a Pull Request, we count that as a contribution.
But here we added the contribution in other branches.

- default branch ✓
- other branches
- gists
- gh-pages branch
- open an issue ✓
- pull request ✓


## Limitations

- From [Github docs](https://developer.github.com/v3/#rate-limiting), we have 5,000 requests per hour
- The original GitHub contributions calendar shows a commit even if it's squashed via <i>git rebase</i>. And currently this kind of history is not available on their current API.

## Autoload

To install dependencies via [Composer](http://getcomposer.org), do the following:

```bash
$ curl -s http://getcomposer.org/installer | php
```

```bash
$ php composer.phar install
```


## License

    Copyright 2015 Leonardo Cardoso

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
