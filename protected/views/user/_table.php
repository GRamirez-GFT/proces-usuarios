<?php $itemsTable = $model->findAll();?>
<div class="mws-panel-body">
	<div class="dataTables_wrapper">
		<table class="mws-datatable-fn mws-table">
			<thead>
				<tr>
					<th style="width: auto;" class="sorting_asc">username</th>
					<th style="width: auto;" class="sorting">name</th>
					<th style="width: auto;" class="sorting">active</th>
					<th style="width: auto;" class="sorting">date_create</th>
					<th style="width: 11px;" colspan="1" rowspan="1" class="button_colum sorting"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($itemsTable as $item):?>
				 <tr class="gradeX gray_tr">
					<td><?php echo $item->username; ?></td>
					<td><?php echo $item->name; ?></td>
					<td><?php echo $item->active; ?></td>
					<td><?php echo $item->date_create; ?></td>
					<td class="button_colum">
					   <?php echo CHtml::link('<div class="more_icon mws-tooltip-e" original-title="Ver detalles"></div>', $item->id);?>
                    </td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>