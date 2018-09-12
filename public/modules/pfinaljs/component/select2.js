define([
    '/plug/select2/select2.min.js',
    'css!/plug/select2/select2.min.css'
], function () {
    return function (el,options) {
        return $(el).select2(options);
    }
})