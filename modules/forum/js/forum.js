var BaseRecord2=(function() {
$(document).ready(function() {
$("body").on("click", ".baseapi", function(){BaseRecord2.baseapi();});
$("body").on("click", ".back", function(){location.href="?r=mymod/index";});
BaseRecord2.autoload();
});

return {

autoload:function(){
   var ajaxSetting={

      //method:"post",
      //url:"pageajax.php", //...ПРОСТО "ЗАТАЩИТЬ", НО, ?ТИПА, ДОЛЖЕН БЫТЬ В web...

      //method:"post",
      //url:"/views/mymod/pageajax.php", //...ПРОСТО "ЗАТАЩИТЬ" + МОЖЕТ БЫТЬ В ЕГО views...

      method:"get",         //...ВЫПОЛНЕНИЕ ИЗ КОТРОЛЛЕРА + ДАННЫЕ - ?ТОЛЬКО get...
      //url:"?r=mymod/pageajaxmethod&who="+encodeURIComponent('alex')+"&why="+encodeURIComponent('12345678'),
      url:"?r=mymod/pageajaxmethod",
      data:"who="+encodeURIComponent('alex')+"&why="+encodeURIComponent('12345678'),

      success:function(data){
         $(".forum_container").html(data);
      },
   };
   $.ajax(ajaxSetting);
},

baseapi:function(){
   var ajaxSetting={

      //method:"post",
      //url:"pageajax.php", //...ПРОСТО "ЗАТАЩИТЬ", НО, ?ТИПА, ДОЛЖЕН БЫТЬ В web...

      //method:"post",
      //url:"/views/mymod/pageajax.php", //...ПРОСТО "ЗАТАЩИТЬ" + МОЖЕТ БЫТЬ В ЕГО views...

      method:"get",         //...ВЫПОЛНЕНИЕ ИЗ КОТРОЛЛЕРА + ДАННЫЕ - ?ТОЛЬКО get...
      //url:"?r=mymod/pageajaxmethod&who="+encodeURIComponent('alex')+"&why="+encodeURIComponent('12345678'),
      url:"?r=forum/default/ajaxbaseapi",
      data:"what="+encodeURIComponent(777),

      success:function(data){
         $(".forum_container_money").html(data);
      },
   };
   $.ajax(ajaxSetting);
},

};
})();
