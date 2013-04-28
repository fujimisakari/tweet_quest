
/**
 * 画面表示の初期設定(合計パラメーターの取得)
 * @return
 */
$(document).ready(function(){
    var log = $("#log").val();
    var ret = log.split('<>');
    var i = 0;
    var max = ret.length;
  
    var si = setInterval(function(){
       // ダメージポイントを取得
       var dmeg = ret[i].split('|');

       // 現在の体力をダメージ受けた体力に差し替える
       if(dmeg[0] == "sen"){
          var shp = $("#shp").text();
          var cshp = parseInt(shp) - parseInt(dmeg[1]);
          if(cshp <= 10){
              $("table.sendata p").css("color","orange");
              $("table.sendata").css("border-color","orange");
              if(cshp < 1){
                  cshp = 0;
              }
          }
          if(dmeg[1] != 0){
              $("#sen_img").fadeOut(50).fadeIn(50).fadeOut(50).fadeIn(50).fadeOut(50).fadeIn(50);
          }
          $("#shp").text(cshp);
       } else if(dmeg[0] == "rec"){
          var rhp = $("#rhp").text();
          var crhp = parseInt(rhp) - parseInt(dmeg[1]);
          if(crhp <= 10){
              $("table.recdata p").css("color","orange");
              $("table.recdata").css("border-color","orange");
              if(crhp < 1){
                  crhp = 0;
              }
          }
          if(dmeg[1] != 0){          
              $("#rec_img").fadeOut(50).fadeIn(50).fadeOut(50).fadeIn(50).fadeOut(50).fadeIn(50);
          }
          $("#rhp").text(crhp);
       }
       $("#result_log").prepend(dmeg[2] + "<br />");
       i = i + 1;

       // 決着がついた場合
       if(parseInt(i) == parseInt(max)){
           max = max - 1;
           var result = ret[max].split('|');
           if(result[0] == "ret_sen"){
               $("table.sendata p").css("color", "red");
               $("table.sendata").css("border-color", "red");
               $("#sen_result p").text("LOOSE");
               $("#rec_result p").text("WIN");
               $("#sen_gray_img_block").css("display", "");
               $("#sen_img_block").css("display", "none");
           } else if(result[0] == "ret_rec"){
               $("table.recdata p").css("color","red");
               $("table.recdata").css("border-color","red");
               $("#sen_result p").text("WIN");
               $("#rec_result p").text("LOOSE");
               $("#rec_gray_img_block").css("display", "");
               $("#rec_img_block").css("display", "none");
           }
           $("#sen_result").css("display", "");
           $("#rec_result").css("display", "");
           $(".after_msg").css("display", "");
           clearInterval(si); // ループを停止
       }
    }, 2000 );  // 2秒おきに表示
});