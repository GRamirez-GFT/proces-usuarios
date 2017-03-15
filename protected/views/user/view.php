<?php
    $this->breadcrumbs = array(
        Yii::t('base','Users') => array('admin'),
        $model->name,
    );

	$columnSize = '5';

	if(isset($ajaxRequest)) {
		$columnSize = '12';
	}
?>

<?php if(isset($ajaxRequest)): ?>
	<div class="panel-options">
<?php endif; ?>


<<?php echo isset($ajaxRequest) ? 'h2' : 'h1';?>>
	<?php echo (Yii::app()->user->id == $model->id) ? Yii::t('base', 'User profile') : Yii::t('base', 'User details'); ?>
</<?php echo isset($ajaxRequest) ? 'h2' : 'h1';?>>

<?php if(isset($ajaxRequest)): ?>
	</div> <!-- end panel-options -->

	<div class="panel-content">
<?php endif; ?>

<div class="row">

	<div class="col-md-12 <?php echo isset($ajaxRequest) ? 'panel-actions' : ''; ?>">

<?php
		$ajaxUpdate = isset($ajaxRequest) ? 'panel-trigger' : '';
        $companyModel = Company::model()->findByPk($model->company_id);

		echo CHtml::link('', Yii::app()->createAbsoluteUrl('user/update/?id='.$model->id), 
			array(
			'class' => 'btn btn-proces-white phantom-btn fa fa-pencil mws-tooltip-s '.$ajaxUpdate,
			'original-title' => Yii::t('base','Update')
		));

		if (in_array(Yii::app()->user->role, array("company")) && $companyModel->user_id != $model->id) {
			$ajaxDelete = isset($ajaxRequest) ? 'ajax-delete' : '';
			
			echo CHtml::link('', Yii::app()->createAbsoluteUrl('user/delete/?id='.$model->id), 
				array(
				'class' => 'btn btn-proces-white phantom-btn fa fa-trash mws-tooltip-s confirm-action '.$ajaxDelete,
				'original-title' => Yii::t('base','Delete')
			));
		}
?>
	</div>

	<div class="col-md-<?php echo $columnSize; ?>">

		<p>
			<span class="labeling"><?php echo  Yii::t('models/User', 'name'); ?>:</span>
			<?php echo $model->name; ?>
		</p>
	
		<p>
			<span class="labeling"><?php echo  Yii::t('models/User', 'username'); ?>:</span>
			<?php echo $model->username; ?>
		<p>

		<p>
			<span class="labeling"><?php echo  Yii::t('models/User', 'active'); ?>:</span>
			<?php echo ($model->active) ? 'Si' : 'No'; ?>
		<p>

		<p>
			<span class="labeling"><?php echo  Yii::t('models/User', 'company_id'); ?>:</span>
			<?php echo $model->company_id ? $model->company->name : null; ?>
		<p>

		<p>
			<span class="labeling"><?php echo  Yii::t('models/User', 'email'); ?>:</span>
			<?php echo $model->email; ?>
		<p>

		<p>
			<span class="labeling"><?php echo  Yii::t('models/User', 'date_create'); ?>:</span>
			<?php echo $model->date_create; ?>
		<p>

		<p>
			<span class="labeling"><?php echo  Yii::t('models/User', 'list_products'); ?>:</span>
            <ul>
            <?php foreach ($model->products as $item) : ?>
                <li>
                    <?php echo $item->name; ?> 
                    <?php echo (ProductUser::model()->findByAttributes(array('is_used' => '1', 'product_id' => $item->id))) ? '(En uso)' : '';?>
                </li>
            <?php endforeach; ?>
            </ul>
		<p>

		<?php
		if($model->id != $model->company->user_id && Yii::app()->user->role != "general") {
			echo CHtml::link('<span class="fa fa-'.($model->active ? 'stop' : 'play').'"></span> '. Yii::t('base', $model->active ? 'Deactivate' : 'Activate'), 
				Yii::app()->createAbsoluteUrl('user/activate/?id='.$model->id), 
				array(
				'class' => 'btn btn-block mws-tooltip-s confirm-action btn-proces-'.($model->active ? 'red' : 'white'),
			));
		}
		?>

	</div>

</div>

<?php if(isset($ajaxRequest)): ?>
	</div> <!-- end panel-content -->
<?php endif; ?>