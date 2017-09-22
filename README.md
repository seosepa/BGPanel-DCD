# Bright Gamepanel config generator 
Basic config generation with twig templates and variables from BGPanel Database.

##### Workings:
`php configGetter.php` does a request to the index.php of the generator.<br>
DCD checks the RemoteADDR of the request and links a BGPanel Box.<br>
DCD returns a json encoded string with all the configfiles + paths

##### Generator system requirements:

* PHP 7.0 or higher + Composer

##### Deployment system requirements:

* PHP 5.6 or higher
* Debian/Ubuntu (cronjob command)


## Config generator (DCD)

* git clone this repo
* run `composer update`
* set vhost root to the index.php

Edit src/BGPanel/Db.php

set the Mysql credentials to the BGPanel Database


## Automatic Deployment to gameservers
Running the ConfigGetter in cronjob to fetch and apply the latest configs

Edit ConfigGetter.php

`private static $dcdConfigUrl = ''` to the URL the configGenerator is unning 

Add CronJob:

`* * * * * flock -n /tmp/dcd-deployment.lock -c "/usr/bin/php /home/game/BGPanel-DCD >> /var/log/dcd-configgetter.log 2>&1"`

