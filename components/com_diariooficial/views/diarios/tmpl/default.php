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
HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('formbehavior.chosen', 'select');

$user       = Factory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_diariooficial') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'diarioform.xml');
$canEdit    = $user->authorise('core.edit', 'com_diariooficial') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'diarioform.xml');
$canCheckin = $user->authorise('core.manage', 'com_diariooficial');
$canChange  = $user->authorise('core.edit.state', 'com_diariooficial');
$canDelete  = $user->authorise('core.delete', 'com_diariooficial');

// Import CSS
$document = Factory::getDocument();
$document->addStyleSheet(Uri::root() . 'media/com_diariooficial/css/list.css');
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<style>
	#sp-main-body {
    padding: 40px 0;
}


.table-striped td, .table-striped th {
        padding: 9px 10px 6px;
    }

    
</style>

<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post"
      name="adminForm" id="adminForm">

		<div class="row">
			<div class="col-sm-2">

				<!-- Data inicial-->
                <label style="font-size: 13px" mega-label=""> Data inicial </label>
				<div style="width: 100%" _ngcontent-bff-c23="" class="input-group-prepend">

					<input _ngcontent-hrc-c22="" autocomplete="off" class="form-control mega-calendario-input ng-untouched ng-pristine ng-valid" ngbdatepicker="" type="date" id="data_inicial" name="data_inicial" placeholder="" maxlength="255">
				</div>
			</div>
			<div class="col-sm-2">

				<!-- Data Final-->
                <label style="font-size: 13px" mega-label=""> Data Final </label>
				<div style="width: 100%" _ngcontent-bff-c23="" class="input-group-prepend">
					<input type="date" name="data_final" id="data_final" value="" class="form-control" placeholder="Buscar">
				</div>
			</div>
			<div class="col-sm-8">
			    <label style="font-size: 13px; " mega-label=""> Palavra-chave </label>
				<?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>		
			</div>
				
		</div>
	
        <div style="overflow-x:hidden; " class="table-responsive">

<div class="row">
<div class="col-sm-4">
<table style="overflow-y:hidden; overflow-x:hidden; text-align: left; margin-left: 0px;" >
	<tbody class="thead-light">
		<?php foreach($this->destaques as $i => $destaque) :?>
			<?php if($destaque->destaque == 1) :?>
		<tr>
		     <td>
			     <div style="background-color: white">
			     	<button type="button" class="btn btn-primary btn-lg btn-block" style="background-color: #0097f4;"><h5 style="text-align: center;"><span style="color: white;">Última Edição</span></h5></button>
			     </div>
			    
			    <a style="background-color: white" href="<?php echo $destaque->url;?>" target="_blank"><img style="margin-left:2px;" border="" height="0" src="<?php echo JRoute::_(JUri::root() . 'Imagens' . DIRECTORY_SEPARATOR . $destaque->imagem);?>" width="99%" /> </a>
		    	</div>
			</td>

		 </tr>
		 	 
		  </tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>

</div>

