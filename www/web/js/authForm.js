$(document).on('click', '#btnAuth', function(){
	var login = $("#loginform-username").val();
	var password = $("#loginform-password").val();
	var csrf = $("input[name='_csrf']").val();
	var url = $("#formUrl").val(); 

	$.ajax({
	   url: url,
	   type: "POST",
	   data: 
	   {
	   		username: login,
	   		password: password,
	   		_csrf: csrf
	   },
	   success: function(data)
	   {
	   		resultData = jQuery.parseJSON(data);
	   		if (resultData.status == "ok")
	   		{
	   			
	   			$(".errorAuth").html("");
	   			$("#form-authorization").submit();
	   		}
	   		else
	   		{
	   			$(".errorAuth").html(resultData.error);
	   		} 
	   }
	 });

	return false;
});

$(document).on('click', '#send_forgout', function(){
	var email = $("#forgoutform-email").val();
	var csrf = $("input[name='_csrf']").val();
	var url = $("#formUrlForgout").val(); 
	obj = $(this).parent("div").parent("div").parent("form");

	$.ajax({
	   url: url,
	   type: "POST",
	   data: 
	   {
	   		email: email,
	   		_csrf: csrf
	   },
	   success: function(data)
	   {
	   		resultData = jQuery.parseJSON(data);
	   		if (resultData.status == "ok")
	   		{
	   			
	   			$(".errorAuthForgout").html("");
	   			$(obj).html("<div style='color: green;'>"+resultData.msg+"</div>");
	   		}
	   		else
	   		{
	   			$(".errorAuthForgout").html(resultData.error);
	   		} 
	   }
	 });

	return false;
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).ready(function(){
	auth = getUrlParameter("auth");

	if (auth == "on")
	{
		$.magnificPopup.open({
                items: {
                    src: '#modal-authorization',
                },
                type: 'inline'
            });
	}
});

