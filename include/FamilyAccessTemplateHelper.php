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
 * class FamilyAccessTemplateHelper
 */
class FamilyAccessTemplateHelper
{

    /**
     * Get the smarty template object
     *
     * @return Template
     */
    public function getTemplate()
    {
        global $template;
        return $template;
    }

    /**
     * Clear variables
     *
     * @param array $variables
     * @return void
     */
    public function clearVariables(array $variables)
    {
        foreach ($variables as $variable) {
            $this->getTemplate()->assign($variable, '');
        }
    }

    /**
     * Remove variables
     *
     * @param array $variables
     * @return void
     */
    public function removeVariables(array $variables)
    {
        foreach ($variables as $variable) {
            if (array_key_exists($variable, $this->getTemplate()->smarty->tpl_vars) === true) {
                unset($this->getTemplate()->smarty->tpl_vars[$variable]);
            }
        }
    }
}