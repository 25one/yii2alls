var BaseRecord=(function() {
$(document).ready(function() {
   $("#workers-sociability").val("0");
   $("#workers-timemanagement").val("0");
   $("#workers-engineering").val("0");
   $("#workers-languages").val("0");
   $("body").on("change", ".upload_field", function(){form_upload.submit(); $("#img_photo").attr("src", "/img/loader.gif");});   
   $("body").on("change", "#workers-timemanagement", function(){
      $(".list_project").html("&nbsp;");  
      $("#workers-id_projects").val("");
      BaseRecord.timemanagement=this.value;
    });
   $("body").on("change", "#workers-id", function(){
      BaseRecord.changeProject(this.value, this.options[this.selectedIndex].text);
   });
   $("body").on("click", "[name='button_search']", function(){
      BaseRecord.ajaxSearch($("[name='text_search']").val());
   });  
   $("body").on("click", ".button_remove", function(){
      location.href="/removeworkers?id="+encodeURIComponent($(this).attr("id"))+"&photo="+encodeURIComponent($(this).attr("name"));
   });    
});

return {

timemanagement:0,

changeProject:function(id_project, name_project){
   if(this.timemanagement<10){
      $(".list_project").html('<li id="'+id_project+'">'+name_project+'</li>'); 
      $("#workers-id_projects").val(id_project);
   }
   else {
      $(".list_project").append('<li id="'+id_project+'">'+name_project+'</li>');
      $("#workers-id_projects").val($("#workers-id_projects").val()+"#"+id_project);
   }
},

ajaxSearch:function(value_search) {
   var ajaxSetting={
      method:"get",
      url:"listworkers?search="+encodeURIComponent(value_search),  
      success:function(data) {
         $(".tr_list").remove();
         var data_json=JSON.parse(data);
         var str="";
         for(var i in data_json) {
            str+='<div class="table_row tr_list"><div class="table_cell border">'+data_json[i]["name"]+'</div><div class="table_cell border center"><img src="/'+data_json[i]["photo"]+'" class="photo_format" alt="" /></div><div class="table_cell border middle">sociability:'+data_json[i]["sociability"]+'<br>engineering skills:'+data_json[i]["engineering"]+'<br>time management:'+data_json[i]["timemanagement"]+'<br>knowledge of languages:'+data_json[i]["languages"]+'<br>'+'</div><div class="table_cell border center">'+data_json[i]["result"]+'</div><div class="table_cell border center"><button type="button" id="'+data_json[i]['id']+'" class="button_remove btn btn-primary" name="'+data_json[i]["photo"]+'">remove</button></div></div>';
         }
         $(".table_list").append(str);
      },
    };
   $.ajax(ajaxSetting);     
},

};

})();