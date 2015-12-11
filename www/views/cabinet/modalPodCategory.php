<div class="ulChildren">
	<ul class="ulCartegory">
	  <?foreach ($category as $cat):?>
	      <li data-id="<?=$cat->id;?>" <?if ($cat->id == $r_cat->id):?>class="disabled"<?endif;?>><?=$cat->name;?></li>
	  <?endforeach;?>
	</ul>
	<div class="ulChildren">
    </div>
</div>
       