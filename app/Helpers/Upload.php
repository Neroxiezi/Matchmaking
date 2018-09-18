<?php
/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/9/4
 * Time: 11:44
 *
 *
 *                      _ooOoo_
 *                     o8888888o
 *                     88" . "88
 *                     (| ^_^ |)
 *                     O\  =  /O
 *                  ____/`---'\____
 *                .'  \\|     |//  `.
 *               /  \\|||  :  |||//  \
 *              /  _||||| -:- |||||-  \
 *              |   | \\\  -  /// |   |
 *              | \_|  ''\---/''  |   |
 *              \  .-\__  `-`  ___/-. /
 *            ___`. .'  /--.--\  `. . ___
 *          ."" '<  `.___\_<|>_/___.'  >'"".
 *        | | :  `- \`.;`\ _ /`;.`/ - ` : | |
 *        \  \ `-.   \_ __\ /__ _/   .-` /  /
 *  ========`-.____`-.___\_____/___.-`____.-'========
 *                       `=---='
 *  ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
 *           佛祖保佑       永无BUG     永不修改
 *
 */

namespace App\Helpers;


use Illuminate\Http\Request;

trait Upload
{
    public function upload_local(Request $request, $key = '', $prefix = 'uploads')
    {
        if (empty($key)) {
            return [
                'ret' => 10010,
                'msg' => '上传文件key为空！'
            ];
        }

        if (!$request->isMethod('POST')) {
            return [
                'ret' => 10011,
                'msg' => '上传方式不对！'
            ];
        }
        $file = $request->file($key);
        /**
         * 判断文件是否上传成功
         */
        if (!$file->isValid()) {
            return [
                'ret' => 10012,
                'msg' => '上传失败！'
            ];
        }
        $file_ext = $file->getClientOriginalExtension();
        $path = $this->_makePath($prefix);
        $dstPath = public_path($path);
        if (!file_exists($dstPath)) mkdir($dstPath, 0755, true);
        $filename = uniqid() . mt_rand(10000, 99999) . '.' . $file_ext;
        $originFilename = $file->getPathname();
        if (!move_uploaded_file($originFilename, $dstPath . '/' . $filename)) {
            return [
                'ret' => 10014,
                'msg' => '保存文件失败！'
            ];
        }
        return [
            'ret' => 200,
            'msg' => '文件上传',
            'data' => [
                'url' => '/' . $path . '/' . $filename
            ]
        ];
    }

    private function _makePath($prefix)
    {
        $path = date('Y/m/d/H');
        return strlen($prefix) > 0 ? $prefix . '/' . $path : $path;
    }

    public function upload_section(Request $request, $prefix = './uploads')
    {
        $findex = $request->input('index');
        $ftotal = $request->input('total');
        $fdata = $_FILES['data'];
        $fname = mb_convert_encoding($request->input('name'), "gbk", "utf-8");
        $path = $prefix;
        $dir = $path . "/video/";
        $save = $dir . $fname;
        if (!file_exists(asset($dir))) {
            mkdir(asset($dir), 0777, true);
            //chmod(asset($dir), 0777);
        }
        $temp = fopen($fdata["tmp_name"], "r+");
        $filedata = fread($temp, filesize($fdata["tmp_name"]));
        if (file_exists($dir . "/" . $findex . ".tmp")) unlink($dir . "/" . $findex . ".tmp");
        $tempFile = fopen($dir . "/" . $findex . ".tmp", "w+");
        fwrite($tempFile, $filedata);
        fclose($tempFile);
        fclose($temp);
        if (file_exists($save)) @unlink($save);
        for ($i = 1; $i <= $ftotal; $i++) {
            $readData = @fopen($dir . "/" . $i . ".tmp", "r+");
            $writeData = @fread($readData, filesize($dir . "/" . $i . ".tmp"));
            $newFile = @fopen($save, "a+");
            if ($newFile) fwrite($newFile, $writeData);
            if ($newFile) fclose($newFile);
            if ($readData) fclose($readData);
            @unlink($dir . "/" . $i . ".tmp");
        }
        return array("status" => "success", "url" => mb_convert_encoding($save, 'utf-8', 'gbk'));
    }
}