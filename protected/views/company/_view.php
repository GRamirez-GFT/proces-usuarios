<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'url_logo'); ?>:</span>
	<span class="logo-details">
		<img src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . Yii::app()->baseUrl .DIRECTORY_SEPARATOR.$model->url_logo; ?>" />
	</span>
</p>

<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'name'); ?>:</span>
	<?php echo $model->name; ?>
</p>

<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'subdomain'); ?>:</span>
	<?php echo $model->subdomain; ?>
</p>

<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'user_id'); ?>:</span>
	<?php echo $model->user->name ? $model->user->name : $model->user->username; ?>
</p>

<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'list_products'); ?>:</span>
	<ul>
	<?php foreach ($model->list_products as $productId) :?>
		<li>
		<?php 
			$thisProduct = Product::model()->findByPk($productId);
			echo $thisProduct->name; 
		?>
		</li>
	<?php endforeach; ?>
	</ul>
</p>