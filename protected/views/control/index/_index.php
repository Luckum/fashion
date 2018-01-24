<h1><?=Yii::t('base', 'Products');?></h1>

<div class="row top-buffer">
	<ul class="ov_boxes">
		<li>
			<div class="ov_text">
				<strong><?=$products['totalCount']?> </strong>
				Products added
			</div>
		</li>							
	</ul>
</div>
<div class="row top-buffer">
	<ul class="ov_boxes">	
		<?php if (isset($products['category'])) : ?>
			<?php foreach ($products['category'] as $id => $value) : ?>	
				<li>
					<div class="ov_text">
						<strong><?=$value['count']?> </strong>
						<?=CHtml::encode($value['name'])?>
					</div>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</div>

<div class="row top-buffer">
	<canvas id="products_chart"></canvas>
</div>

<h3><?=Yii::t('base', 'Orders');?></h3>

<div class="row top-buffer">
	<ul class="ov_boxes">
		<li>
			<div class="ov_text">
				<strong><?=$orders['totalCount']?> </strong>
				Orders created
			</div>
		</li>							
	</ul>
</div>
<div class="row top-buffer">
	<ul class="ov_boxes">	
		<?php foreach ($orders['orders'] as $status => $value) : ?>	
			<li>
				<div class="ov_text">
					<strong><?=$value['count']?> </strong>
					<?=CHtml::encode($value['name'])?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
</div>

<div class="row top-buffer">
	<canvas id="orders_chart"></canvas>
</div>

<h3><?=Yii::t('base', 'Users');?></h3>

<div class="row top-buffer">
	<ul class="ov_boxes">
		<li>
			<div class="ov_text">
				<strong id="users_count"><?= $users['count_sellers'] + $users['count_buyers'] ?> </strong>
				New users sign up
			</div>
		</li>							
	</ul>
</div>
<div class="row top-buffer">
	<ul class="ov_boxes">						
		<li>
			<div class="ov_text">
				<strong id="buyers_count"><?= $users['count_buyers'] ?> </strong>
				Buyer
			</div>
		</li>
		<li>
			<div class="ov_text">
				<strong id="sellers_count"><?= $users['count_sellers'] ?> </strong>
				Seller
			</div>
		</li>
	</ul>
</div>

<div class="row top-buffer">
	<canvas id="users_chart"></canvas>
</div>