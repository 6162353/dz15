<?php

class BasicAd {

//private static $instance = NULL;

    private $id;
    private $title;
    private $price;
    private $user_name;
    private $email;
    private $tel;
    private $descr;
    private $id_city;
    private $id_tube_station;
    private $id_subcategory;
    private $private;
    private $send_to_email;

    public function __construct($ad) {

        if (isset($ad['id'])) {

            $this->id = $ad['id'];
        }

        
        if (isset($ad['title'])) {

            $this->title = $ad['title'];
        }
        
        
        $this->user_name = $ad['seller_name'];
        
        if (isset($ad['seller_name'])) {

            $this->user_name = $ad['seller_name'];
        }
        
        elseif (isset($ad['user_name'])) {
            
            $this->user_name = $ad['user_name'];
            
        }
        else {
            
            $this->user_name = '';
            
        }
        
        
        
        if (isset($ad['price'])) {

            $this->price = $ad['price'];
        } else {

            $this->price = '0';
        }
        
        

        if (isset($ad['email'])) {

            $this->email = $ad['email'];
        } else {

            $this->email = '';
        }
        
        if (isset($ad['tel'])) {

            $this->tel = $ad['tel'];
        } 
        elseif (isset($ad['phone'])) {
            
            $this->tel = $ad['phone'];
            
        }
        
        else {

            $this->tel = '';
        }

        if (isset($ad['descr'])) {

            $this->descr = $ad['descr'];
        } 
        elseif (isset($ad['description'])) {
            
            
            $this->descr = $ad['description'];
        }
        
        else {

            $this->descr = '';
        }
        
        
        if (isset($ad['id_city'])) {

            $this->id_city = $ad['id_city'];
        } else {

            $this->id_city = '641780';
        }
        
        if (isset($ad['id_tube_station'])) {

            $this->id_tube_station = $ad['id_tube_station'];
        }
        
        elseif (isset($ad['metro_id'])) {
            
            
            $this->id_tube_station = $ad['metro_id'];
        }
        
        else {

            $this->id_tube_station = '';
        }
        
        
        if (isset($ad['id_subcategory'])) {

            $this->id_subcategory = $ad['id_subcategory'];
        }
                
        elseif (isset($ad['category_id'])) {
            
            
            $this->id_subcategory = $ad['category_id'];
        }
        
        else {

            $this->id_subcategory = '';
        }       
        
        if (isset($ad['private'])) {

            $this->private = $ad['private'];
        } else {

            $this->private = '';
        }          
        
        
        if (isset($ad['allow_mails'])) {

            $this->send_to_email = $ad['allow_mails'];
        }
        
        elseif (isset($ad['send_to_email'])) {

            $this->send_to_email = $ad['send_to_email'];
        }
        
        else {
            
            $this->send_to_email = '';
            
        }
        
        
        
    }
    
    
    public function edit($vars) {

        global $db;
        
        
        $db->query('REPLACE INTO ads (?#) VALUES(?a)', array_keys($vars), array_values($vars));
        
        
        $this->title = $vars['title'];
        $this->price = $vars['price'];
        $this->user_name = $vars['user_name'];
        $this->email = $vars['email'];
        $this->tel = $vars['tel'];
        $this->descr = $vars['descr'];
        $this->id_city = $vars['id_city'];
        $this->id_tube_station = $vars['id_tube_station'];
        $this->id_subcategory = $vars['id_subcategory'];
        $this->private = $vars['private'];
        
        
        
    }
    
    public function delete($id) {

        global $db;
        
        
        $db->query('delete from ads where ads.id=?', $id);
                
    }
    

    public function save() {

        global $db;
        $vars = get_object_vars($this);
        //var_dump($this);
        $db->query('REPLACE INTO ads(?#) VALUES(?a)', array_keys($vars), array_values($vars));
    }
    
    public function getId() {
        
        return $this->id;
        
    }
    
    public function getTitle() {
        
        return $this->title;
        
    }
    
    public function getUserName() {
        
        return $this->user_name;
        
    }    
    
    
    public function getDesc() {
        
        return $this->descr;
        
    }
    
    public function getPrice() {
        
        return $this->price;
        
    }

    public function getValues() {
        
        return get_object_vars($this);
        
    }    
    
    
}

