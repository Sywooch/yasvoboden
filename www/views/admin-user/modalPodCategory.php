<div class="ulChildren">
	<ul class="ulCartegory">
	  <?foreach ($category as $cat):?>
	      <li data-id="<?=$cat->id;?>"><?=$cat->name;?></li>
	  <?endforeach;?>
	</ul>
	<div class="ulChildren">
    </div>
</div>
       