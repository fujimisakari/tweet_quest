$(document).ready(function() {
    $(".fancyview").fancybox({
        'width'             : '50%',
        'height'            : '60%',
        'padding'           : '3',
        // 'overlayShow'        : false,
        'overlayOpacity'    : '0.1',
        'autoScale'         : false,
        'overlayColor'      : '#000',
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'type'              : 'iframe'
    });
    
    $(".fancyview_result").fancybox({
        'padding'           : '3',
        // 'overlayShow'        : false,
        'overlayOpacity'    : '0.1',
        'autoScale'         : false,
        'overlayColor'      : '#000',
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'type'              : 'iframe'
    });
});

/**
 * Tweetボタンラッパー
 * @return
 */
function jsTweet(_action, _mode, _id) {
     if (_mode == 'noid') {
        $("#tweet").attr("action", _action);
        $("#tweet").submit();
     } else {
        $("#tweet").attr("action", _action + '?id=' + _id);
        $("#tweet").submit();
     }
}

/**
 * POSTボタンラッパー
 * @return
 */
function jsPost(_action, _mode, _id) {
     if (_mode == 'noid') {
        $("#form1").attr("action", _action);
        $("#form1").submit();
     } else if(_mode == 'del') {
        if (window.confirm('削除してもよろしいですか？')) {
            $("#form1").attr("action", _action + '?id=' + _id);
            $("#form1").submit();
            return true;
        }
            return false;
     } else {
        $("#form1").attr("action", _action + '?id=' + _id);
        $("#form1").submit();
     }
}
