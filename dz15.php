<?php

include 'dz15_logic.php';


$smarty->assign('checkedPrivate', $values_for_form['checkedPrivate']);
$smarty->assign('checkedCompany', $values_for_form['checkedCompany']);
$smarty->assign('seller_name', $values_for_form['seller_name']);
$smarty->assign('email', $values_for_form['email']);
$smarty->assign('checked_allow_mails', $values_for_form['allow_mails']);
$smarty->assign('phone', $values_for_form['phone']);
$smarty->assign('selected', $selected);
$smarty->assign('cities', $cities);
$smarty->assign('location_id', $values_for_form['location_id']);
$smarty->assign('tube_stations', $tube_stations);
$smarty->assign('tube_station_id', $values_for_form['tube_station_id']);
$smarty->assign('categories', $categories);
$smarty->assign('category_id', $values_for_form['category_id']);
$smarty->assign('title', $values_for_form['title']);
$smarty->assign('description', $values_for_form['description']);
$smarty->assign('price', $values_for_form['price']);
$smarty->assign('post_edit', $values_for_form['post_edit']);
$smarty->assign('amount_ads', $amount_ads);
$smarty->assign('temp_array', $temp_array);
$smarty->assign('current_php_script', $current_php_script);
$smarty->assign('site_dir', $site_dir);


$smarty->display('oop.tpl');

//var_dump($main);

?>