/**
 * 画像アップロード
 * @return
 */
function jsAjaxUplad(_id){
    var _img = $("input[name=\'IMAGE_THUM_"+_id+"\']").val();
        
    $.ajax({
        url: '/members/fileUpload',
        type: 'post',
        async: false,
        dataType: 'text',
        data: {img_path:_img},
        timeout: 1000,
        error: function(){
            alert('イメージを取得に失敗!');
        },
        success: function(file){
               $('#IMG_VIEW').find("img").attr('src', file).attr('alt', 'イメージがありませんでした');
               $('input[name="data[Character][image_url]"]').val(file);
               alert("イメージを取得しました!");
        }
    });
}

/**
 * Google イメージ取得API
 * @return
 */
function OnLoad(){
    var imageSearch = new google.search.ImageSearch();
    // 一回の検索結果は8個取得(これが最大数)
    imageSearch.setResultSetSize(8);
    // 取得画像サイズは中
    imageSearch.setRestriction(
        google.search.ImageSearch.RESTRICT_IMAGESIZE,
        google.search.ImageSearch.IMAGESIZE_MEDIUM);
    // 検索完了時に呼び出されるコールバック関数を登録する
    imageSearch.setSearchCompleteCallback( this, SearchComplete, [ imageSearch ] );

    // 検索前に現在のイメージ情報を消す
    var imgList = document.getElementById( 'imgList' );
    imgList.innerHTML = '';

    // 検索を実行する
    var keyword = document.getElementById( 'searchImage' ).value;
    imageSearch.execute( keyword );
}


function SearchComplete( searcher ){
    // 結果オブジェクトを取得する
    var results = searcher.results;
    // cursorオブジェクト取得
    var current = searcher.cursor;             

    if(results && ( 0 < results.length )){
        // 現在のページ番号からリンクIDを取得  
        var page = current.currentPageIndex; 
        var addnum = page * 8 + 1;

        // 情報を取得する
        var imageDataHtml = '';
        for( var i = 0; i < results.length; i++ ){
            dataId = i + addnum;
            imageDataHtml += "<a class=\"mt10\" onclick=\"jsAjaxUplad(\'" + dataId + "\')\"><img src=\"" + results[ i ].tbUrl + "\" /></a>\n";
            imageDataHtml += "<input type=\"hidden\" name=\"IMAGE_THUM_" + dataId + "\" value=\"" + results[ i ].url + "\">\n";
        }
        document.getElementById( 'imgList' ).innerHTML += imageDataHtml; 
    }

    // 現在のページ番号  
    var currentPage = current.currentPageIndex; 
    if( currentPage < current.pages.length - 1 ){
        var nextPage = currentPage + 1;          // 次のページのページ番号
        searcher.gotoPage( nextPage ); // 次のページを検索する
    }
}

