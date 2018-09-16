var BaseRecord=(function() {
$(document).ready(function() {

//$("body").on("click", ".btn_login", function(){BaseRecord.validate(login_form.login.value, login_form.password.value);}); //???!!!...login, password - МЕНЯТЬ НЕБЕЗОПАСНО - ТИПА ЗАРЕЗЕРВИРОВАНЫ...
$("body").on("click", ".btn_login", function(){BaseRecord.validate($(".login_field").val(), $(".password_field").val());});
$("body").on("keypress", ".login_field, .password_field", function(){if(event.which==13){BaseRecord.validate($(".login_field").val(), $(".password_field").val());return false;}});
$("body").on("click", ".button_hello", function(){location.href="?r=mymod/hello";});
$("body").on("click", ".button_nature", function(){location.href="?r=mymod/page&view=nature";});
$("body").on("click", ".button_module_forum", function(){location.href="?r=forum/default";});
//...request...
//...get-location...
$("body").on("click", ".button_request_get", function(){location.href="?r=mymod/requestpage&guest="+$(".text_request_get").val();});
$("body").on("keypress", ".text_request_get", function(){if(event.which==13){location.href="?r=mymod/requestpage&guest="+$(".text_request_get").val();return false;}});
//...get-location...
//...post-form...
$("body").on("click", ".button_request_post", function(){form_request_post.submit();});
$("body").on("keypress", ".text_request_post", function(){if(event.which==13){form_request_post.submit();return false;}});
//...post-form...
//...get-ajax-JSON...
$("body").on("click", ".button_ajax_get", function(){BaseRecord.ajaxjson($(".text_ajax_get").val());});
$("body").on("keypress", ".text_ajax_get", function(){if(event.which==13){BaseRecord.ajaxjson($(".text_ajax_get").val());return false;}});
//...get-ajax-JSON...
//...download-ajax... - ТУТ НЕ РАБОТАЕТ - НУЖНА ПЕРЕЗАГРУЗКА...
//$("body").on("click", ".button_ajax_download", function(){BaseRecord.ajaxdownload('filetemplate/hello.jpg');});
//...download-ajax... - ТУТ НЕ РАБОТАЕТ - НУЖНА ПЕРЕЗАГРУЗКА...
//...download-get...
$("body").on("click", ".button_download", function(){location.href="?r=mymod/filedownload&filename=filetemplate/hello.jpg";});
//...download-get...
//...request...
});

return {

validate:function(login, password){
var r=/^\w+$/i;
if(!r.test(login) || !r.test(password)) {
$(".elem_title_error").html("Bad format of field!");
}
else {
login_form.submit();
}
},

ajaxjson:function(value){
   var ajaxSetting={
      method:"get",
      url:"?r=mymod/requestpage",
      //url:"index/mymod/requestpostajax",
      data:"requestajax=true&guest="+encodeURIComponent(value),
      success:function(data){
         //$(".request_place_ajax").html(data);
         var data_json=JSON.parse(data);
         $(".request_place_ajax").html("<ul><li>"+data_json['title']+"</li><li>"+data_json['method']+"</li></ul>");
      },
   };
   $.ajax(ajaxSetting);
},

/*
ajaxdownload:function(filename){
   var ajaxSetting={
      method:"get",
      url:"?r=mymod/ajaxdownload",
      //url:"index/mymod/requestpostajax",
      data:"filename="+encodeURIComponent(filename),
      success:function(data){
         $(".request_place_ajax").html(data);
      },
   };
   $.ajax(ajaxSetting);
},
*/

};
})();
