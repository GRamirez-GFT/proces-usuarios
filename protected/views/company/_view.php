<p>
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
	<span class="labeling"><?php echo  Yii::t('models/Company', 'licenses'); ?>:</span>
	<?php echo $model->licenses; ?>
</p>

<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'storage'); ?>:</span>
	<?php echo $model->storage; ?> GB
</p>

<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'user_id'); ?>:</span>
	<?php echo $model->user->name ? $model->user->name : $model->user->username; ?>
</p>

<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'list_products'); ?>:</span>
	<ul>
	<?php foreach ($model->products1 as $product) :?>
		<li>
		<?php echo $product->name; ?>
		</li>
	<?php endforeach; ?>
	</ul>
</p>


<p>
	<span class="labeling"><?php echo  Yii::t('models/Company', 'list_ips'); ?>:</span>
	<ul>
	<?php foreach ($model->list_ips as $ip) :?>
		<li>
		<?php echo $ip;?>
		</li>
	<?php endforeach; ?>
	</ul>
</p>