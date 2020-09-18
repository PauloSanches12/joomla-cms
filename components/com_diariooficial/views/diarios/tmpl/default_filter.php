<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Diariooficial
 * @author     Barco Digital <admin@barco.digital>
 * @copyright  2020 Barco Digital
 * @license    GNU General Public License vers達o 2 ou posterior; consulte o arquivo License. txt
 */

defined('JPATH_BASE') or die;

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

$data = $displayData;

// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();

// Check if any filter field has been filled
$filters       = false;
$filtered      = false;
$search_filter = false;

if (isset($data['view']->filterForm))
{
	$filters = $data['view']->filterForm->getGroup('filter');
}

// Check if there are filters set.
if ($filters !== false)
{
	$filterFields = array_keys($filters);
	$filled       = false;

	foreach ($filterFields as $filterField)
	{
		$filterField = substr($filterField, 7);
		$filter      = $data['view']->getState('filter.' . $filterField);

		if (!empty($filter))
		{
			$filled = $filter;
		}

		if (!empty($filled))
		{
			$filtered = true;
			break;
		}
	}

	$search_filter = $filters['filter_search'];
	unset($filters['filter_search']);
}

$options = $data['options'];

// Set some basic options
$customOptions = array(
	'filtersHidden'       => isset($options['filtersHidden']) ? $options['filtersHidden'] : empty($data['view']->activeFilters) && !$filtered,
	'defaultLimit'        => isset($options['defaultLimit']) ? $options['defaultLimit'] : Factory::getApplication()->get('list_limit', 20),
	'searchFieldSelector' => '#filter_search',
	'orderFieldSelector'  => '#list_fullordering'
);

$data['options'] = array_unique(array_merge($customOptions, $data['options']));

$formSelector = !empty($data['options']['formSelector']) ? $data['options']['formSelector'] : '#adminForm';

// Load search tools
HTMLHelper::_('searchtools.form', $formSelector, $data['options']);
?>

<div class="row">

    <div class="col-sm">

        <!-- Campo de pesquisa-->

        <label for="filter_search" class="element-invisible" aria-invalid="false"><?php //echo Text::_('COM_DIARIOOFICIAL_SEARCH_FILTER_SUBMIT'); 
                                                                                    ?></label>

        <div style="padding: 0px; width: 75%; margin-left: -5px" class="btn btn-outline input-append table-responsive-md">
            <?php echo $search_filter->input; ?>
        </div>

        <button type="submit" class="btn btn-primary" title="Pesquisar" data-original-title="<?php echo Text::_('COM_DIARIOOFICIAL_SEARCH_FILTER_SUBMIT'); ?>">
            Pesquisar
        </button>

        <button type="button" class="btn btn-primary js-stools-btn-clear" title="Limpar" data-original-title="<?php echo Text::_('COM_DIARIOOFICIAL_SEARCH_FILTER_CLEAR'); ?>" onclick="jQuery(this).closest('form').find('input').val('');">
            Limpar
        </button>

    </div>


</div>
</br>