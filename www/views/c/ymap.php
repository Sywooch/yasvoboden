<div id="modal-ymap">
	<div class="modal-ymap-inner">
		<a href="#" class="mfp-close"></a>
		<h2>Карта</h2>
		<div id="ymap"></div>
	</div><!-- end modal history inner -->
</div>

<script>
	ymaps.ready(init);
    var myMap;

    function init(){     
       
       	coord = [<?=$x?>, <?=$y?>];
        

        myMap = new ymaps.Map('ymap', {
            center: coord,
            zoom: 15
        });

        var dPlacemark = new ymaps.Placemark(coord);

        myMap.geoObjects.add(dPlacemark);
 
    };
</script>