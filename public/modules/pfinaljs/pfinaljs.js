define(['jquery','lodash'], function ($,_) {
    return {
        //模态框
        modal: function (options, callback) {
            require(['component/modal'], function (modal) {
                modal(options, callback);
            })
        }
        , msg: function(msg,callback) {
            require(['layer'], function (layer) {
                layer.msg(msg)
            })
        }
         //设备检测
        , isMobile: function () {
            let userAgentInfo = navigator.userAgent;
            let Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
            let flag = false;
            for (let v = 0; v < Agents.length; v++) {
                if (userAgentInfo.indexOf(Agents[v]) > 0) {
                    flag = true;
                    break;
                }
            }
            return flag;
        },
        select2: function(el,options){
            require(['component/select2'],function(select2){
                select2(el,options)
            })
        },
        date: function(options) {
            require(['laydate'], function (laydate) {
                laydate.render(options)
            }) 
        }
    } 
    
})