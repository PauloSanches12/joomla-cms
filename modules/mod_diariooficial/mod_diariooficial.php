<?php

/**
 * @version     CVS: 1.0.0
 * @package     com_diariooficial
 * @subpackage  mod_diariooficial
 * @author      Barco Digital <admin@barco.digital>
 * @copyright   2020 Barco Digital
 * @license     GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Helper\ModuleHelper;

// Include the syndicate functions only once
JLoader::register('ModDiariooficialHelper', dirname(__FILE__) . '/helper.php');

$doc = Factory::getDocument();

/* */
$doc->addStyleSheet(URI::base() . 'media/mod_diariooficial/css/style.css');

/* */
$doc->addScript(URI::base() . 'media/mod_diariooficial/js/script.js');

require ModuleHelper::getLayoutPath('mod_diariooficial', $params->get('content_type', 'blank'));
