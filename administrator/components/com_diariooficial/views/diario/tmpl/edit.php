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
use \Joomla\CMS\Language\Text;


HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.formvalidation');
HTMLHelper::_('formbehavior.chosen', 'select');
HTMLHelper::_('behavior.keepalive');

// Import CSS
$document = Factory::getDocument();
$document->addStyleSheet(Uri::root() . 'media/com_diariooficial/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'diario.cancel') {
			Joomla.submitform(task, document.getElementById('diario-form'));
		}
		else {
			
			if (task != 'diario.cancel' && document.formvalidator.isValid(document.id('diario-form'))) {
				
				Joomla.submitform(task, document.getElementById('diario-form'));
			}
			else {
				alert('<?php echo $this->escape(Text::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_diariooficial&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="diario-form" class="form-validate form-horizontal">

	
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
	<?php echo $this->form->renderField('created_by'); ?>
	<?php echo $this->form->renderField('modified_by'); ?>
	<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'diario')); ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'diario', JText::_('COM_DIARIOOFICIAL_TAB_DIARIO', true)); ?>
	<div class="row-fluid">
		<div class="span10 form-horizontal">
			<fieldset class="adminform">
				<legend><?php echo JText::_('COM_DIARIOOFICIAL_FIELDSET_DIARIO'); ?></legend>
				<?php echo $this->form->renderField('edicao'); ?>
				<?php echo $this->form->renderField('data'); ?>
				<?php echo $this->form->renderField('texto'); ?>
				<?php echo $this->form->renderField('downloads'); ?>
				<?php echo $this->form->renderField('arquivo'); ?>
				<?php if (!empty($this->item->arquivo)) : ?>
					<?php $arquivoFiles = array(); ?>
					<?php foreach ((array)$this->item->arquivo as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . '/uploads/diariooficial' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $arquivoFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[arquivo_hidden]" id="jform_arquivo_hidden" value="<?php echo implode(',', $arquivoFiles); ?>" />
				<?php endif; ?>
				<?php echo $this->form->renderField('imagem'); ?>
				<?php if (!empty($this->item->imagem)) : ?>
					<?php $imagemFiles = array(); ?>
					<?php foreach ((array)$this->item->imagem as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'Imagens' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $imagemFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[imagem_hidden]" id="jform_imagem_hidden" value="<?php echo implode(',', $imagemFiles); ?>" />
				<?php endif; ?>
				<?php echo $this->form->renderField('url'); ?>
				<?php echo $this->form->renderField('destaque'); ?>
				<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
				<?php endif; ?>
			</fieldset>
		</div>
	</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	
	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<input type="hidden" name="task" value=""/>
	<?php echo JHtml::_('form.token'); ?>

</form>
