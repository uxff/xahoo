/**
 * Created by JS on 2015/10/23.
 */
define(function(require){

    require('lib/zepto.min');

    return (function(){

        var echo = require('lib/echo.min');

        echo.init({
            offset: 100,
            throttle: 250,
            unload: false
        });



        var Slider = require('modules/slider');

        //�ֲ�
        new Slider({
            id : 'slider',
            autoPlay : true
        })

    })()

})
