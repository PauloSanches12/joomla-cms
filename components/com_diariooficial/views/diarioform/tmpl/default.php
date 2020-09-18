<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Diariooficial
 * @author     Barco Digital <admin@barco.digital>
 * @copyright  2020 Barco Digital
 * @license    GNU General Public License vers達o 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Uri\Uri;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Language\Text;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.formvalidation');
HTMLHelper::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = Factory::getLanguage();
$lang->load('com_diariooficial', JPATH_SITE);
$doc = Factory::getDocument();
$doc->addScript(Uri::base() . '/media/com_diariooficial/js/form.js');

$user    = Factory::getUser();
$canEdit = DiariooficialHelpersDiariooficial::canUserEdit($this->item, $user);


?>

<div class="diario-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(Text::_('COM_DIARIOOFICIAL_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h2>Editar documento</h2>
		<?php else: ?>
			<h2>Adicionar Documento</h2>
		<?php endif; ?>

		<form id="form-diario"
			  action="<?php echo Route::_('index.php?option=com_diariooficial&task=diario.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>

	<div class="row">
        <div class="col-sm-4">		
			<?php echo $this->form->renderField('edicao'); ?>
		</div>
		<div class="col-sm-4">
			<?php echo $this->form->renderField('data'); ?>
		</div>
		<div class="col-sm-4">
			<?php echo $this->form->renderField('destaque'); ?>
		</div>
	</div>
	<?php echo $this->form->renderField('texto'); ?>
</div>
	<?php echo $this->form->renderField('arquivo'); ?>

				<?php if (!empty($this->item->arquivo)) : ?>
					<?php $arquivoFiles = array(); ?>
					<?php foreach ((array)$this->item->arquivo as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'uploads/diariooficial' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $arquivoFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<input type="hidden" name="jform[arquivo_hidden]" id="jform_arquivo_hidden" value="<?php echo implode(',', $arquivoFiles); ?>" />
				<?php endif; ?>
	</div>
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


					<?php if ($this->canSave): ?>
						<button type="submit" class="validate btn btn-primary">
							<?php echo Text::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo Route::_('index.php?option=com_diariooficial&task=diarioform.cancel'); ?>"
					   title="<?php echo Text::_('JCANCEL'); ?>">
						<?php echo Text::_('JCANCEL'); ?>
					</a>
				</div>
			</div>

			<input type="hidden" name="option" value="com_diariooficial"/>
			<input type="hidden" name="task"
				   value="diarioform.save"/>
			<?php echo HTMLHelper::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>
