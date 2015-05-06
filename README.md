# GitCase (Under Development)

[![Build Status](https://travis-ci.org/LeonardoCardoso/gitcase.svg)](https://travis-ci.org/LeonardoCardoso/gitcase)

Developed by <a href='https://github.com/LeonardoCardoso' target='_blank'>@LeonardoCardoso</a>. 

Sometimes you work only with private repos in GitHub but your public profile is so empty. To solve that issue we've created this.

It's PHPs based project shares the information of all contributions (private and public) as you seen when you are logged in your GitHub profile.

## As seen publicly

![Public](https://dl.dropbox.com/s/tm18kcwcuymahxd/gitshare_public.png)

## As seen privately

![Complete](https://dl.dropbox.com/s/x94mj50kpfdwnph/gitshare.png)

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


Make sure the library php5-curl is installed and enabled on the server whether local or at webspace. 

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
