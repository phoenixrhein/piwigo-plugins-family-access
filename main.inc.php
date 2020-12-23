<?php
// ############################################################################
// *
// * Copyright (C) xt by hobutech
// *
// ############################################################################
// *
// * Plugin Name: Family Access
// * Version: dev
// * Description: access only after answering a question
// * Plugin URI: http://www.xovatec.de
// * Author: xt
// * Author URI:
// *
// * http://www.hobutech.de
// *
// ****************************************************************************

// Chech whether we are indeed included by Piwigo.
if (defined('PHPWG_ROOT_PATH') === false) {
    die('Hacking attempt!');
}

// Define the path to our plugin.
define('FAMILY_ACCESS_PLUGIN_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('FAMILY_ACCESS_TEMPLATE_PATH', FAMILY_ACCESS_PLUGIN_PATH . 'template' . DIRECTORY_SEPARATOR);
define('FAMILY_ACCESS_INCLUDE_PATH', FAMILY_ACCESS_PLUGIN_PATH . 'include' . DIRECTORY_SEPARATOR);
define('FAMILY_ACCESS_VIEW_PATH', FAMILY_ACCESS_PLUGIN_PATH . 'view' . DIRECTORY_SEPARATOR);

include_once FAMILY_ACCESS_INCLUDE_PATH . 'FamilyAccessTemplateHelper.php';
include_once FAMILY_ACCESS_VIEW_PATH . 'FamilyAccessQuestionView.php';

/**
 * class FamilyAccessApp
 */
class FamilyAccessApp
{

    /**
     *
     * @var boolean
     */
    private $loggedIn = false;

    /**
     *
     * @var string
     */
    private $pageTitle;

    /**
     *
     * @var string
     */
    private $imageUrl;

    /**
     *
     * @var FamilyAccessQuestionView
     */
    private $view;

    public function __construct()
    {
        $this->view = new FamilyAccessQuestionView();
    }

    /**
     * Check access
     *
     * @return void
     */
    public function checkAccess()
    {
        global $page;

        // already logged on
        if (array_key_exists('pwg_familyaccess_verify', $_SESSION) === true && $_SESSION['pwg_familyaccess_verify'] == true) {
            $this->loggedIn = true;
            return;
        }

        // check if login succesful
        if (array_key_exists('city', $_POST) && strtolower(trim($_POST['city'])) === 'krefeld') {
            $_SESSION['pwg_familyaccess_verify'] = true;
            $uri = $_SESSION['pwg_familyaccess_forward_url'];
            if (strpos($uri, '/') === 0) {
                $uri = substr($uri, 1);
            }
            $this->loggedIn = true;
            redirect(PHPWG_ROOT_PATH . $uri);
            return;
        }

        // build url to login and redirect
        if (strpos($_SERVER['REQUEST_URI'], 'access-question.php') === false) {
            $_SESSION['pwg_familyaccess_raw_title'] = 'Unsere Lumix';
            $this->pageTitle = 'Unsere Lumix';
            $_SESSION['pwg_familyaccess_raw_image'] = null;
            $this->imageUrl = null;
            if (array_key_exists('category', $page) === true) {
                if (array_key_exists('name', $page['category']) === true) {
                    $_SESSION['pwg_familyaccess_raw_title'] = $page['category']['name'];
                    $this->pageTitle = $page['category']['name'];
                }
                if (array_key_exists('representative_picture_id', $page['category']) === true) {
                    $_SESSION['pwg_familyaccess_raw_image'] = $this->getImage($page['category']['representative_picture_id']);
                    $this->imageUrl = $this->getImage($page['category']['representative_picture_id']);
                }
            }
            $_SESSION['pwg_familyaccess_forward_url'] = $_SERVER['REQUEST_URI'];

            if ($_SERVER['REQUEST_URI'] !== '/index.php') {
                redirect(PHPWG_ROOT_PATH . 'index.php');
            }
        }
    }

    /**
     * Get preview image url
     *
     * @param int $image_id
     * @return string
     */
    public function getPreviewImage($image_id)
    {
        $query = '
            SELECT id,representative_ext,path
                FROM ' . IMAGES_TABLE . '
                WHERE id = ' . $image_id . ';';

        $row = pwg_db_fetch_assoc(pwg_query($query));
        $src = DerivativeImage::url(IMG_LARGE, $row);

        return '/' . $src;
    }

    public function createLoginTemplate()
    {
        if ($this->loggedIn == true) {
            return;
        }

        $this->view->view($this->pageTitle, $this->imageUrl);
    }

    public function disableMenubar()
    {
        if ($this->loggedIn == true) {
            return;
        }

        $this->view->disableMenubar();
    }
}

$app = new FamilyAccessApp();
add_event_handler('loc_end_section_init', array(
    &$app,
    'checkAccess'
));

add_event_handler('loc_end_index', array(
    &$app,
    'createLoginTemplate'
));

add_event_handler('loc_end_page_header', array(
    &$app,
    'disableMenubar'
));
?>
