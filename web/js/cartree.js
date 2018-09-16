var BaseRecord=(function() {
$(document).ready(function() {
   $(".ch").attr("checked", false);
   $("body").on("click", ".ch", function(){BaseRecord.checkedAll();});
});

return {

checked_all:"",

checkedAll:function() 
{
   this.checked_all = "";
   for(var i = 0; i < form_cartree.length; ++i) 
   {
       if(form_cartree.elements[i].type == "checkbox" && form_cartree.elements[i].checked) 
       {
          this.checked_all += form_cartree.elements[i].value+"#";
       }

   } 
   this.checked_all = this.checked_all.substr(0, this.checked_all.length-1); 
   this.ajaxSend();
},

ajaxSend:function() 
{
   var ajaxSetting={
      method:"post",
      url:"ajax-select?all="+encodeURIComponent(this.checked_all),      
      success:function(data) {
         $(".content").html("");
         var data_json=JSON.parse(data);
         for(var i=0; i<data_json.length; ++i) {
            $(".content").append("<b>"+data_json[i]["name"]+"</b><br>");
         }
      },
    };
   $.ajax(ajaxSetting);
},

};

})();