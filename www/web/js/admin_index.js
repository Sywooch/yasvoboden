$(document).ready(function(){
	$("#btnNo").click(function(){
		$.magnificPopup.close();
	});

	$("#btnYes").click(function(){
		var magnificPopup = $.magnificPopup.instance;

		obj = magnificPopup.st.el;
		
		id_el = $(obj).attr("data-id");
		$("#id_element").val(id_el);

		$("#hidden-form").submit();
	});

	$("#btnYesField").click(function(){
		var magnificPopup = $.magnificPopup.instance;

		obj = magnificPopup.st.el;
		
		id_el = $(obj).attr("data-id");
		$("#id_element").val(id_el);

		$("#hidden-form-delete-field").submit();
	});

	$("#btnYesSelect").click(function(){
		var magnificPopup = $.magnificPopup.instance;

		obj = magnificPopup.st.el;
		
		id_el = $(obj).attr("data-id");
		$("#id_element").val(id_el);

		$("#hidden-form-delete-select").submit();
	});

	$("#btnYesOkrug").click(function(){
		var magnificPopup = $.magnificPopup.instance;

		obj = magnificPopup.st.el;
		
		id_el = $(obj).attr("data-id");
		$("#id_element").val(id_el);

		$("#hidden-form-delete-okrug").submit();
	});

	$("#btnYesRegion").click(function(){
		var magnificPopup = $.magnificPopup.instance;

		obj = magnificPopup.st.el;
		
		id_el = $(obj).attr("data-id");
		$("#id_element").val(id_el);

		$("#hidden-form-delete-region").submit();
	});

	$("#btnYesCity").click(function(){
		var magnificPopup = $.magnificPopup.instance;

		obj = magnificPopup.st.el;
		
		id_el = $(obj).attr("data-id");
		$("#id_element").val(id_el);

		$("#hidden-form-delete-city").submit();
	});

	$("#btnYesPrice").click(function(){
		var magnificPopup = $.magnificPopup.instance;

		obj = magnificPopup.st.el;
		
		id_el = $(obj).attr("data-id");
		$("#id_element_price").val(id_el);

		$("#hidden-form-delete-price").submit();
	});

	$("#selectAll").click(function(){
		if ($(this).prop('checked'))
			$('.check').prop('checked', true);
		else
			$('.check').prop('checked', false);
	});
});

$(document).on('click', '.ulCartegory li', function(){
	if (!$(this).hasClass("disabled"))
	{
		id = $(this).attr("data-id");
		obj = $(this).parent("ul").parent("div");

		if (!$(this).hasClass("disabledRel"))
		{
			$('.active').removeClass('active');
			$(this).addClass('active');
			$("#id_category").val(id);
		}
		url = $("#urlCategory").val();
		var csrf = $("input[name='_csrf']").val();

		
		
		$.ajax({
		   url: url,
		   type: "POST",
		   data: 
		   {
		   		id_category: id,
		   		_csrf: csrf
		   },
		   success: function(data){
		     if (data != "no")
		     	$(obj).children(".ulChildren").html(data);
		     else
		     	$(obj).children(".ulChildren").html("");
		   }
		 });
		
	}
});

$(document).on('click', '#setParentCategory', function(){
	id = $("#id_category").val();
	name = $("li[data-id='"+id+"']").html();

	$(".btnParentCategory").html(name);
	$("#parent_id").val(id);
	$.magnificPopup.close();
});

$(document).on('click', '#setParentCategoryRelated', function(){
	id = $("#id_category").val();
	name = $("li[data-id='"+id+"']").html();

	if (id != 0)
	{
		url = $("#urlAddRelCategory").val();

		$.ajax({
		   url: url,
		   type: "GET",
		   data: 
		   {
		   		id_rel_category: id
		   },
		   success: function(data){
		   		$("#relCategory").append("<li data-id='"+id+"'>"+name+"<span class='delRel'>Удалить</span></li>");
		   }
		 });
	}
	$.magnificPopup.close();
});

$(document).on('mouseenter', '#relCategory li', function(){
	$(".delRel").hide();
	$(this).children(".delRel").show();
});


$(document).on('mouseleave', '#relCategoryBlock', function(){
	$(".delRel").hide();
});

$(document).on('click', '.delRel', function(){
	id = $(this).parent("li").attr("data-id");
	obj = $(this).parent("li");
	url = $("#urlDelRel").val();

	$.ajax({
	   url: url,
	   type: "GET",
	   data: 
	   {
	   		id_rel_category: id
	   },
	   success: function(data){
	   		$(obj).remove();
	   }
	 });

});


$(document).on('click', '.b_filter', function(){
	id_field = $(this).val();
	url = $("#urlEditFilter").val();
	csrf = $("#form-edit-filter input[name='_csrf']").val();

	$.ajax({
	   url: url,
	   type: "POST",
	   data: 
	   {
	   		id_field: id_field,
	   		_csrf: csrf
	   }
	 });
});

$(document).on('click', '#setCityGeo', function(){
	id_city = $("#id_city").val();
	id_region = $("#id_region").val();
	id_okrug = $("#id_okrug").val();

	$("#id_city_filter").val(id_city);
	$("#id_region_filter").val(id_region);
	$("#id_okrug_filter").val(id_okrug);


	if (id_city != "")
		name = $("#s_city li a[data-id='"+id_city+"']").html();
	else if(id_region != "")
		name = $("#s_region li a[data-id='"+id_region+"']").html();
	else if(id_okrug != "")
		name = $("#s_okrug li a[data-id='"+id_okrug+"']").html();
	else
		name = "Выбрать";

	$("#selCity").html(name);
	$.magnificPopup.close();

});


$(document).on('click', '#setFilterCategory', function(){
	
	id_cat = $("#id_category").val();

	if (id_cat != 0)
	{
		name = $("li[data-id='"+id+"']").html();
	}
	else
		name = "Выбрать";

	$("#id_cat_filter").val(id_cat);

	$("#selCat").html(name);
	
	$.magnificPopup.close();

});

