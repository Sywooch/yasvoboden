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

    $(".bad_record").click(function(){
        id = $(this).attr("data-el");
        url = $("#urlBadRecord").val();
        var csrf = $("#hidden-form-bad-record input[name='_csrf']").val();

        $.ajax({
                url: url,
                type: "POST",
                data:  
                { 
                    "id": id,
                    _csrf: csrf
                },
                success: function(data) 
                {
                    alert("Спасибо за информацию! Мы обязательно рассмотрим данное предложение.");
                }
        });

        return false;
    });
});