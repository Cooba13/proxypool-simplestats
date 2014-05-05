proxypool-simplestats
=====================

This is quick and dirty mashup of php code to get some info from p2proxy (VTC/MON version) database and show it to users.

Bootstrap support added by https://github.com/darrenturn90/


INSTALLATION
===========

First you need to download this repositoty to location, where apache or some other web server can reach it. Then copy ./include/config.example.php to ./include/config.php and set all needed values.
Set scheduler to run ./bin/tx.php ./bin/active.php and ./bin/unpaid.php
Something like

```
* * * * * cd /var/www/proxypool/bin; /usr/bin/php /var/www/proxypool/bin/active.php

*/5 * * * * cd /var/www/proxypool/bin; /usr/bin/php /var/www/proxypool/bin/unpaid.php; /usr/bin/php /var/www/proxypool/bin/tx.php
```

in crontab works.

Don't forget to edit text in ./index.php so it points to your p2pool node, proxystats and timezone.

Now you should be able to view stats from browser at http://yourhost.com/proxypool/


OTHER STUFF
===========

You can check out how this stuff works at http://whatever.kn.vutbr.cz/proxypool/

If you feel the need to contact me, /q Cooba at #vertcoin on freenode.

Some dust sent to my wallets is welcome xD

VTC: Vt39dQgGN6oJpycARRHRtGVrz1nngjaV7b

MON: MDbTCpvBsMuSBfGRHi4NT8cD5EH1uE9qCa


DISCLAMER
=========

Read the License ;) 
