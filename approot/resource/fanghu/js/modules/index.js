/**
 * Created by JS on 2015/10/23.
 */

define(function(require){

    return {

        init : function(htmlStr){

            if(typeof htmlStr === 'undefined' || htmlStr === '') return;

            $('#play').on('click',function(){

                var layer = require('layer');

                require('video');

                layer.open({
                    type: 1,
                    content: htmlStr,
                    style: 'width:95%; height:160px; background-color:#000; color:#fff; border:none;'
                });

            })

        }

    }

})
