var BaseRecord=(function() {
$(document).ready(function() {

$("body").on("click", ".btn.btn-primary", function(){BaseRecord.AjaxSpecialValidation($(".login_field").val(), $(".password_field").val(), $(".select_field").val(), $(".link_language").attr("value"));});
$("body").on("click", ".fa.fa-update", function(){BaseRecord.AjaxWindowUpdate($(this).attr("name"), $(this).attr("value"));return false;});

});

var win;

return {

AjaxSpecialValidation:function(login, pass, category, language){
   var ajaxSetting={
      method:"get",
      url:"ajaxspecialvalidation?login="+encodeURIComponent(login)+"&pass="+encodeURIComponent(pass)+"&category="+encodeURIComponent(category)+"&language="+encodeURIComponent(language),
      success:function(data){
         $(".title_error_access").html(data);
      },
   };
   $.ajax(ajaxSetting);
},

AjaxWindowUpdate:function(model_name, id){
win=window.open('', 'win1', 'width=300, height=300, left='+(screen.width-300)/2+', top='+(screen.height-300)/2+', scrollbars=1');
   var ajaxSetting={
      method:"post",
      url:"surprisenew-lead-update-select?model_name="+encodeURIComponent(model_name)+"&id="+encodeURIComponent(id),
      success:function(data){
         var data_json=JSON.parse(data);
         win.document.write('<html><body><head><link href="css/app.css" rel="stylesheet"><link href="css/mylogin.css" rel="stylesheet"></head>');
         win.document.write('<form name="form_win">');
         win.document.write('<input type="hidden" name="text_id_hidden" value="'+id+'" />');
         win.document.write('<div class="win"');
         win.document.write('<div class="win_row"><div class="win_cell_title">Name</div><div class="win_cell_content"><input type="text" style="margin-top:10px;" name="text_name" value="'+data_json[0]['name']+'" /></div></div>');
         win.document.write('<div class="win_row"><div class="win_cell_title">Limit for all</div><div class="win_cell_content"><input type="text" style="margin-top:10px;" name="text_limit_for_all" value="'+data_json[0]['limit_for_all']+'" /></div></div>');
         win.document.write('<div class="win_row"><div class="win_cell_title">Limit for one</div><div class="win_cell_content"><input type="text" style="margin-top:10px;" name="text_limit_for_one" value="'+data_json[0]['limit_for_one']+'" /></div></div>');
         win.document.write('<div class="win_row"><div class="win_cell_title">Status</div><div class="win_cell_content"><input type="text" style="margin-top:10px;" name="text_status" value="'+data_json[0]['status']+'" /></div></div>');
         win.document.write('<div class="win_row"><div class="win_cell_title"><input type="button" style="margin-top:10px;" name="button_win" value="Save" onclick="window.opener.BaseRecord.AjaxSaveUpdate(text_id_hidden.value, text_name.value, text_limit_for_all.value, text_limit_for_one.value, text_status.value);" /></div><div class="win_cell_content">&nbsp;</div></div>');
         win.document.write('<div class="win_row"><div class="win_cell_title">&nbsp;</div><div class="win_cell_content"><span id="win_error" style="color:red;font-weight:bolder;">&nbsp;</span></div></div>');
         win.document.write('</div>');
         win.document.write('</form>');
        win.document.write('</body></html>');
     },
   };
   $.ajax(ajaxSetting);
},

AjaxSaveUpdate:function(id, name, limit_for_all, limit_for_one, status){
   var ajaxSetting={
     method:"post",
     url:"surprisenew-lead-update-save?id="+encodeURIComponent(id)+"&name="+encodeURIComponent(name)+"&limit_for_all="+encodeURIComponent(limit_for_all)+"&limit_for_one="+encodeURIComponent(limit_for_one)+"&status="+encodeURIComponent(status),
     success:function(data){
         if(data) {
            win.document.getElementById("win_error").innerHTML=data;
         }
         else {
            win.close();
            location.href='/login';
         }
      },
   };
   $.ajax(ajaxSetting);
},

};
})();
