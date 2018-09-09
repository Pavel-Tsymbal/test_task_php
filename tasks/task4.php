<?php

/**
 * function for getting connection with database
 * @param array $config
 * @return PDO
 */
function connectDb(array $config) :PDO
{
    $mysql = $config['mysql'];
    $dsn = $mysql['driver'] . ':host=' . $mysql['host'] . ';dbname=' . $mysql['db_name'];
    $user = $mysql['user'];
    $password = $mysql['password'];
    $db = new PDO($dsn, $user,$password);

    return $db;
}

/**
 * function for getting user data
 * @param $user_ids
 * @param PDO $db
 * @return mixed
 */
function load_users_data(string $user_ids,PDO $db) :array
{
    $ids = explode(',', $user_ids);
    $sql = 'SELECT * FROM users WHERE id IN ('.str_repeat('?,', count($ids) - 1) . '?'.')';
    $sth = $db->prepare($sql);
    $sth->execute($ids);
    $usersData = $sth->fetchAll(PDO::FETCH_OBJ);

    $data = [];

    if (empty($usersData)) {
        return [];
    }

    foreach ($usersData as $userData) {
        $data[$userData->id] = $userData->name;
    }

    return $data;
}

$db_config = include_once __DIR__ . '../conf/db_conf.php';
$dbConnect = connectDb($db_config);

if (!empty($_GET['user_ids'])) {
    $data = load_users_data($_GET['user_ids'],$dbConnect);
    foreach ($data as $user_id => $name) {
        echo " <a href=\"/show_user.php?id=$user_id\">$name</a>";
    }
}


// 1) Оптимизация. Не за чем для каждого объекта слать отдельный запрос, мы можем получить все объекты одним запросом.
// 2) Вынес подключение к базе в отдельную функцию которая принимает конфигурацию.
// 3) Через mysql_connect не стоит работать с базой, потому что можно допустить sql инъекции, лучше использовать PDO.

