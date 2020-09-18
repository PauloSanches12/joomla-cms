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


use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Layout\LayoutHelper;
use \Joomla\CMS\Language\Text;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/');
HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');

// Import CSS
$document = Factory::getDocument();
$document->addStyleSheet(Uri::root() . 'administrator/components/com_diariooficial/assets/css/diariooficial.css');
$document->addStyleSheet(Uri::root() . 'media/com_diariooficial/css/list.css');

$user      = Factory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_diariooficial');
$saveOrder = $listOrder == 'a.`ordering`';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_diariooficial&task=diarios.saveOrderAjax&tmpl=component';
    HTMLHelper::_('sortablelist.sortable', 'diarioList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();
?>

<form action="<?php echo Route::_('index.php?option=com_diariooficial&view=diarios'); ?>" method="post"
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

            <?php echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

			<div class="clearfix"></div>
			<table class="table table-striped" id="diarioList">
				<thead>
				<tr>
					<?php if (isset($this->items[0]->ordering)): ?>
						<th width="1%" class="nowrap center hidden-phone">
                            <?php echo HTMLHelper::_('searchtools.sort', '', 'a.`ordering`', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                        </th>
					<?php endif; ?>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value=""
							   title="<?php echo Text::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<?php if (isset($this->items[0]->state)): ?>
						
					<?php endif; ?>

									<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_DIARIOOFICIAL_DIARIOS_EDICAO', 'a.`edicao`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_DIARIOOFICIAL_DIARIOS_DATA', 'a.`data`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_DIARIOOFICIAL_DIARIOS_TEXTO', 'a.`texto`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_DIARIOOFICIAL_DIARIOS_DOWNLOADS', 'a.`downloads`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_DIARIOOFICIAL_DIARIOS_ARQUIVO', 'a.`arquivo`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_DIARIOOFICIAL_DIARIOS_IMAGEM', 'a.`imagem`', $listDirn, $listOrder); ?>
				</th>
				<th class='left'>
				<?php echo JHtml::_('searchtools.sort',  'COM_DIARIOOFICIAL_DIARIOS_URL', 'a.`url`', $listDirn, $listOrder); ?>
				</th>

					
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create', 'com_diariooficial');
					$canEdit    = $user->authorise('core.edit', 'com_diariooficial');
					$canCheckin = $user->authorise('core.manage', 'com_diariooficial');
					$canChange  = $user->authorise('core.edit.state', 'com_diariooficial');
					?>
					<tr class="row<?php echo $i % 2; ?>">

						<?php if (isset($this->items[0]->ordering)) : ?>
							<td class="order nowrap center hidden-phone">
								<?php if ($canChange) :
									$disableClassName = '';
									$disabledLabel    = '';

									if (!$saveOrder) :
										$disabledLabel    = Text::_('JORDERINGDISABLED');
										$disableClassName = 'inactive tip-top';
									endif; ?>
									<span class="sortable-handler hasTooltip <?php echo $disableClassName ?>"
										  title="<?php echo $disabledLabel ?>">
							<i class="icon-menu"></i>
						</span>
									<input type="text" style="display:none" name="order[]" size="5"
										   value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
								<?php else : ?>
									<span class="sortable-handler inactive">
							<i class="icon-menu"></i>
						</span>
								<?php endif; ?>
							</td>
						<?php endif; ?>
						<td class="hidden-phone">
							<?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
						</td>
						<?php if (isset($this->items[0]->state)): ?>
							
						<?php endif; ?>

										<td>
				<?php if (isset($item->checked_out) && $item->checked_out && ($canEdit || $canChange)) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->uEditor, $item->checked_out_time, 'diarios.', $canCheckin); ?>
				<?php endif; ?>
				<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_diariooficial&task=diario.edit&id='.(int) $item->id); ?>">
					<?php echo $this->escape($item->edicao); ?></a>
				<?php else : ?>
					<?php echo $this->escape($item->edicao); ?>
				<?php endif; ?>

				</td>				<td>

					<?php echo $item->data; ?>
				</td>				<td>

					<?php echo $item->texto; ?>
				</td>				<td>

					<?php echo $item->downloads; ?>
				</td>				<td>

					<?php
						if (!empty($item->arquivo)) :
							$arquivoArr = explode(',', $item->arquivo);
							foreach ($arquivoArr as $fileSingle) :
								if (!is_array($fileSingle)) :
									$uploadPath = '/uploads/diariooficial' .DIRECTORY_SEPARATOR . $fileSingle;
									echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank" title="See the arquivo">' . $fileSingle . '</a> | ';
								endif;
							endforeach;
						else:
							echo $item->arquivo;
						endif; ?>
				</td>				<td>

					<?php
						if (!empty($item->imagem)) :
							$imagemArr = explode(',', $item->imagem);
							foreach ($imagemArr as $fileSingle) :
								if (!is_array($fileSingle)) :
									$uploadPath = 'Imagens' .DIRECTORY_SEPARATOR . $fileSingle;
									echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank" title="See the imagem">' . $fileSingle . '</a> | ';
								endif;
							endforeach;
						else:
							echo $item->imagem;
						endif; ?>
				</td>				<td>

					<?php echo $item->url; ?>
				</td>

					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
            <input type="hidden" name="list[fullorder]" value="<?php echo $listOrder; ?> <?php echo $listDirn; ?>"/>
			<?php echo HTMLHelper::_('form.token'); ?>
		</div>
</form>
<script>
    window.toggleField = function (id, task, field) {

        var f = document.adminForm, i = 0, cbx, cb = f[ id ];

        if (!cb) return false;

        while (true) {
            cbx = f[ 'cb' + i ];

            if (!cbx) break;

            cbx.checked = false;
            i++;
        }

        var inputField   = document.createElement('input');

        inputField.type  = 'hidden';
        inputField.name  = 'field';
        inputField.value = field;
        f.appendChild(inputField);

        cb.checked = true;
        f.boxchecked.value = 1;
        window.submitform(task);

        return false;
    };
</script>