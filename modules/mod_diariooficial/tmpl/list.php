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
$elements = ModDiariooficialHelper::getList($params);

$tableField = explode(':', $params->get('field'));
$table_name = !empty($tableField[0]) ? $tableField[0] : '';
$field_name = !empty($tableField[1]) ? $tableField[1] : '';
?>

<?php if (!empty($elements)) : ?>
	<table class="table">
		<?php foreach ($elements as $element) : ?>
			<tr>
				<th><?php echo ModDiariooficialHelper::renderTranslatableHeader($table_name, $field_name); ?></th>
				<td><?php echo ModDiariooficialHelper::renderElement(
						$table_name, $params->get('field'), $element->{$field_name}
					); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif;
