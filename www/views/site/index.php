<?php
	/* @var $this yii\web\View */

	$this->title = 'Я Свободен!';
	
	use app\models\RImages;
	use yii\widgets\Breadcrumbs;
?>
<section id="main">
    <div class="container">
		<div class="main-left-fluid">
			<?if ($parent_cat):?>
				<div class="cat cat-gruz" style="background-image:url(./<?=$parent_cat->imagesDetail->src?>);">
					<?if (isset($params['breadcrumbs'])):?>
						<?= Breadcrumbs::widget([ 
				             'homeLink' => ['label' => 'Главная', 'url' => '/'],
				             'links' => isset($params['breadcrumbs']) ? $params['breadcrumbs'] : [],
				          ]) ?>
			        <?else:?>
			        	<a href="/">Главная</a>
			        <?endif;?>
		 			<h1><?=$parent_cat->name;?></h1>
					<p class="cat-offer"><span><?=$parent_cat->countItems;?></span>предложений</p>
				</div><!-- end cat -->
			<?endif;?>
			<div class="grid">
			    <?if (count($category) > 0):?> 
				    <?foreach ($category as $val):?>
				        <div class="grid-item grid-item--height2">
				            <a href="<?=$val->url;?>">
				            	<div class="grid-group-block" style="background-image: url('<?=$val->images['src'];?>');">
				            	</div> 
				            	<h2>
				            		<?=$val->name;?>
				            	</h2>
				            </a>
				        </div>
				    <?endforeach;?>
			    <?else:?>
			    	<div class="filter-row">
						<div class="noElements">Нет ни одного элемента!</div>
					</div>
			    <?endif;?>
			</div>
		</div>
		<div class="main-right-fluid">
			<?foreach ($reklama as $rekl):?>
				<div class="adv">
					<a href="http://<?=$rekl->link;?>"><img src="<?=$rekl->imageSrc?>" alt="img"></a>
				</div>
			<?endforeach;?>
		</div><!-- end right -->

	</div>
</section>

<?if (isset($parent_cat->relatedCategory) and (count($parent_cat->relatedCategory) > 0)):?>
	<section id="cat-bottom">
		<div class="container">
			<h4>Смотрите также:</h4>

			<div class="cat-bottom-row">
				<div class="grid">
					<?foreach ($parent_cat->relatedCategory as $rel_category):?>
						<div class="grid-item grid-item--height2">
							<a href="<?=$rel_category->relatedCategoryDetail->url;?>"> 
								<div class="grid-group-block" style="background-image: url('<?=$rel_category->relatedCategoryDetail->images['src'];?>');">
								</div>
								<h2>
									<?=$rel_category->relatedCategoryDetail->name;?>
								</h2>
							</a>
						</div>
					<?endforeach;?>
				</div>
			</div><!-- end cat-bottom-row -->
		</div>

	</section><!-- end cat bottom -->
<?endif;?>



 