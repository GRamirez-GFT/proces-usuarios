<?php // TODO: Condicion de acceso CREAR?>
<div id="front" class="content">
	<div>
		<div class="mws-panel-body">
			<div class="dataTables_wrapper">
				<table class="mws-datatable-fn mws-table">
					<thead>
						<tr>
							<th style="width: 182px;" class="sorting_asc">username</th>
							<th style="width: 184px;" class="sorting">name</th>
							<th style="width: 169px;" class="sorting">active</th>
							<th style="width: 165px;" class="sorting">date_create</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($model->findAll() as $item):?>
					    <tr>
							<td><?php echo $item->username; ?></td>
							<td><?php echo $item->name; ?></td>
							<td><?php echo $item->active; ?></td>
							<td><?php echo $item->date_create; ?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>

<div id="panel" style="display: none; width: 30%">
	<div id="panel-content" class="panel_section">
		<?php $this->renderPartial('_form', array('model' => $model)); ?>
	</div>
</div>