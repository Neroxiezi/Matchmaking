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

    public function upload_section(Request $request, $prefix = '/uploads')
    {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $findex = $request->input('index');
        $ftotal = $request->input('total');
        $fdata = $_FILES['data'];
        $fname = mb_convert_encoding($request->input('name'), "gbk", "utf-8");
        $path = $prefix;
        $dir = $path . "/video/";
        $save = $dir . $fname;
        if (!file_exists(public_path($dir))) {
            mkdir(public_path($dir), 0777, true);
        }
        $temp = fopen($fdata["tmp_name"], "r+");
        $filedata = fread($temp, filesize($fdata["tmp_name"]));
        if (file_exists(public_path($dir . "/" . $findex . ".tmp"))) unlink(public_path($dir . "/" . $findex . ".tmp"));
        $tempFile = fopen(public_path($dir . "/" . $findex . ".tmp"), "w+");
        //var_dump($tempFile);
        fwrite($tempFile, $filedata);
        fclose($tempFile);
        fclose($temp);

        @set_time_limit(5 * 60);

        //if (file_exists($save)) @unlink($save);
        for($i=1;$i<=$ftotal;$i++)
        {
            $readData = @fopen(public_path($dir."/".$i.".tmp"),"r+");
            $writeData = @fread($readData,filesize(public_path($dir."/".$i.".tmp")));
            //var_dump($writeData);
            $newFile = @fopen(public_path($save),"a+");
            fwrite($newFile,$writeData);
            if($newFile) fclose($newFile);
            if($readData) fclose($readData);
            @unlink(public_path($dir."/".$i.".tmp"));
        }
        return array("status" => "success", "url" => mb_convert_encoding($save, 'utf-8', 'gbk'));
    }
}