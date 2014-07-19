<div id="column1" class="content">
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
					<?php foreach (User::model()->findAll() as $item):?>
					    <tr>
							<td><?=$item->username?></td>
							<td><?=$item->name?></td>
							<td><?=$item->active?></td>
							<td><?=$item->date_create?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>


<div id="column2" class="content" style="display: none;">
	<div id="panel-options">
		<div id="close-panel"></div>
	</div>
	<div id="panel-content" class="panel_section">FORMULARIO</div>
</div>