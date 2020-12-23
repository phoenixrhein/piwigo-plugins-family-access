<?php
// Chech whether we are indeed included by Piwigo.
if (defined('PHPWG_ROOT_PATH') === false) {
    die('Hacking attempt!');
}

class FamilyAccessQuestionView
{

    /**
     * 
     * @var FamilyAccessTemplateHelper
     */
    private $templateHelper;
    
    /**
     * 
     * @var string
     */
    private $title;
    
    /**
     * 
     * @var string
     */
    private $imageUrl;

    public function __construct()
    {
        $this->templateHelper = new FamilyAccessTemplateHelper();
    }

    public function view($pageTitle, $imageUrl = null)
    {
        $this->title = $pageTitle;
        $this->imageUrl = $imageUrl;
        $this->disableCategoryListView(); 
        
        $filePath = FAMILY_ACCESS_TEMPLATE_PATH . 'access-question.tpl';
        $this->templateHelper->getTemplate()->set_filename('accessquestion', $filePath);
        $this->templateHelper->getTemplate()->assign('url', $this->prepareUrl());
        $this->templateHelper->getTemplate()->assign_var_from_handle('CATEGORIES', 'accessquestion');
        
    }
    
    private function prepareUrl() 
    {
        $url = 'http';
        if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off') {
            $url = 'https';
        }
        $url .= '://' . $_SERVER['HTTP_HOST'];
        if (array_key_exists('pwg_familyaccess_forward_url', $_SESSION) === true && $_SESSION['pwg_familyaccess_forward_url'] != '' ) {
            $url = $_SESSION['pwg_familyaccess_forward_url'];
        }
        
        return $url;
    }

    private function disableCategoryListView()
    {
        $this->templateHelper->getTemplate()->assign('cats_navbar', '');
        $this->templateHelper->getTemplate()->assign('thumb_navbar', '');
        $this->templateHelper->getTemplate()->assign('image_derivatives', '');
        $this->templateHelper->getTemplate()->assign('image_orders', '');
        $this->templateHelper->getTemplate()->assign('PLUGIN_INDEX_BUTTONS', '');
        $this->templateHelper->getTemplate()->assign('PLUGIN_INDEX_ACTIONS', '');

        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['U_MODE_CREATED']);
        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['favorite']);
        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['U_EDIT']);
        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['U_CADDIE']);
        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['U_SEARCH_RULES']);
        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['U_SLIDESHOW']);
        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['U_MODE_FLAT']);
        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['U_MODE_NORMAL']);
        unset($this->templateHelper->getTemplate()->smarty->tpl_vars['U_MODE_POSTED']);
    }
    
    public function disableMenubar()
    {
        $this->templateHelper->getTemplate()->smarty->tpl_vars['MENUBAR'] = new Smarty_Variable('', false);
        
        $this->templateHelper->getTemplate()->assign('GALLERY_TITLE', 'Fotos der Familie HKS2');
        $this->templateHelper->getTemplate()->assign('PAGE_TITLE', $this->title);
        if ($this->imageUrl != null) {
            $url = 'https://'.$_SERVER['SERVER_NAME'].$this->imageUrl;
            //nicht einfach head elements ueberschreiben?
            $this->templateHelper->getTemplate()->assign('head_elements', array('<meta property="og:image" content="' . $url . '" />'));
        }
        
        
        
    }
}