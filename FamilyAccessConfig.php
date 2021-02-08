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
 * class FamilyAccessConfig
 */
class FamilyAccessConfig
{

    /**
     *
     * @var string
     */
    public static $question = 'In welcher Stadt wohnt Familie (ehemals) HKS?';

    /**
     *
     * @var string
     */
    public static $answer = 'Krefeld';
    
    /**
     *
     * @var string
     */
    public static $answerPlaceholder = 'Stadt';
}