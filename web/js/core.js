var BaseRecord=(function() {
$(document).ready(function() {
$("body").on("click", ".bet, .win, .deposit", function(){BaseRecord.AjaxSend($(this).attr("name"));});

});

return {

AjaxSend:function(event){

   var ajaxSetting={
      //...work...
      //method:"get",
      //url:"?r=core/fromcore",
      //data:"event="+encodeURIComponent(event),
      //...work...
      //...house...
      method:"get",   //...ТОГДА МОЖЕТ БЫТЬ И post...
      url:"fromcore", //...!!!...
      data:"event="+encodeURIComponent(event),
      //...house...
      success:function(data){
         $(".result").html(data);
      },
   };
   $.ajax(ajaxSetting);
},

};
})();
