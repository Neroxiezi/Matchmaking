<?php


/**
 * Created by PhpStorm.
 * User: 运营部
 * Date: 2018/9/3
 * Time: 15:38
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
use Illuminate\Support\Facades\Config;

trait BasicsTrait
{
    public function output_data($data)
    {
        $arr = [];
        $arr['code'] = Config::get('base.SUCCESS');
        $arr['data'] = $data;
        return response()->json($arr);
    }
    public function output_error($data)
    {
        $arr = [];
        $arr['code'] = Config::get('base.ERROR');
        $arr['data'] = $data;
        return response()->json($arr);
    }
}