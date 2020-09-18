<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Diariooficial
 * @author     Barco Digital <admin@barco.digital>
 * @copyright  2020 Barco Digital
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\MVC\Controller\BaseController;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_diariooficial'))
{
	throw new Exception(Text::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Diariooficial', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('DiariooficialHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'diariooficial.php');

$controller = BaseController::getInstance('Diariooficial');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
