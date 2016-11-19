<?php
namespace EzApp\Upload\Services;
/**
 * Created by PhpStorm.
 * User: XingHuo
 * Date: 16/6/25
 * Time: 下午7:13
 */
use Rhumsaa\Uuid\Uuid;

class UploadService
{

    /**
     * 【等比例】计算“需要进行处理的图片”的“新”的高度和宽度
     *
     * @param int $_w
     * @param int $_h
     * @param int $max_w
     * @param int $max_h
     * @return array array($new_w, $new_h)
     */
    function reSize($_w, $_h, $max_w, $max_h) {
        if($max_w < 0 || $max_h < 0 || ($max_w==0 && $max_h==0)) throw new Exception('max_w or max_h <= 0, or both is zero.');
        if ($max_w == 0) {
            $max_w = $_w;
        } elseif ($max_h == 0) {
            $max_h = $_h;
        }
        if($_w > $max_w || $_h > $max_h) {
            $x_ratio = $max_w / $_w;
            $y_ratio = $max_h / $_h;
            if (($x_ratio * $_h) < $max_h) {
                $new_h = floor ( $x_ratio * $_h );
                $new_w = $max_w;
            } else {
                $new_w = floor ( $y_ratio * $_w );
                $new_h = $max_h;
            }
        } else {
            $new_w = $_w;
            $new_h = $_h;
        }
        return array ($new_w, $new_h );
    }
    function getUploadUrlPath($saveServer){
        return "/$saveServer".date('/Y/m/d/');
    }
    function getUploadSaveName($extName){
        $uuid4 = Uuid::uuid4();
        $uuid = strtoupper($uuid4->toString());
        return $uuid.'.'.trim($extName,'.');
    }
    function getFullPath($savePath,$saveName){
        return rtrim($savePath,'/') . '/' .ltrim($saveName,'/');
    }
    static function getServerFileUrl($urlPath){
        return rtrim(config('upload.image_url'),'/') . '/' . rtrim($urlPath,'/');
    }

}