<div class="col-sm-8">
		<tr>
			<td>
			 	<button type="button" class="btn btn-primary btn-lg btn-block" style="background-color: #0097f4;"><h5 style="text-align: center;"><span style="color: white;">Edições Anteriores</span></h5></button>
			 </td>
		</tr>
	<table style="overflow-y:hidden; overflow-x:hidden; text-align: center;" class="table table-striped" id="diarioList">
		<thead>
		<tr>
			<?php if (isset($this->items[0]->state)): ?>
				
			<?php endif; ?>

							<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_DIARIOOFICIAL_DIARIOS_EDICAO', 'a.edicao', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_DIARIOOFICIAL_DIARIOS_DATA', 'a.data', $listDirn, $listOrder); ?>
				</th>
				
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_DIARIOOFICIAL_DIARIOS_ARQUIVO', 'a.arquivo', $listDirn, $listOrder); ?>
				</th>
				

							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_DIARIOOFICIAL_DIARIOS_ACTIONS'); ?>
				</th>
				<?php endif; ?>

		</tr>
		</thead>
		
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<?php if (($_POST[data_inicial] == "" && $_POST[data_final] == "") ||
					($_POST[data_inicial] != "" && $_POST[data_final] != "" && $item->data >= $_POST[data_inicial]." 00:00" && $item->data <= $_POST[data_final]." 23:59") ||
					($_POST[data_inicial] != "" && $_POST[data_final] == "" && $item->data >= $_POST[data_inicial]) ||
					($_POST[data_inicial] == "" && $_POST[data_final] != "" && $item->data <= $_POST[data_final])
				) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_diariooficial'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_diariooficial')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
					
				<?php endif; ?>

				<td>
					<?php echo $this->escape($item->edicao); ?></a>
				</td>
				<td id="tdData">

				<?php 
				
				    $tempData = explode("-", $item->data);
				    $tempData[2]=explode(" ",$tempData[2]);
				   echo $tempData[2][0]."/".$tempData[1]."/".$tempData[0];
			
				?>
				
				
				</td>
				
				<td>

					<?php
						if (!empty($item->arquivo)) :
							$arquivoArr = (array) explode(',', $item->arquivo);
							foreach ($arquivoArr as $singleFile) : 
								if (!is_array($singleFile)) :
									$uploadPath = 'uploads/diariooficial' . DIRECTORY_SEPARATOR . $singleFile;
									echo '<a class="btn btn-outline-primary btn-sm" href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank" title="Visualizar">' . "Visualizar" . '</a> ';
								endif;
							endforeach;
						else:
							echo $item->arquivo;
						endif; ?>				
					</td>
				



								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_diariooficial&task=diarioform.edit&id=' . $item->id, false, 2); ?>" class="fa fa-pencil-square-o" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_diariooficial&task=diarioform.remove&id=' . $item->id, false, 2); ?>" class="fa fa-trash-o delete-button" type="button"><i class="icon-trash" ></i></a>
						<?php endif; ?>

					<a href="<?php echo $item->url; ?>" target="_blank">URL</a>


					<?php
						if (!empty($item->imagem)) :
							$imagemArr = (array) explode(',', $item->imagem);
							foreach ($imagemArr as $singleFile) : 
								if (!is_array($singleFile)) :
									$uploadPath = 'Imagens' . DIRECTORY_SEPARATOR . $singleFile;
									echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank" title="Visualizar">' . "Img" . ' </a> ';
								endif;
							endforeach;
						else:
							echo $item->imagem;
						endif; ?>			

					</td>
				<?php endif; ?>
			<?php endif; ?>	
			</tr>
		<?php endforeach; ?>
		
		</tbody>
	</table>

        </div>

  	<div class="col-sm-12">
  	    
        <tfoot>
		    <tr>
    			<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
    				<?php echo $this->pagination->getListFooter(); ?>
    			</td>
    		</tr>
		</tfoot>
        
        <hr />
        </div>
	<div class="col-sm-4">
	        
		    <tr>
		      <i class="fa fa-file-text-o" aria-hidden="true"> </i>  <th scope="col" style="text-align: center;">Diário Oficial com certificação digital</th><hr />
		    </tr>
		    <tr>
		        <th>
		            <div style="text-align: justify;">
						<span style="font-size: 10pt;"><i>Os Atos oficiais publicados neste site são assinados digitalmente com assinatura eletrônica conforme:</br></i></span></div>

                </th>
		        <th>
		            <div style="text-align: justify;">
					<span style="font-size: 10pt;"><i><a href="https://lajeado.to.leg.br/uploads/legislacao/resolucoes/RESOLUCAO-N-04-2019.PDF" target="_blank">Resolução Nº 004/2019</a></i></span></div>
 
                </th>
		    </tr>
	
		   </br>
		    
	</div>
	<div class="col-sm-4">
	 <tr>
		      <i class="fa fa-exclamation-triangle" aria-hidden="true"> </i><th scope="col" style="text-align: center;"> Informação importante</th><hr />
		    </tr>
		    <tr>
		        <th>
		         <div style="text-align: justify;">
					<span style="font-size: 10pt;"><i>O Diário Oficial só tem validade como instrumento jurídico em sua versão original impressa, contendo carimbo de autenticidade.</i></span></div>
           </th>
		    </tr>
		  </br>
	</div>
	<div class="col-sm-4">
	 <tr>
		      <i class="fa fa-building-o" aria-hidden="true"> </i><th scope="col" style="text-align: center;"> Departamento de Imprensa</th><hr />
		    </tr>
		    <tr>
		        <th>
		         <div style="text-align: justify;">
		         	<i class="fa fa-phone" aria-hidden="true"></i><span style="font-size: 10pt;"><i> (63) 3519-1105</span></i></div>
		         	<i class="fa fa-envelope-open-o" aria-hidden="true"></i><span style="font-size: 10pt;"><i> diariocamara00@gmail.com</span></i></br>
		         	<i class="fa fa-map-marker" aria-hidden="true"></i><span style="font-size: 10pt;"><i> AV Justiniano Monteiro, 2075. CEP: 77.645-000</span></i>
           </th>
		    </tr>
		 
	</div>


	<?php if ($canCreate) : ?>
		<a href="<?php echo Route::_('index.php?option=com_diariooficial&task=diarioform.edit&id=0', false, 0); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo Text::_('COM_DIARIOOFICIAL_ADD_ITEM'); ?></a>
	<?php endif; ?>


	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo HTMLHelper::_('form.token'); ?>
</form>

<?php if($canDelete) : ?>
<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {

		if (!confirm("<?php echo Text::_('COM_DIARIOOFICIAL_DELETE_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>
<?php endif; ?>
<!-- Comentário Teste -->