<?php
// ############################################################################
// *
// * Copyright (C) xt by hobutech
// *
// ############################################################################

// Chech whether we are indeed included by Piwigo.
if (defined('PHPWG_ROOT_PATH') === false) {
    die('Hacking attempt!');
}

/**
 * class FamilyAccessQuestionView
 */
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

    /**
     *
     * @var string
     */
    private $url;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->templateHelper = new FamilyAccessTemplateHelper();
    }

    /**
     * View
     *
     * @param string $pageTitle
     * @param string $imageUrl
     * @return void
     */
    public function view($pageTitle, $imageUrl = null, $url = null)
    {
        $this->title = $pageTitle;
        $this->imageUrl = $imageUrl;
        $this->url = $url;
        $this->disableCategoryListView();

        $filePath = FAMILY_ACCESS_TEMPLATE_PATH . 'access-question.tpl';
        $this->templateHelper->getTemplate()->set_filename('accessquestion', $filePath);
        $this->templateHelper->getTemplate()->assign('url', $this->prepareUrl());
        $this->templateHelper->getTemplate()->assign_var_from_handle('CATEGORIES', 'accessquestion');
    }

    /**
     * Get prepared forward url
     *
     * @return string
     */
    private function prepareUrl()
    {
        if ($this->url !== null) {
            return $this->url;
        }

        $url = 'http';
        if (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $url = 'https';
        }
        $url .= '://' . $_SERVER['HTTP_HOST'];

        return $url;
    }

    /**
     * Disable category list view
     *
     * @return void
     */
    private function disableCategoryListView()
    {
        $clearVariables = [
            'cats_navbar',
            'thumb_navbar',
            'image_derivatives',
            'image_orders',
            'PLUGIN_INDEX_BUTTONS',
            'PLUGIN_INDEX_ACTIONS'
        ];

        $this->templateHelper->clearVariables($clearVariables);

        $removeVariables = [
            'U_MODE_CREATED',
            'favorite',
            'U_EDIT',
            'U_CADDIE',
            'U_SEARCH_RULES',
            'U_SLIDESHOW',
            'U_MODE_FLAT',
            'U_MODE_NORMAL',
            'U_MODE_POSTED',
            'THUMBNAILS'
        ];

        $this->templateHelper->removeVariables($removeVariables);
    }

    /**
     * Disable menubar
     *
     * @return void
     */
    public function disableMenubar()
    {
        $this->templateHelper->getTemplate()->smarty->tpl_vars['MENUBAR'] = new Smarty_Variable('', false);
        if ($this->title != null) {
            $this->setTitle();
        }

        $this->setMetaTagImage();
    }

    /**
     * Set page title
     *
     * @return void
     */
    private function setTitle()
    {
        $pageTitle = $this->templateHelper->getTemplate()->smarty->tpl_vars['PAGE_TITLE'];
        $this->templateHelper->getTemplate()->assign('GALLERY_TITLE', $pageTitle);
        $this->templateHelper->getTemplate()->assign('PAGE_TITLE', $this->title);
    }

    /**
     * Set meta tag image
     *
     * @return void
     */
    private function setMetaTagImage()
    {
        if ($this->imageUrl == null) {
            return;
        }

        $url = 'https://' . $_SERVER['SERVER_NAME'] . $this->imageUrl;
        $headElements = [
            '<meta property="og:image" content="' . $url . '" />'
        ];
        if (array_key_exists('head_elements', $this->templateHelper->getTemplate()->smarty->tpl_vars) === true) {
            /** @var $headElements Smarty_Variable */
            $headElementObj = $this->templateHelper->getTemplate()->smarty->tpl_vars['head_elements'];
            $headElements = array_merge($headElementObj->value, [
                '<meta property="og:image" content="' . $url . '" />'
            ]);
        }
        $this->templateHelper->getTemplate()->assign('head_elements', $headElements);
    }
}