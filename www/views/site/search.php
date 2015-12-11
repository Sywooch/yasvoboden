<?php
	use yii\helpers\Url;
	/* @var $this yii\web\View */

	$this->title = 'Я Свободен!';

	use yii\widgets\Breadcrumbs;
	use yii\widgets\LinkPager;
?>
<section id="main">
    <div class="container">
		<div class="main-left">
			<div class="cat cat-gruz" style="background: #90948C;">
		        <a href="/">Главная</a> -> <a href="#">Поиск</a>
				<h1>Строка запроса: "<?=$searchForm->search?>"</h1>
				<p class="cat-offer"><span><?=count($items)?></span>предложения</p>
			</div><!-- end cat -->
			<section id="filter">
				<?if (count($items) > 0):?>
					<?foreach ($items as $item):?>
						<div class="filter-row">
							<div class="filter-time">
								<div class="filter-time-inner">
									<p class="i_city"><?=$item->geo?></p>
									<img src="images/all/clock.jpg" alt="время">
									<div class="f-time">
										<p><span><?=$item->timeBack["real_value"]?></span> <?=$item->timeBack["izmerenie"]?></p>
										<p>назад</p>
									</div>
									<div class="pogalovatsa">
										<a href="#" class="bad_record" data-el="<?=$item->id;?>"><img src="img/ploho.png" title="По нажатию на данную кнопку, вы пожалуетесь на данное предложение Администрации сайта!"></a>
									</div>
								</div>
							</div><!-- end filter-time -->
							<div class="filter-img">
								<div class="filter-img-inner">
									<div class="lightgallery">
										<?$class = "";?>
										<?foreach ($item->images as $image):?>
											<a href="<?=$image->src?>">
											    <img src="<?=$image->src?>" <?=$class;?>/>
										    </a>
											<?$class = "class='hide'";?>
										<?endforeach;?>
									</div>
								</div>
							</div><!-- end filter-img -->
							<div class="filter-product">
								<div class="filter-product-inner">
									<h4><?=$item->name?></h4>
									<div class="filter-product-row">
										<div class="filter-product-left">
											<p>цена</p>
										</div>
										<div class="filter-product-right">
											<?foreach ($item->prices as $price):?>
												<p><?=$price->value?> <?=$price->unit->name?></p>
											<?endforeach;?>
										</div>
									</div><!-- end filter-product-row -->
									<div class="filter-product-row">
										<div class="filter-product-left">
											<p>Телефон</p>
										</div>
										<div class="filter-product-right">
											<a href="#" class="phone_field" data-element="<?=$item->id?>">посмотреть</a>
										</div>
									</div><!-- end filter-product-row -->
								</div>
							</div><!-- end filter-product -->
							<div class="filter-desc">
								<div class="filter-desc-inner">
									<p><?=$item->description?></p>
								</div>
							</div><!-- end filter-desc -->
							<div class="filter-data">

								<div class="filter-data-inner">
									<?foreach ($item->fields as $field):?>
										<div class="filter-data-inner-row">
											<p><?=$field->typeField->name;?></p>
											<p><span><?=$field->val;?></span> <?=$field->typeField->unit;?></p>
										</div>
									<?endforeach;?>
								</div>
							</div>
							<?if ($item->isShowBtn(360) or (count($item->fields) > 6)):?>
								<div class="showHidden"><a href="#" id="showBlockItem">Развернуть</a></div>
							<?endif;?>
						</div><!-- end filter-row -->
					<?endforeach;?>
				<?else:?>
					<div class="filter-row">
						<div class="noElements">Нет ни одного элемента!</div>
					</div>
				<?endif;?>
			</section>

			<div class="pagination">
				<?=LinkPager::widget(['pagination' => $pages,]);?>
			</div>
		</div>
		<?if (isset($parent_cat->relatedCategory) and (count($parent_cat->relatedCategory) > 0)):?>
			<div class="main-right">
				<div class="sidebar-category">
					<h3>Смотрите также:</h3>
					<?foreach ($parent_cat->relatedCategory as $rel_category):?>
						<div class="grid-item grid-item--height2">
							<a href="<?=$rel_category->relatedCategoryDetail->url;?>">
								<img src="<?=$rel_category->relatedCategoryDetail->images['src'];?>" alt="авто">
								<h2><?=$rel_category->relatedCategoryDetail->name;?></h2>
								<p><span>12 452</span> предложения</p>
							</a>
						</div>
					<?endforeach;?>
				</div><!-- end sidebar category -->
			</div><!-- end right -->
		<?endif;?>

	</div>
</section>

<script>
	$('document').ready(function(){
        $(".phone_field").click(function(){
            id = $(this).attr("data-element");
           
            obj = $(this).parent("div");
            $.ajax({
                    url: "index.php?r=site/get-phone",
                    data:  
                    { 
                        "id": id
                    },
                    success: function(data) 
                    {
                        result = jQuery.parseJSON(data);

                        if (result.status == "ok")
                        {
                            $(obj).html(result.result);
                        }
                    }
            });
           
            return false;
        });
   });
</script>

 <?$this->registerJsFile('js/item_index.js');?>

 