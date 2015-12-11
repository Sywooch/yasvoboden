
$(document).on('click', '#s_okrug li', function(){
	a_link = $(this).children("a");
	
	$(".okrug-active").removeClass('okrug-active');
	$(a_link).addClass('okrug-active');

	id_okrug = $(a_link).attr('data-id');
	url = $("#u_regions").val();
	$("#id_okrug").val(id_okrug);
	$("#id_region").val("");

	$.ajax({
	   url: url,
	   data: 
	   {
	   		id_okrug: id_okrug
	   },
	   success: function(data){
	     $("#s_region").html(data);
	     $("#s_city").html("");
	     $("#id_city").val("");
	   }
	 });
});

$(document).on('click', '#s_region li', function(){
	a_link = $(this).children("a");

	$(".republic-active").removeClass('republic-active');
	$(a_link).addClass('republic-active');
 
	id_region = $(a_link).attr('data-id');
	url = $("#u_cityes").val();
	$("#id_region").val(id_region);

	$.ajax({
	   url: url,
	   data: 
	   {
	   		id_region: id_region
	   },
	   success: function(data){
	     $("#s_city").html(data);
	     $("#id_city").val("");
	   }
	 });
});

$(document).on('click', '#s_city li', function(){
	a_link = $(this).children("a");

	$(".town-active").removeClass('town-active');
	$(a_link).addClass('town-active');

	id_city = $(a_link).attr('data-id');
	$("#id_city").val(id_city);

	cityName = $(a_link).html();
});

$(document).on('click', '#setCityRegister', function(){
	id_city = $("#id_city").val();
	$("#id_city_register").val(id_city);

	if (id_city != "")
	{
		$("#cityName").html(cityName);
		$.magnificPopup.close();
	}
});

$(document).on('click', '#setCityNewRecord', function(){
	id_city = $("#id_city").val();

	if (id_city != "")
	{
		$("#b_city").html(cityName);
		$("#id_city_record").val(id_city);
		$.magnificPopup.close();
	}
});


