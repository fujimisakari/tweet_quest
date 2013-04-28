<?php

$ob = new thumb();

if(isset($_GET["h"])){
    if($_GET["h"]==""){$_GET["h"] = 540;}
}else{
    $_GET["h"] = 540;
}

if(!isset($_GET["w"])){
    $_GET["w"] = "";
}

if(!is_file($_GET["i"])){
	if($_GET["w"] <= 145){
		// $_GET["i"] = "./img/no_img_s.jpg";
	}else{
		// $_GET["i"] = "./img/no_img.jpg";
	}
}

list($Ck,  $Msg) = $ob->Main($_GET["i"],  $_GET["w"],  $_GET["h"]);
if(!$Ck) {header("Content-Type: text/html; charset=utf-8");print $Msg;}


class thumb {
	function Main($Path,  $MW,  $MH) {
		$imgMaxWidth = 480;// 画像の最大横幅（デフォルト値）
		$imgMaxHeight = 640;// 画像の最大縦幅（デフォルト値）


	    if(isset($_GET['ov'])){	
		    if($_GET['ov']==1){
			    $ovFlag = 1;
		    }
        }

		if (!is_file($Path)) {
			$Path = "imgs/noimage.jpg";
		}
		
		if(!isset($Path)) {return array(0, "イメージのパスが設定されていません。");exit;}
		if(!file_exists($Path)) {return array(0, "指定されたパスにファイルが見つかりません。");exit;}

		// 画像の大きさをセット
		if($MW) $imgMaxWidth = $MW;
		if($MH) $imgMaxHeight = $MH;
		$size = @GetImageSize($Path);
		$re_size = $size;

		//アスペクト比固定処理
		$tmp_w = $size[0] / $imgMaxWidth;
		if($imgMaxHeight != 0){
			$tmp_h = $size[1] / $imgMaxHeight;
		}

		if($tmp_w > 1 || $tmp_h > 1){
			if($imgMaxHeight == 0){
				if($tmp_w > 1){
					$re_size[0] = $imgMaxWidth;
					$re_size[1] = $size[1] * $imgMaxWidth / $size[0];
				}
			} else {
				if($tmp_w > $tmp_h){
					$re_size[0] = $imgMaxWidth;
					$re_size[1] = $size[1] * $imgMaxWidth / $size[0];
				} else {
					$re_size[1] = $imgMaxHeight;
					$re_size[0] = $size[0] * $imgMaxHeight / $size[1];
				}
			}
		}

		switch($size[2]):
			case "1":// gif形式
			    /* 空の画像を作成します */
			    $imgNew = imagecreatetruecolor ($re_size[0], $re_size[1]);
			    $bgc = ImageColorClosest ($imgNew, 255, 255, 255);
			    imagefilledrectangle ($imgNew, 0, 0, $re_size[0], $re_size[1], $bgc);
				
				$imgDef = ImageCreateFromGif($Path);
				ImageCopyResampled( $imgNew,  $imgDef,  0,  0,  0,  0, $re_size[0],  $re_size[1], $size[0],  $size[1]);
				//サムネイル画像生成
				header("Content-Type: image/gif");
				ImageGif($imgNew);
				ImageDestroy($imgDef);
				ImageDestroy($imgNew);
				
				break;
			case "2": // jpg形式
				/* 空の画像を作成します */
				$imgNew = ImageCreateTrueColor($re_size[0], $re_size[1]);
				$imgDef = ImageCreateFromJpeg($Path);
				ImageCopyResampled( $imgNew,  $imgDef,  0,  0,  0,  0, $re_size[0],  $re_size[1], $size[0],  $size[1]);
				//サムネイル画像生成
				header("Content-Type: image/jpeg");
				ImageJpeg($imgNew);
				ImageDestroy($imgDef);
				ImageDestroy($imgNew);
				
				break;
			case "3": // png形式
				/* 空の画像を作成します */
				$imgNew = ImageCreateTrueColor($re_size[0], $re_size[1]);
				$imgDef = ImageCreateFromPng($Path);
				ImageCopyResampled( $imgNew,  $imgDef,  0,  0,  0,  0, $re_size[0],  $re_size[1], $size[0],  $size[1]);
				header("Content-Type: image/png");
				ImagePNG($imgNew);
				ImageDestroy($imgDef);
				ImageDestroy($imgNew);
				
				break;
			default:// どれでもない場合
				return array(0, "イメージの形式が不明です。");
				exit;
		endswitch;
		return array(1,"");
	}
}
?>
