/**
 * Created by JS on 2015/9/22.
 */
seajs.config({

    // 别名配置
    alias: {
        'tiny':'lib/tiny',
        'preload':'lib/preload',
        'zepto': 'lib/zepto.min',
        'echo' : 'lib/echo.min',
        'layer': 'lib/layer/layer.m',
        'hogan': 'lib/hogan.min',
        'scroll' : 'lib/iscroll-lite',
        'video': 'lib/video/video.min'
    },

    // Sea.js 的基础路径
    base: xqsjMob.staticPath+'js',

    // 文件编码
    charset: 'utf-8'
});
