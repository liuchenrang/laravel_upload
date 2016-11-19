<?php
namespace EzApp\Upload\Http\Conttrollers;

/**
 * Created by PhpStorm.
 * User: XingHuo
 * Date: 16/6/25
 * Time: 下午7:03
 */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Rhumsaa\Uuid\Uuid;

use EzApp\Upload\Service\UploadService;

class UploadController extends  Controller
{

    function image(Request $request , UploadService $uploadService)
    {
        $uuid4 = Uuid::uuid4();
        $uuid = strtoupper($uuid4->toString());
        $allowed_extensions = config('upload.allow_ext');
        $currentDir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : config('upload.base_path');
        $topic = $request->input('topic');
        $fileName = 'file';
        $file = $request->file($fileName);

        $extension = $file->getClientOriginalExtension();

        $urlPath = $uploadService->getUploadUrlPath(config('upload.server.local'));

        $savePath = rtrim($currentDir,'/') .  rtrim($urlPath,'/');

        if ($extension && !in_array(strtolower($extension), $allowed_extensions)) {
            return response()->json(['error' => 'You may only upload '], 406);
        }
        $allowSize = config('upload.size');
        if (!in_array($topic, array_keys($allowSize))) {
            return response()->json(['error' => 'topic not support!'], 406);
        }
        is_dir($savePath) || mkdir($savePath, 0700, true);
        $saveName = $uploadService->getUploadSaveName($extension);
        $file->move($savePath,$saveName);
        $fullName = $uploadService->getFullPath($savePath,$saveName);
        $sizes = $allowSize[$topic];
        if ($sizes) {
            foreach ($sizes as $size) {
                list($width, $height) = $size;
                list($picwidth, $picheight) = getimagesize($fullName);
                list($nowWidth, $nowHeight) = $uploadService->reSize($picwidth, $picheight, $width, 0);
                $reSizeSaveName = $uuid . '.' . $width . 'x0.' . $extension;
                $reSizeName = $savePath . $reSizeSaveName;
                Image::make($fullName)->resize($nowWidth, $nowHeight)->save($reSizeName);
            }

        }

        $fileInfo = array(
            'result' => true,
            'path' => str_replace(base_path(), '', ($fullName)),
        );
        return $fileInfo;
    }

    function file(Request $request, UploadService $uploadService)
    {
        $currentDir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : config('upload.base_path');

        $file = $request->file('file');
        $urlPath = $uploadService->getUploadUrlPath(config('upload.server.local'));

        $savePath = rtrim($currentDir,'/') .  rtrim($urlPath,'/');

        is_dir($savePath) || mkdir($savePath, 0700, true);

        $extension = $file->getClientOriginalExtension();
        $saveName = $uploadService->getUploadSaveName($extension);

        $fullName = $uploadService->getFullPath($savePath,$saveName);

        $file->move($savePath,$saveName);
        $fileInfo = array(
            'result' => true,
            'path' => str_replace(base_path(), '', ($fullName)),
        );
        return $fileInfo;
    }
    function token(){
        return json_encode(['token'=>csrf_token()]);
    }
}


function uploadImg()
{

}
