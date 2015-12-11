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

	$("#btnYesImage").click(function(){
		var magnificPopup = $.magnificPopup.instance;

		obj = magnificPopup.st.el;
		gen_obj = $(obj).parent("td").parent("tr");
		
		id_el = $(obj).attr("data-id");
		url = $("#urlImage").val();
		var csrf = $("#hidden-form-del-image input[name='_csrf']").val();

		$.ajax({
		   url: url,
		   type: "POST",
		   data: 
		   {
		   		id: id_el,
		   		_csrf: csrf
		   },
		   success: function(data){
		  
			   if (data == "true")
			   {
			   		$(gen_obj).remove();
			   }
			   $.magnificPopup.close();
		   }
		});
	});
});

$(document).on('click', '.modal-category ul li', function(){
	a_link = $(this).children("a");
	id_cat = $(a_link).attr("data-id");

	url = $("#pod_category").val();
	var csrf = $("input[name='_csrf']").val();

	$(".cat-active").removeClass("cat-active");

	$(a_link).addClass("cat-active");	

	obj = $(this).parent("ul").parent("div").children("div.ulCategory");

	if ($(this).hasClass("success"))
	{
		$("#setCategory").removeClass("disabled");
		$("#id_category").val(id_cat);
	}
	else 
	{
		if (!$("#setCategory").hasClass("disabled"))
			$("#setCategory").addClass("disabled");

		$("#id_category").val("");
	}

	$.ajax({
	   url: url,
	   type: "POST",
	   data: 
	   {
	   		id_category: id_cat,
	   		_csrf: csrf
	   },
	   success: function(data){
	  
	    if (data != "no")
	    {
	    	$(obj).html(data);
	 	}
	 	else
	 		$(obj).html("");
	   } 
	});
});


$(document).on('click', '.disabled', function(){
	return false;
});
 
$(document).on('click', '#showBlock', function(){

	
	$(this).parent("div").parent(".info-row").children("div").addClass("maxHeight");

	$(this).removeAttr("id");
	$(this).attr("id", "hiddenBlock");
	$(this).html("Свернуть");

	return false;
});

$(document).on('click', '#hiddenBlock', function(){

	$(this).parent("div").parent(".info-row").children("div").removeClass("maxHeight");

	$(this).removeAttr("id");
	$(this).attr("id", "showBlock");
	$(this).html("Развернуть");

	return false;
});