class PrivateAd extends BasicAd {
    
}

class CompanyAd extends BasicAd {
    
}

class AdsStore {

    private static $instance = NULL;
    private $ads = array();

    public static function instance() {
        if (self::$instance == NULL) {
            self::$instance = new AdsStore();
        }

        return self::$instance;
    }

    public function addAds(BasicAd $ad) {
        if (!($this instanceof AdsStore)) {
            die('Нельзя использовать этот метод в конструкторе классов');
        }
        $this->ads[$ad->getId()] = $ad;
        
        //var_dump($this->ads);
        
    }

    public function getAllAdsFromDb() {
        global $db;
        $all_ads = $db->select('select * from ads');
        foreach ($all_ads as $ad) {
            
            //var_dump($value);
            
            $ad = new BasicAd($ad);
            self::addAds($ad);
        }
    }
    
    public function getAd($id) {
        
        foreach ($this->ads as $value) {
            
            if ($value->getId() == $id ) {
                
                return $value;
                
            }
            
        }
        
    }
    

    public function writeOutAll() {

        global $smarty;
        global $site_dir;
        global $current_php_script;
        $row = '';
        foreach ($this->ads as $value) {
            //var_dump($value);
            $smarty->assign('ad', $value);
            $smarty->assign('current_php_script', $current_php_script);
            $smarty->assign('site_dir', $site_dir);
            $row.=$smarty->fetch('table_row.tpl.html');
            
            //var_dump($row);
        }
        
        
        
        $smarty->assign('ads_rows', $row);
    }
    
    
    public function writeOutOne($id) {
        
        global $values_for_form;
        
        foreach ($this->ads as $value) {

            //var_dump($value->getValues());
            //var_dump(get_object_vars($value));
            if ($value->getId() == $id) {
                
                $value2 = $value->getValues();
                

                if ($value2['private'] == '1') {

                $values_for_form['checkedPrivate']= 'checked';
                    $values_for_form['checkedCompany'] = '';
                } else {

                    $values_for_form['checkedPrivate'] = '';
                    $values_for_form['checkedCompany'] = 'checked';
                }

                $values_for_form['seller_name'] = $value2['user_name'];
                $values_for_form['email'] = $value2['email'];

                if ($value2['send_to_email'] == '1') {

                    $values_for_form['allow_mails'] = 'checked';
                } else {

                    $$values_for_form['allow_mails'] = '';
                }


                $values_for_form['phone'] = $value2['tel'];

                $values_for_form['location_id'] = $value2['id_city'];
                $values_for_form['tube_station_id'] = $value2['id_tube_station'];
                $values_for_form['category_id'] = $value2['id_subcategory'];
                $values_for_form['title'] = $value2['title'];
                $values_for_form['description'] = $value2['descr'];
                $values_for_form['price'] = $value2['price'];
                $values_for_form['post_edit']='1';

            }   
                
                //var_dump($temp_array);
                
        
        
        }
                
                
    }
        
    public function change_ad($id) {
        
        
        global $_POST;
        
        $ad=self::getAd($id);
        
        // формируем данные объявления vars
        
        
        $vars['id'] = $id;
        $vars['title'] = $_POST['title'];
        $vars['price'] = $_POST['price'];
        $vars['user_name'] = $_POST['seller_name'];
        $vars['email'] = $_POST['email'];
        $vars['tel'] = $_POST['phone'];
        $vars['descr'] = $_POST['description'];
        $vars['id_city'] = $_POST['location_id'];
        $vars['id_tube_station'] = $_POST['metro_id'];
        $vars['id_subcategory'] = $_POST['category_id'];
        $vars['private'] = $_POST['private'];
        
        if (isset($_POST['allow_mails'])) {

            $vars['send_to_email'] = $_POST['allow_mails'];
        } else {

            $vars['send_to_email'] = '0';
        }
        
        //var_dump($vars);
        $ad->edit($vars);
        
        
        
        
        
        
    }
    
    public function delete_ad($id) {
        
        //var_dump($this->ads);
        
        foreach ($this->ads as $object) {

            if ($object->getId() == $id) {
                
                $object->delete($id);
                unset($object);
                
            }
        }
        
        //var_dump($this->ads);
        
    }
                
    
        
    

}
