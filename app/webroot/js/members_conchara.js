
/**
 * 画面表示の初期設定(合計パラメーターの取得)
 * @return
 */
$(document).ready(function(){
    var hp = $('#CharacterHitpoint').val() || '0';
    var attack = $('#CharacterAttack').val() || '0';
    var defense = $('#CharacterDefense').val() || '0';
    var speed = $('#CharacterSpeed').val() || '0';
    var lucky = $('#CharacterLucky').val() || '0';
    var total = parseInt(hp) + parseInt(attack) + parseInt(defense) + parseInt(speed) + parseInt(lucky);
    $("#totalparam").text(total);
});

/**
 * パラメーター入力数値チェック
 * @return
 */
function jsTotalParam(_formName){
    var hp = $('#CharacterHitpoint').val() || '0';
    var attack = $('#CharacterAttack').val() || '0';
    var defense = $('#CharacterDefense').val() || '0';
    var speed = $('#CharacterSpeed').val() || '0';
    var lucky = $('#CharacterLucky').val() || '0';
    var total = parseInt(hp) + parseInt(attack) + parseInt(defense) + parseInt(speed) + parseInt(lucky);
    
    var val = $("#" + _formName).val();
    if(val < 1){    
        alert("パラメーターは 0 以上を設定してください");
        $("#" + _formName).val("");
    } else if(total <= 150){
        $("#totalparam").text(total);
    } else if(isNaN(total)) {
        alert("半角数字以外設定できません");
        $("#" + _formName).val("");
    } else {
        alert("150以上は設定できません");
        var notCount = $("#"+ _formName).val() || '0';
        var ret = parseInt(total) - parseInt(notCount);
        $("#totalparam").text(ret);
        $("#" + _formName).val("");
    }
}                                              

