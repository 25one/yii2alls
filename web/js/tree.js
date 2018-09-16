var BaseRecord=(function() {
$(document).ready(function() {
BaseRecord.autoload();
});

return {

autoload:function(){
   var ajaxSetting={
      method:"get",
      //url:"?r=tree/autoloadhook",
      //method:"post",
      url:"autoloadhook",
      success:function(data) {
         $(".container_dom_result").html(data);
         $('[src="filetemplate/add.png"]').click(function(){
             $(this).after('<input type="text" name="text_add_'+$(this).attr("name")+'" class="text_add" placeholder="enter the name of new sublevel for this level" /><img src="filetemplate/add_go.jpg" name="'+$(this).attr("name")+'" class="add_go" alt />');
             $(".text_add").focus().blur(function(){
                 setTimeout('$(".text_add").remove();$(".add_go").remove();', 250);
             });
             $('[src="filetemplate/add_go.jpg"]').click(function(){
                BaseRecord.add_update_remove($(this).attr("name"), "add", $("[name='text_add_"+$(this).attr("name")+"']").val());
                $(".text_add").remove(); $('[src="filetemplate/add_go.jpg"]').remove();
             });

             $(".text_add").keypress(function(){
                if(event.which==13) {
                   BaseRecord.add_update_remove($('[src="filetemplate/add_go.jpg"]').attr("name"), "add", $("[name='text_add_"+$('[src="filetemplate/add_go.jpg"]').attr("name")+"']").val());
                   $(".text_add").remove(); $('[src="filetemplate/add_go.jpg"]').remove();
                }
             });
         });
         $('[src="filetemplate/delete.png"]').click(function(){
           var remove_yes_no=confirm("Do you really want to delete this level(and his sublevels if they are in)?");
             if(remove_yes_no) {BaseRecord.add_update_remove($(this).attr("name"), "remove", "");}
         });
         $('[src="filetemplate/update.jpg"]').click(function(){
           $(this).after('<input type="text" name="text_update_'+$(this).attr("name")+'" class="text_update" />');
           var val_level_title=$('[name="level_title_'+$(this).attr("name")+'"]').html().replace("&nbsp;", "");
           $('[name="text_update_'+$(this).attr("name")+'"]').val(val_level_title);
           $('[name="level_title_'+$(this).attr("name")+'"]').remove();
           $('[name="text_update_'+$(this).attr("name")+'"]').focus();
           $('[name="text_update_'+$(this).attr("name")+'"]').blur(function(){
              BaseRecord.add_update_remove($(this).attr("name"), "update", $("[name='"+$(this).attr("name")+"']").val());
           });
           $('[name="text_update_'+$(this).attr("name")+'"]').keypress(function(){
              if(event.which==13) {
                 BaseRecord.add_update_remove($(this).attr("name"), "update", $("[name='"+$(this).attr("name")+"']").val());
              }
           });
         });

      }
   };
   $.ajax(ajaxSetting);
},

add_update_remove:function(who, what, val){
   var ajaxSetting={
      method:"get",
      //url:"?r=tree/addupdateremovehook&who="+encodeURIComponent(who)+"&what="+encodeURIComponent(what)+"&val="+encodeURIComponent(val),
      //method:"post",
      url:"addupdateremovehook?who="+encodeURIComponent(who)+"&what="+encodeURIComponent(what)+"&val="+encodeURIComponent(val),
      success:function(data) {
         BaseRecord.autoload();
      }
   };
   $.ajax(ajaxSetting);
},

};
})();
