<div class="ulChildren">
	<ul class="ulCartegory">
	  <?foreach ($category as $cat):?>
	      <li data-id="<?=$cat->id;?>" <?if (($cat->id == $r_cat->id) or ($r_cat->is_rel($cat->id))):?>class="disabledRel"<?endif;?>><?=$cat->name;?></li>
	  <?endforeach;?>
	</ul>
	<div class="ulChildren">
    </div>
</div>
       