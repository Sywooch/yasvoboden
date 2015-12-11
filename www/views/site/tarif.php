<?
	$this->title = $page->title;
?>
<section id="main">
    <div class="container">
    	<div id="page">

    		<h1><?=$page->title?></h1>
    		<div>
    			<?=$page->text;?>
    		</div>

    		<table class="features-table">
    			<thead>
	    			<tr>
	    				<td><b>Название категории</b></td>
	    				<td><b>Цена размещения, руб</b></td>
	    				<td><b>Время размещения, ч</b></td>
	    			</tr>
    			</thead>
    			<tbody>
	    			<?foreach($categories as $cat):?>
	    				<tr>
	    					<td>
	    						<?if (isset($cat->parent)):?>
	    							<?=$cat->parent->name?> &#8658; 
	    						<?endif;?>
	    						<?=$cat->name?>
	    					</td>
	    					<?if (isset($cat->priceCategory)):?>
		    					<td><?=$cat->priceCategory->price?></td>
		    					<td><?=$cat->priceCategory->timeText?></td>
	    					<?else:?>
	    						<td>0</td>
	    						<td>0</td>
	    					<?endif;?>
	    				</tr>
	    			<?endforeach;?> 
    			</tbody>
    		</table>
    	</div>
    </div>
</section>