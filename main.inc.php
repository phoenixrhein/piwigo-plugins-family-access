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

include_once FAMILY_ACCESS_PLUGIN_PATH . 'FamilyAccessConfig.php';
include_once FAMILY_ACCESS_INCLUDE_PATH . 'FamilyAccessTemplateHelper.php';
include_once FAMILY_ACCESS_VIEW_PATH . 'FamilyAccessQuestionView.php';

/**
 * class FamilyAccessApp
 */
class FamilyAccessApp
{

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
     * @var string
     */
    private $forwardUri = '';

    /**
     *
     * @var FamilyAccessQuestionView
     */
    private $view;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->view = new FamilyAccessQuestionView();
    }

    /**
     * Init
     * 
     * @return void
     */
    public function init()
    {
        if ($this->isLoggedIn() === true) {
            return;
        }

        if (strpos($_SERVER['REQUEST_URI'], '/index.php') !== 0 && $_SERVER['REQUEST_URI'] != '/') {
            redirect(PHPWG_ROOT_PATH . 'index.php?pageTitle=' . urlencode($this->pageTitle) . '&imageUrl=' . urlencode($this->imageUrl) . '&forwardUri=' . urlencode($_SERVER['REQUEST_URI']));
        }
    }

    /**
     * Is logged in
     * 
     * @return boolean
     */
    private function isLoggedIn()
    {
        if (array_key_exists('pwg_familyaccess_verify', $_SESSION) === true && $_SESSION['pwg_familyaccess_verify'] == true) {
            return true;
        }

        return false;
    }

    /**
     * Check access
     *
     * @return void
     */
    public function checkAccess()
    {
        global $page, $conf;

        // already logged on
        if ($this->isLoggedIn() === true) {
            return;
        }

        // check if login successful
        if (array_key_exists('answer', $_POST) && strtolower(trim($_POST['answer'])) === strtolower(FamilyAccessConfig::$answer)) {
            $_SESSION['pwg_familyaccess_verify'] = true;
            if (array_key_exists('forwardUri', $_GET) === false) {
                return;
            }
            $uri = $_GET['forwardUri'];
            if (strpos($uri, '/') === 0) {
                $uri = substr($uri, 1);
            }
            
            redirect(PHPWG_ROOT_PATH . $uri);
            return;
        }

        if (array_key_exists('pageTitle', $_GET) === true) {
            $this->pageTitle = $_GET['pageTitle'];
        }

        if (array_key_exists('imageUrl', $_GET) === true) {
            $this->imageUrl = $_GET['imageUrl'];
        }

        if (array_key_exists('category', $page) === true) {
            if ($this->pageTitle == null && array_key_exists('name', $page['category']) === true) {
                $this->pageTitle = $page['category']['name'];
            }
            if ($this->imageUrl == null && array_key_exists('representative_picture_id', $page['category']) === true) {
                $this->imageUrl = $this->getPreviewImage($page['category']['representative_picture_id']);
            }
        }

        if ($this->pageTitle == null) {
            $this->pageTitle = $conf['gallery_title'];
        }

        if (array_key_exists('forwardUri', $_GET) === true) {
            $this->forwardUri = $_GET['forwardUri'];
        }

        if (strpos($_SERVER['REQUEST_URI'], '/index.php') !== 0 && $_SERVER['REQUEST_URI'] != '/') {
            redirect(PHPWG_ROOT_PATH . 'index.php?pageTitle=' . urlencode($this->pageTitle) . '&imageUrl=' . urlencode($this->imageUrl) . '&forwardUri=' . urlencode($_SERVER['REQUEST_URI']));
        }
        
        $this->view->setTitle($this->pageTitle);
        $this->view->setImageUrl($this->imageUrl);
    }

    /**
     * Get preview image url
     *
     * @param int $image_id
     * @return string
     */
    private function getPreviewImage($image_id)
    {
        $query = '
            SELECT id,representative_ext,path
                FROM ' . IMAGES_TABLE . '
                WHERE id = ' . $image_id . ';';

        $row = pwg_db_fetch_assoc(pwg_query($query));
        $src = DerivativeImage::url(IMG_LARGE, $row);

        return '/' . $src;
    }

    /**
     * Create login template
     *
     * @return void
     */
    public function createLoginTemplate()
    {
        if ($this->isLoggedIn() == true) {
            return;
        }

        $this->view->view($this->forwardUri);
    }

    /**
     * Disable menubar
     *
     * @return void
     */
    public function disableMenubar()
    {
        if ($this->isLoggedIn() == true) {
            return;
        }

        $this->view->disableMenubar();
    }
}

$app = new FamilyAccessApp();

add_event_handler('init', array(
    &$app,
    'init'
));

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
