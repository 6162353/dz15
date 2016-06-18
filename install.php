<?php
/*
  Скрипт установки дампа в сервер баз данных.
  В базе всё должно быть очищено.
  Если всё успешно - появляется ссылка на сайт
  Если не успешно - сообщать пользователю.
 */

$debug = 1;

if (0) {
    echo '<p>PHP_OS=';
    echo PHP_OS;
    echo '</p>';
}

if (PHP_OS == 'WINNT') {

    $end_of_file = "\r\n";
} else if (PHP_OS == 'Linux') {

    $end_of_file = "\n";
}


header('Content-type: text/html; charset=utf-8');
if (count($_POST)) {

    if (!$debug) {
        echo '<p>$_POST= <br>';
        var_dump($_POST);
        echo '</p>';
    }

    $server_name = $_POST['server_name'];
    $user_name = $_POST['user_name'];

    $database = $_POST['database'];
    $password = $_POST['password'];

    $data_h = fopen('data.txt', 'w');
    fwrite($data_h, 'server_name=' . $server_name . $end_of_file);
    fwrite($data_h, 'user_name=' . $user_name . $end_of_file);
    fwrite($data_h, 'database=' . $database . $end_of_file);
    fwrite($data_h, 'password=' . $password . $end_of_file);
    fclose($data_h);

    // делание дампа моей БД

    if ($server_name != '' and $user_name != '' and $database != '') {
        $db_user = 'dz9';
        $db_name = 'dz9';
        $db_server = 'localhost';

        if (PHP_OS == 'WINNT') {
            
            exec('C:\WebServers\usr\local\mysql-5.5\bin\mysql --user=' . 
                    $user_name . ' --password=' . $password . ' --host=' . 
                    $server_name . ' --database=' . $database . ' < dz9.sql', 
                    $output, $return);

        } else if (PHP_OS == 'Linux') {

            exec('mysql --user=' . $user_name . ' --password=' . 
                    $password . ' --host=' . $server_name . ' ' . 
                    $database . ' < dz9.sql');

        }

//echo 'Дамп сделан';
        // Очищение БД данной пользователем

        $conn = mysql_connect($server_name, $user_name, $password)
                or die("Невозможно установить соединение: " . mysql_error());
        mysql_select_db($database) or die('Проблемы с указанной базой данных: ' . mysql_error());
        $query = 'show tables;';
        $result_query = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
        if (!$debug) {
            echo '<p>$result_query= <br>';
            var_dump($result_query);
            echo '</p>';

            // $result_query=resource(3, mysql result)
        }

        while ($result = mysql_fetch_row($result_query)) {

            if (!$debug) {
                echo '<p>$result= <br>';
                var_dump($result);
                echo '</p>';

                /* $result=
                  array (size=1)
                  0 => string 'categories' (length=10)
                  $result=
                  array (size=1)
                  0 => string 'cities' (length=6)
                  $result=
                  array (size=1)
                  0 => string 'subcategories' (length=13)
                  $result=
                  array (size=1)
                  0 => string 'tube_stations' (length=13)
                 */
            }

            $tables[] = $result[0];
        }

        if (!$debug) {
            echo '<p>$tables= <br>';
            var_dump($tables);
            echo '</p>';

            /* $tables=
              array (size=4)
              0 => string 'categories' (length=10)
              1 => string 'cities' (length=6)
              2 => string 'subcategories' (length=13)
              3 => string 'tube_stations' (length=13)
             */
        }

        // Удаление таблиц, если они есть

        if ($tables) {
            while ($table = array_pop($tables)) {
                $query = 'drop table ' . $table . ';';


                if (!$debug) {
                    echo '<p>$query= <br>';
                    var_dump($query);
                    echo '</p>';

                    /*
                      $query=
                      string 'drop table tube_stations;' (length=25)
                      $query=
                      string 'drop table subcategories;' (length=25)
                      $query=
                      string 'drop table cities;' (length=18)
                      $query=
                      string 'drop table categories;' (length=22)
                     */
                }



                $result_query = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
            }
        }


        // Заливаем Базу Данных


        exec('mysql --user=' . $user_name . ' --password=' . $password . ' --host=' . $server_name . ' ' . $database . ' < dz9.sql');
        echo 'Дамп восстановлен. <a href="http://localhost/test/dz15.php">http://localhost/test/dz15.php</a>';



        mysql_close($conn);
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Скрипт восстановления БД</title>
    </head>

    <body>
        <form method="POST">
            <p><b>Server name:</b><br>
                <input type="text" name='server_name' size="20" value='localhost'>
            </p>
            <p><b>User name:</b><br>
                <input type="text" name='user_name' size="20">
            </p>
            <p><b>Password:</b><br>
                <input type="text" name='password' size="20">
            </p>
            <p><b>Database:</b><br>
                <input type="text" name='database' size="20">
            </p>
            <p><input type="submit" value="Install">

            </p>
        </form>      


    </body>
</html>