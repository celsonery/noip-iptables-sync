#!/usr/bin/php

<?php
$database = '/usr/local/bin/database.sqlite';

function initdb()
{
    global $database;
    $dsn = "sqlite:$database";

    $statements = 'CREATE TABLE IF NOT EXISTS `noip` (id INTEGER PRIMARY KEY AUTOINCREMENT, url STRING, ip STRING)';

    try {
        $pdo = new \PDO($dsn);
        $pdo->exec($statements);
        echo "Database connected successfully\n";
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . "\n";
        return false;
    }
}

function updateIp()
{
    if ($pdo = initdb()) {
        foreach ($pdo->query('SELECT * FROM `noip`') as $row) {
            $ip = gethostbyname($row['url']);
            if ($ip != $row['ip']) {
                echo "Updating IP {$row['url']} from {$row['ip']} {$ip}\n";

                $pdo->exec("UPDATE `noip` SET `ip` = '$ip' WHERE `id` = $row[id]");
                system('iptables -t nat -D PREROUTING -p tcp --dport 5432 -s ' . $row['ip'] . ' -j DNAT --to-dest 192.168.121.250');
                system('iptables -t nat -A PREROUTING -p tcp --dport 5432 -s ' . $ip . ' -j DNAT --to-dest 192.168.121.250');
            }
        }
    }
}

updateIp();
