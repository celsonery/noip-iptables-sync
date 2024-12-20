# Utility for renew IPTABLES firewall rules writed in PHP - by Celso Nery
A litle PHP script utility for renew IPTABLES firewall rules.

[![Maintainer](http://img.shields.io/badge/maintainer-@celsonery-blue.svg?style=flat-square)](https://twitter.com/celsonery)
[![Latest Version](https://img.shields.io/github/release/celsonery/initials.svg?style=flat-square)](https://github.com/celsonery/noip-iptables-sync/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Requirements
PHP-CLI, SQLITE3 and PHP-SQLITE3

```bash
apt install php-cli sqlite3 php-sqlite3
```

## Installation

Copy the **updateNoIp.php** to **/usr/local/bin/** or another directory do you want.

You can use in CRONTAB or Systemd-timer

In CRONTAB with root
```bash
contrab -e
```
and than add this line if you copied the script to **/usr/local/bin/**

CRONTAB:
```crontab
*/1 * * * * /usr/local/bin/updateNoIp.php
```

SYSTEMD-TIMER:
- copy update-noip.server and update-noip.timer to **/lib/systemd/system**
- create a link into **/etc/systemd/system/timers.target.wants/**
- run **systemctl daemon-reload** command

You can see with **systemctl list-timers** command


The script will create the SQLite database and then you must insert your noip hostname and external ip into this database.

You also edit your iptables rules into script and in your iptables firewall.

In script there are those iptables rules. Change for your needs.

```bash
system('iptables -t nat -D PREROUTING -p tcp --dport 5432 -s ' . $row['ip'] . ' -j DNAT --to-dest 192.168.121.250');
system('iptables -t nat -A PREROUTING -p tcp --dport 5432 -s ' . $ip . ' -j DNAT --to-dest 192.168.121.250');
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Support

###### Security: If you discover any security related issues, please email celso.nery@gmail.com instead of using the issue tracker.

Thank you

## Credits

- [Celso Nery](https://github.com/celsonery) (Maintainer/Developer)
- [All Contributors](https://github.com/celsonery/noip-iptables-sync/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
