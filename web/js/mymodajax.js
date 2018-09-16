var BaseRecord1=(function() {
$(document).ready(function() {

BaseRecord1.autoload();

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
         $(".resultajax").html(data);
      },
   };
   $.ajax(ajaxSetting);
},

};
})();
