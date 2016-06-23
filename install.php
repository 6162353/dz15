<?php
/*
  Скрипт установки дампа в сервер баз данных.
  В базе всё должно быть очищено.
  Если всё успешно - появляется ссылка на сайт
  Если не успешно - сообщать пользователю.
 */

$debug = 1;
header('Content-type: text/html; charset=utf-8');


if (PHP_OS == 'WINNT') {

    $end_of_file = "\r\n";
} else if (PHP_OS == 'Linux') {

    $end_of_file = "\n";
}

$config_h = fopen('config.txt', 'r');
$config = array();

while ($config_row = fgetcsv($config_h, 0, '=')) {

    $config[$config_row[0]] = $config_row[1];
}

if (0) {

    echo 'var_dump(config)=' . var_dump($config);
}

$project_root = $config['project_root'];
$site_dir = $config['site_dir'];
$current_php_script = $config['current_php_script'];

if (0) {
    echo '<br>$project_root=' . $project_root;
    echo '<br>$site_dir=' . $site_dir;
    echo '<br>$current_php_script=' . $current_php_script;
}

fclose($config_h);



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

    if ($server_name != '' and $user_name != '' and $database != '') { 
    
        // Очищение БД данной пользователем
      
        $conn = mysqli_connect($server_name, $user_name, $password, $database)
                or die("Невозможно установить соединение: " . mysqli_error($conn));
        $query = 'show tables;';
        $result_query = mysqli_query($conn,$query) or die('Запрос не удался: ' . mysql_error());
        if (!$debug) {
            echo '<p>$result_query= <br>';
            var_dump($result_query);
            echo '</p>';

            // $result_query=resource(3, mysql result)
        }

        while ($result = mysqli_fetch_row($result_query)) {

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



                $result_query = mysqli_query($conn,$query) or die('Запрос не удался: ' . mysql_error());
            }
        }


        // Заливаем Базу Данных
        /*
        if (PHP_OS == 'WINNT') {

            exec('C:\WebServers\usr\local\mysql-5.5\bin\mysql --user=' .
                    $user_name . ' --password=' . $password .
                    ' --host=' . $server_name . ' --database=' .
                    $database . ' < dz9.sql', $output, $return);
            if ($return) {
                throw new Exception("Unable to restore dump with exit code: $return");
            }
            //  //exec('calc',$output,$return);
            
        } else if (PHP_OS == 'Linux') {

            exec('mysql --user=' . $user_name . ' --password=' . $password .
                    ' --host=' . $server_name . ' ' . $database . ' < dz9.sql', $output, $return);

            if (0) {
                echo '<br>$return=' . $return;
            }

            if (0) {
                echo '<br>$password=' . $password;
            }

            if ($return) {
                throw new Exception("Unable to restore dump with exit code: $return");
            }
        }
         * 
         */
        
        $data_sql = file_get_contents('dz9.sql');
        $result_query = mysqli_multi_query($conn,$data_sql) or die('Запрос не удался: ' . mysql_error());
            
        
        //echo 'Дамп восстановлен. <a href="./'. $current_php_script . '"visit page</a>';
        echo 'Дамп восстановлен. <a href="./dz15.php">visit page</a>';


        mysqli_close($conn);
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