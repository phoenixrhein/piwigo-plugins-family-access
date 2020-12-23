<?php
/*
Plugin Name: Family Access
Version: 1.0.0
Description: My Description
Plugin URI: http://www.xovatec.de
Author: XovaTex
Author URI: http://www.xovatec.de
*/
if (!defined('PHPWG_ROOT_PATH'))
{
  die('Hacking attempt!');
}

//include(PHPWG_ROOT_PATH.'include/section_init.inc.php');

class FamilyAccess
{
    public function checkAccess() {
        global $page, $logger;
        
        //already logged on
        if (array_key_exists('pwg_familyaccess_verify', $_SESSION) === true && $_SESSION['pwg_familyaccess_verify'] == true) {
            return;
        }
        
        //check if login succesful
        if ( array_key_exists('city', $_POST) && strtolower(trim($_POST['city'])) === 'krefeld') {
            $_SESSION['pwg_familyaccess_verify'] =  true;
            $uri = $_SESSION['pwg_familyaccess_forward_url'];
            if (strpos($uri, '/') === 0) {
                $uri = substr($uri, 1);
            }
            redirect(PHPWG_ROOT_PATH.$uri);
            return;
        }
        
        
        // build url to login and redirect
        if (strpos($_SERVER['REQUEST_URI'], 'access-question.php') === false) {
            $_SESSION['pwg_familyaccess_raw_title'] = 'Unsere Lumix';
            $title = 'Unsere Lumix';
            $_SESSION['pwg_familyaccess_raw_image'] = null;
            $image = null;
            if (array_key_exists('category', $page) === true) {
                if (array_key_exists('name', $page['category']) === true) {
                    $_SESSION['pwg_familyaccess_raw_title'] = $page['category']['name'];
                    $title = $page['category']['name'];
                }
                if (array_key_exists('representative_picture_id', $page['category']) === true) {
                    $_SESSION['pwg_familyaccess_raw_image'] = $this->getImage($page['category']['representative_picture_id']);
                    $image = $this->getImage($page['category']['representative_picture_id']);
                }
            }
            $_SESSION['pwg_familyaccess_forward_url']  = $_SERVER['REQUEST_URI'];
            redirect(PHPWG_ROOT_PATH.'plugins/FamilyAccess/view/access-question.php?title='.urlencode($title).'&image='.urlencode($image));
        }
        
    }
    
    public function getImage($image_id) {
        $query = '
            SELECT id,representative_ext,path
                FROM '.IMAGES_TABLE.'
                WHERE id = '.$image_id.';';
        
        $row = pwg_db_fetch_assoc(pwg_query($query));
        $src = DerivativeImage::url(IMG_LARGE, $row);
        //$url = get_root_url().'admin.php?page=photo-'.$image_id;
        
        return '/'.$src;
    }
}

$myObj  =  new FamilyAccess ( ) ;
add_event_handler ( 'loc_end_section_init' ,  Array ( &$myObj ,  'checkAccess' )  ) ;
//add_event_handler ( 'init' ,  Array ( &$myObj ,  'checkAccess' )  ) ;
?>
