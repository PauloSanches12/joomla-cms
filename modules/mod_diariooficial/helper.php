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
use \Joomla\CMS\Language\Text;

/**
 * Helper for mod_diariooficial
 *
 * @package     com_diariooficial
 * @subpackage  mod_diariooficial
 * @since       1.6
 */
class ModDiariooficialHelper
{
	/**
	 * Retrieve component items
	 *
	 * @param   Joomla\Registry\Registry &$params module parameters
	 *
	 * @return array Array with all the elements
     *
     * @throws Exception
	 */
	public static function getList(&$params)
	{
		$app   = Factory::getApplication();
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		$tableField = explode(':', $params->get('field'));
		$table_name = !empty($tableField[0]) ? $tableField[0] : '';

		/* @var $params Joomla\Registry\Registry */
		$query
			->select('*')
			->from($table_name)
			->where('state = 1');

		$db->setQuery($query, $app->input->getInt('offset', (int) $params->get('offset')), $app->input->getInt('limit', (int) $params->get('limit')));
		$rows = $db->loadObjectList();

		return $rows;
	}

	/**
	 * Retrieve component items
	 *
	 * @param   Joomla\Registry\Registry &$params module parameters
	 *
	 * @return mixed stdClass object if the item was found, null otherwise
	 */
	public static function getItem(&$params)
	{
		$db    = Factory::getDbo();
		$query = $db->getQuery(true);

		/* @var $params Joomla\Registry\Registry */
		$query
			->select('*')
			->from($params->get('item_table'))
			->where('id = ' . intval($params->get('item_id')));

		$db->setQuery($query);
		$element = $db->loadObject();

		return $element;
	}

	/**
	 * Render element
	 *
	 * @param   Joomla\Registry\Registry $table_name  Table name
	 * @param   string                   $field_name  Field name
	 * @param   string                   $field_value Field value
	 *
	 * @return string
	 */
	public static function renderElement($table_name, $field_name, $field_value)
	{
		$result = '';
		
		if(strpos($field_name, ':'))
		{
			$tableField = explode(':', $field_name);
			$table_name = !empty($tableField[0]) ? $tableField[0] : '';
			$field_name = !empty($tableField[1]) ? $tableField[1] : '';
		}
		
		switch ($table_name)
		{
			
		case '#__diariooficial_diarios':
		switch($field_name){
		case 'id':
		$result = $field_value;
		break;
		case 'created_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'modified_by':
		$user = JFactory::getUser($field_value);
		$result = $user->name;
		break;
		case 'edicao':
		$result = $field_value;
		break;
		case 'data':
		$result = $field_value;
		break;
		case 'texto':
		$result = $field_value;
		break;
		case 'downloads':
		$result = $field_value;
		break;
		case 'arquivo':
						if (!empty($field_value)) {
							$result = JPATH_ADMINISTRATOR . 'components/com_diariooficial//uploads/diariooficial/' . $field_value;
						} else {
							$result = $field_value;
						}
		break;
		case 'imagem':
						if (!empty($field_value)) {
							$result = JPATH_ADMINISTRATOR . 'components/com_diariooficial/Imagens/' . $field_value;
						} else {
							$result = $field_value;
						}
		break;
		case 'url':
		$result = $field_value;
		break;
		case 'destaque':
		$result = $field_value;
		break;
		}
		break;
		}

		return $result;
	}

	/**
	 * Returns the translatable name of the element
	 *
	 * @param   string .................. $table_name table name
	 * @param   string                   $field   Field name
	 *
	 * @return string Translatable name.
	 */
	public static function renderTranslatableHeader($table_name, $field)
	{
		return Text::_(
			'MOD_DIARIOOFICIAL_HEADER_FIELD_' . str_replace('#__', '', strtoupper($table_name)) . '_' . strtoupper($field)
		);
	}

	/**
	 * Checks if an element should appear in the table/item view
	 *
	 * @param   string $field name of the field
	 *
	 * @return boolean True if it should appear, false otherwise
	 */
	public static function shouldAppear($field)
	{
		$noHeaderFields = array('checked_out_time', 'checked_out', 'ordering', 'state');

		return !in_array($field, $noHeaderFields);
	}

	
}
