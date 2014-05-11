proxypool-simplestats
=====================

This is quick and dirty mashup of php code to get some info from p2proxy (VTC/MON version) database and show it to users.

Bootstrap support added by https://github.com/darrenturn90/

Beautification of main page by TheoRettish http://mon.qemulab.com/


INSTALLATION
============

First you need to download this repositoty to location, where apache or some other web server can reach it.

Then copy *./include/config.example.php* to **./include/config.php** and set all needed values.


Set scheduler to run ./bin/tx.php ./bin/active.php and ./bin/unpaid.php
Something like

```
* * * * * cd /var/www/proxypool/bin; /usr/bin/php /var/www/proxypool/bin/active.php
*/5 * * * * cd /var/www/proxypool/bin; /usr/bin/php /var/www/proxypool/bin/unpaid.php; /usr/bin/php /var/www/proxypool/bin/tx.php
```

in crontab works.

Check that mysql is set to your local timezone.

```
mysql -u proxypool -p
select foundtime, now() from stats_shares order by foundtime desc limit 1;
```

If those 2 values are really close (few seconds apart) you should be ok, otherwise set your timezone of mysql to your local. If your mysql timezone and system timezone does not match, you will probably not get any data in active users category.

Now you should be able to view stats from browser at http://yourhost.com/proxypool/

In *config.php* you can setup **announcement** to True and write text of it in **./include/announcement.html**. It will be displayed over the last 5 minute table.

Make sure you have support for **json**. **apt-get install php5-json** should make it work (depends on your distribution)

OTHER STUFF
===========

You can check out how this stuff works at http://whatever.kn.vutbr.cz/proxypool/

If you feel the need to contact me, /msg Cooba at #vertcoin on freenode.

Some dust sent to my wallets is welcome xD

VTC: Vt39dQgGN6oJpycARRHRtGVrz1nngjaV7b

MON: MDbTCpvBsMuSBfGRHi4NT8cD5EH1uE9qCa

Link to this repo and those two addresses was added to footer of the page. If you want to remove it, feel free to do so.

DISCLAMER
=========

Read the License ;) 
