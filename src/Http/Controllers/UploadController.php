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
use Ramsey\Uuid\Uuid;

use EzApp\Upload\Services\UploadService;

class UploadController extends  Controller
{

    function image(Request $request , UploadService $uploadService)
    {
        $data = $uploadService->image($request);
        $fileInfo = array(
            'result' => true,
            'path' => $data,
        );
        if (config('upload.callback')) {
            $callback = config('upload.callback');
            return $callback($fileInfo);
        }else{
            return json_encode($fileInfo);
        }
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
            'path' => str_replace(public_path(), '', ($fullName)),
        );
        return $fileInfo;
    }
    public function token(){
        return json_encode(['token'=>csrf_token()]);
    }
}


