<?php

$project_root = $_SERVER['DOCUMENT_ROOT'];

$debug_paths = 0; 

if ($debug_paths) {
    echo 'project_root=' . $project_root;
}

$dir = __DIR__;

if ($debug_paths) {
    echo '<br>dir=' . $dir;

    echo '<br>__FILE__=' . __FILE__;
}

//echo '<br>var_dump(strpbrk($dir,\)';
//var_dump(strpbrk($project_root, '\\'));

if (strpbrk($dir, '\\')) {

    $project_root_a = explode('/', $project_root);

    if ($debug_paths) {
        echo '<br>var_dump($project_root_a=';
        var_dump($project_root_a);
    }

    $project_root = implode('\\', $project_root_a);
}

if ($debug_paths) {
    echo '<br>project_root=' . $project_root;
}

$site_path = str_replace($project_root, '', __FILE__);

if ($debug_paths) {
    echo '<br>site_path=' . $site_path;
}

$current_php_script = basename($site_path);

$site_dir = str_replace( $current_php_script, '', $site_path);

if ($debug_paths) {
    echo '<br>site_dir=' . $site_dir;
}

$current_php_script = basename($site_path, '_logic.php') . '.php';


if ($debug_paths) {
    echo '<br>current_php_script=' . $current_php_script;
}

//echo $current_php_script;


$smarty_dir = $project_root . $site_dir . 'smarty/';

require_once $project_root . $site_dir .'dbsimple/lib/config.php';
require_once $project_root . $site_dir .'dbsimple/lib/DbSimple/Generic.php';

require_once $project_root . $site_dir .'FirePHPCore/FirePHP.class.php';

require_once 'Ad.class.php';
require_once 'functions.php';

$firePHP = FirePHP::getInstance(true);

$firePHP->setEnabled(false);



// put full path to Smarty.class.php
require($smarty_dir . 'libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;



$smarty->template_dir = $smarty_dir . 'templates';
$smarty->compile_dir = $smarty_dir . 'templates_c';
$smarty->cache_dir = $smarty_dir . 'cache';
$smarty->config_dir = $smarty_dir . 'configs';

header('Content-type: text/html; charset=utf-8');

if (file_exists('data.txt')) {

//считываем данные о подключении к бд из файла

    $data_h = fopen('data.txt', 'r');
    $data = array ();
    
    while ($data_row = fgetcsv($data_h, 0, '=')) {
        
        $data[$data_row[0]] = $data_row[1];
        
    }
    
    if (0) {
        
        echo 'var_dump(data)=' . var_dump($data);
        
    }
    
    $db_user = $data['user_name'];
    $db_pass = $data['password'];
    $db_name = $data['database'];
    $db_server = $data['server_name'];
    
    if (0) {
        echo '<br>$db_user=' . $db_user;
        echo '<br>$db_user=' . $db_pass;
        echo '<br>$db_user=' . $db_name;
        echo '<br>$db_user=' . $db_server;
        
    }
    
    fclose($data_h);
    
    
    } else {
        
        header('Location:install.php'); 

}


$values_for_form = array('title' => '', 'price' => '0',
        'seller_name' => '', 'email' => '', 'phone' => '',
        'description' => '', 'location_id' => '641780', 'metro_id' => '',
        'category_id' => '', 'private' => '', 'allow_mails' => '',
    'checkedPrivate' => 'checked', 'checkedCompany' => '',
    'post_edit' => '0');


$seller_name = "";
$checkedPrivate = 'checked';
$checkedCompany = '';
$post_edit = 0;
$email = '';
$checked_allow_mails = '';
$phone = $title = $description = '';
$selected = 'selected=""';
$location_id = '641780';
$price = '0';
$cities = array();
$tube_stations = array();
$categories = array();


$amount_ads = 0;


//$db_user = 'dz9';
//$db_pass = 'dz9';
//$db_name = 'dz9';
//$db_server = 'localhost';

$db = DbSimple_Generic::connect('mysqli://' . $db_user . ':' . $db_pass . '@' . $db_server . '/' . $db_name);
$db->setErrorHandler('databaseErrorHandler');
$db->setLogger('myLogger');

getCity();

getMetro();

$tube_station_id = '';
$category_id = '';

getCategories();


// если гет заполнен, значит запросили изменение (в ходе просмотра) и удаление

//global $main;


$main = AdsStore::instance();
$main->getAllAdsFromDb();
$main->writeOutAll();




    if ($_POST['form'] == "Сохранить объявление") {
// сохранить элемент
// записать изменение в базу


        //$temp_array = $Ads1->change_ad($db, $_POST, $_GET["id"]);

        //$firePHP->log($temp_array, 'ads $temp_array');

        $main->change_Ad($_GET['id']);

        //var_dump($_GET);
        header('Location:' . $site_dir . $current_php_script);
    }
    
    if ($_POST['form'] == "Назад") {

        header('Location:' . $site_dir . $current_php_script);
    }





if (isset($_GET["id"])) {
    
    if (isset($_GET["del"])) {

        $main->delete_ad($_GET["id"]);


        //$firePHP->log($temp_array, 'ads $temp_array');


        //header('Location:' . $site_dir . $current_php_script);
    }
    
    if (isset($_GET["edit"])) {

        
        $main->writeOutOne($_GET['id']);
        //$post_edit = 1;
        
        //$ad->edit($_GET['id']);
        
        
    }
    
    
}

elseif (count($_POST)) {
    if (isset($_POST['main_form'])) {
        if ($_POST['main_form'] == 'Добавить') {
            
        $ad=new BasicAd($_POST);

    
        $ad->save();
        //var_dump($ad);
        }
        
        
       
     }
    $main->getAllAdsFromDb(); 
    $main->writeOutAll(); 
     
}


function getCity() {
    
    global $db;
    global $cities;
    global $firePHP;
    
    /* ГОРОД */

    $result = $db->select('select * from cities order by id ASC');


    foreach ($result as $value) {

        $cities[$value['city']] = $value['id'];
    }

    $firePHP->log($cities, '$cities');
}



function getMetro() {
    
    global $db;
    global $tube_stations;
    global $firePHP;


    /* МЕТРО $tube_stations  */

    $result = $db->select('select * from tube_stations order by tube_station ASC');

    foreach ($result as $value) {

        $tube_stations[$value['tube_station']] = $value['id'];
    }


    $firePHP->log($tube_stations, '$tube_stations');
}

function getCategories() {
    
        global $db;
    global $categories;
    global $firePHP;

    $result = $db->select('select * from categories order by id ASC');
    $firePHP->log($result, 'categories $result');

    foreach ($result as $value) {

        $result2 = $db->select('select * from subcategories where category=' . $value['id'] . ' order by subcategory');
        $firePHP->log($result2, 'subcategories $result2');

        foreach ($result2 as $value2) {

            $subcategory[$value2['subcategory']] = $value2['id'];
        }


        $categories[$value['category']] = $subcategory;
        $subcategory = array();
    }

    $firePHP->log($categories, '$categories');
}





?>


