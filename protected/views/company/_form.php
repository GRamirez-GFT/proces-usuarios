<div class="row">

	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'name'); ?>
			<?php echo $form->textField($model, 'name', array('maxlength' => 100)); ?>
			<?php echo $form->error($model, 'name'); ?>
		</div>

	</div>
<?php if(in_array(Yii::app()->user->role, array('global'))): ?>
	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'subdomain'); ?>
			<?php echo $form->textField($model, 'subdomain', array('maxlength' => 30)); ?>
			<?php echo $form->error($model, 'subdomain'); ?>
		</div>
		
	</div>
<?php endif; ?>

</div>

<div class="row">

	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'url_logo'); ?>
			<div class="upload-input btn btn-proces-white btn-block">
				<span class="fa fa-cloud-upload"></span>
				<?php echo $form->fileField($model, 'url_logo'); ?>
		    </div>
			<?php echo $form->error($model, 'url_logo'); ?>
		</div>

	</div>

<?php if(in_array(Yii::app()->user->role, array('global'))): ?>
	<div class="col-md-3">

		<div class="form-group">
		    <?php echo $form->labelEx($model, 'list_products'); ?>
			<?php echo $form->listBox($model, 'list_products',
			    CHtml::listData(Product::model()->findAll(array('condition' => 'company_id IS NULL')), 'id', 'name'),
			    array('multiple' => true)); ?>
			<?php echo $form->error($model, 'list_products'); ?>
		</div>
		
	</div>
<?php endif; ?>
	
</div>

<?php if(in_array(Yii::app()->user->role, array('global'))): ?>
<div class="row">

	<div class="col-md-3">

		<div class="form-group">
		    <?php echo $form->labelEx($model, 'licenses'); ?>
			<?php echo $form->textField($model, 'licenses'); ?>
			<?php echo $form->error($model, 'licenses'); ?>
		</div>
		
	</div>
	
</div>
<?php endif; ?>

<div class="row">

	<div class="col-md-3">

		<div class="form-group">
			<?php echo $form->labelEx($model, 'restrict_connection'); ?>
            <?php echo $form->checkBox($model, 'restrict_connection'); ?>
			<?php echo $form->error($model, 'restrict_connection'); ?>
		</div>

	</div>
	
	<div class="col-md-3 ips-wrapper" <?php echo ($model->restrict_connection) ? '' : 'style="display: none;"';?>>

		<div class="form-group">
           
            <?php echo $form->labelEx($model, 'list_ips'); ?>

            <?php foreach($model->list_ips as $key => $ip): ?>

                <div class="row duplicable-fields" style="margin-bottom: 5px;">

                    <div class="col-md-7" style="padding: 0;">
                        <?php echo CHtml::textField('CompanyModel[list_ips][]', !empty($ip) ? $ip : '', array('maxlength' => 45)); ?>
                    </div>

                    <div class="col-md-5">
                    <?php
                        echo CHtml::link('<span class="fa fa-plus-circle"></span>', '', 
                            array(
                            'class' => 'btn btn-proces-red add-row mws-tooltip-w',
                            'original-title' => Yii::t('base','Add IP'),
                            'style' => 'margin-top: 0; '
                        ));

                        echo CHtml::link('<span class="fa fa-times"></span>', '', 
                            array(
                            'class' => 'btn btn-proces-white remove-row mws-tooltip-w',
                            'original-title' => Yii::t('base','Remove IP'),
                            'style' => 'margin-top: 0; '.(($key > 0) ? '' : 'display: none;')
                        ));
                    ?>
                    </div>

                </div>

            <?php endforeach; ?>

            <?php echo $form->error($model, 'list_ips'); ?>

		</div>

	</div>

</div>

<script type="text/javascript">

    $(function(){
       
        
        $('body').on('click', '.add-row', function(e) {

            e.preventDefault(); 
            var thisElement = $(this);
            var thisRow = thisElement.parents('.duplicable-fields');

            if(thisRow.length) {

                var newRow = thisRow.clone();
                thisRow.after(newRow);

                var newRowInputs = newRow.find('input');
                newRowInputs.val('');

                var newRowSelects = newRow.find('select');
                newRowSelects.each(function(index, el) {
                    var thisSelect = $(this);
                    thisSelect.prev().remove();
                    createAjaxChoosen(thisSelect);
                });

                newRow.find('.errorMessage').remove();
                newRow.fadeOut(0).fadeIn('fast');
                newRowInputs.focus();

                if($('.duplicable-fields').length > 1) {
                    var removeFolioBtn = newRow.find('.remove-row');
                    removeFolioBtn.fadeIn('fast');
                }
            }
        });

        $('body').on('click', '.remove-row', function(e) {

            e.preventDefault(); 
            var thisElement = $(this);
            var thisRow = thisElement.parents('.duplicable-fields');

            thisRow.fadeOut('fast', function() {
                thisRow.remove();
                $('.tipsy').remove();
            });
        });
        
        $('#<?php echo CHtml::activeId($model, 'restrict_connection'); ?>').change(function(e){
            
            var thisElement = $(this);
            
            if(thisElement.is(":checked")) {
                $('.ips-wrapper').fadeIn('fast');
            } else {
                $('.ips-wrapper').fadeOut('fast');
            }
        });
        
    });
    
</script>

