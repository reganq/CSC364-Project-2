<?php
function get_db() {
    static $db = null;
    $db_file = '/var/www/html/data.db';

    if ($db === null) {
        $first = !file_exists($db_file);
        $db = new PDO('sqlite:' . $db_file);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if ($first) {
            $db->exec(file_get_contents(__DIR__ . '/init.sql'));
        }
    }
    return $db;
}
