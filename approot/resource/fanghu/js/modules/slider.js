/**
 * Created by JS on 2015/9/29.
 * @update: 20151012 修复部分android机移动时候的卡顿问题
 * @update: 20151113 修复已知问题[往后滑动时候位置不正确]
 *
 */

function Slider(opts){

    this._opts = opts || {};

    this._defaults = {

        id : null,

        type : null, //设置为smooth则为一般滑动

        time : 5, //默认间隔为5s

        autoPlay : false,

        reHeight : true //根据图片设置高度

    }

    this._options = $.extend({}, this._defaults, this._opts);

    this.init();

}

Slider.prototype = {

    init : function(){

        this._initDom();

        this._initEvent();

    },

    _initDom : function(){

        this._slider = $('#'+this._options.id);

        this._sliderList = this._slider.find('.slider-list');

        this._sliderListItem = this._sliderList.find('.slider-list-item');

        this._sliderListLen = this._sliderListItem.length;

        this._w = this._slider.width();

        this._offsetL = this._w * (this._sliderListLen - 1);

        this._offsetC = this._w * this._sliderListLen;

        //间距阀值常量
        this._SLIDER_DIS = 80;

        this._data = {
            startX : 0,
            startY : 0,
            endX : 0,
            endY : 0,
            move : 0,
            moving : false,
            pos : 0,
            current : 0,
            prevCurrent : 0
        }

    },

    _initEvent : function(){

        if(this._slider.length === 0) return;

        if(this._options.reHeight) this._initStyle();

        if(this._sliderListLen === 1) return;

        this._initNav();

        this._options.autoPlay && this._Events.autoChange.call(this);

        this._slider.on('touchstart touchmove touchend', '.slider-list', $.proxy(this._Events.sliderCtrl, this));

        this._slider.on('webkitTransitionEnd transitionend', '.slider-list', $.proxy(this._Events.sliderMonitor, this));

        this._slider.on('touchstart', '.page-pre,.page-next', $.proxy(this._Events.pageCtrl, this));

    },

    _initStyle : function(){

        this._slider.height(this._sliderList.height());

    },

    _initNav : function(){

        var str = '<div class="slider-nav">';

        for(var i = 0; i < this._sliderListLen; i++){

            if(i === 0){

                str += '<span class="active"></span>';

            }else{

                str += '<span></span>';

            }



        }

        str += '</ul>';

        this._slider.append(str);

        this._sliderNav = this._slider.find('.slider-nav>span');

    },

    _Events : {

        autoChange : function(){

            var me = this;

            this._timer = setInterval($.proxy(me._Events.sliderChg, me), me._options.time*1000);

        },

        sliderCtrl : function(e){

            clearInterval(this._timer);

            this._timer = 0;

            switch (e.type){

                case 'touchstart' :

                    if(this._data.moving) return;


                    this._data.startX = e.touches[0].clientX;

                    break;

                case 'touchmove' :

                    this._data.moving = true;

                    this._data.move = e.touches[0].clientX;

                    e.preventDefault();

                    this._Events.sliderMove.call(this);

                    break;

                case 'touchend' :

                    /* 如果没有触发touchmove直接退出 */
                    if(!this._data.moving) return;

                    //可以从changedTouches取出最后的位置
                    this._data.endX = e.changedTouches[0].clientX;

                    this._Events.sliderChg.call(this);

                    break;

                default :

                    console.log('what!');

                    break;

            }

        },

        sliderMove : function(){

            var pos = this._data.move - this._data.startX;

            /*if(pos > 0 && this._data.current === 0 || pos < 0 && this._data.current === this._sliderListLen - 1){

             this._data.move = this._data.startX;

             return;

             }*/

            this._sliderList[0].classList.remove('animate');

            pos += this._data.pos;

            this._Events.sliderTrans.call(this, pos);

        },

        sliderChg : function(){

            if(this._options.type === 'smooth') return;

            this._sliderList[0].classList.add('animate');

            this._Events.setPrevCurrent.call(this);

            var pos;

            this._options.autoPlay && this._timer !== 0 ? pos = -this._SLIDER_DIS - 1 : pos = this._data.endX - this._data.startX;

            if(pos > this._SLIDER_DIS){

                this._data.pos += this._w;

                this._data.current--;

            }else if(pos < -this._SLIDER_DIS){

                this._data.pos -= this._w;

                this._data.current++;

            }

            //console.log(this._data.current);

            this._Events.sliderTrans.call(this, this._data.pos);



        },

        sliderNav : function(){

            this._sliderNav[this._data.prevCurrent].classList.remove('active');

            this._sliderNav[this._data.current].classList.add('active');

        },

        sliderTrans : function(pos){

            if(-pos > this._offsetL) {

                this._sliderListItem[0].style.cssText = 'position:relative;left:'+this._offsetC+'px;';

            }else if(-pos < 0){

                this._sliderListItem[this._sliderListLen-1].style.cssText = 'position:relative;left:-'+this._offsetC+'px;';

            }

            this._sliderList[0].style[this.util._prefixStyle('transform')] = 'translate3D('+pos+'px, 0, 0)';

        },

        sliderMonitor : function(){

            this._data.moving = false;

            var pos;

            if(this._data.current >= this._sliderListLen){

                this._data.current = 0;

                this._sliderListItem[0].style.cssText = '';

                pos = 0;

            }else if(this._data.current < 0){

                this._data.current = this._sliderListLen - 1;

                this._sliderListItem[this._sliderListLen - 1].style.cssText = '';

                pos = -this._offsetL;

            }

            if(typeof pos !== 'undefined'){

                this._sliderList[0].classList.remove('animate');

                this._sliderList[0].style[this.util._prefixStyle('transform')] = 'translate3D('+pos+'px, 0, 0)';

                this._data.pos = pos;

            }

            //console.log(this._data.current+'===='+this._data.prevCurrent);

            this._Events.sliderNav.call(this);

            this._timer === 0 && this._Events.autoChange.call(this);

        },

        setPrevCurrent : function(){

            this._data.prevCurrent = this._data.current;

        },

        pageCtrl : function(e){

            var target = e.target;

            if(target.className === 'page-pre'){

                if(this._data.current === 0) return;

                this._data.pos -= this._w;

                this._data.current--;

            }else if(target.className = 'page-next'){

                if(this._data.current === this._sliderListLen - 1) return;

                this._data.pos += this._w;

                this._data.current++;

            }
        }

    },

    util : {

        _prefixStyle : function(style){

            var _elementStyle = document.createElement('div').style;
            var _vendor = (function () {
                var vendors = ['t', 'webkitT', 'MozT', 'msT', 'OT'],
                    transform,
                    i = 0,
                    l = vendors.length;

                for ( ; i < l; i++ ) {
                    transform = vendors[i] + 'ransform';
                    if ( transform in _elementStyle ) return vendors[i].substr(0, vendors[i].length-1);
                }

                return false;
            })();

            if ( _vendor === false ) return false;
            if ( _vendor === '' ) return style;
            return _vendor + style.charAt(0).toUpperCase() + style.substr(1);

        }

    }


}

// seajs and requirejs support
if (typeof define === 'function' && (define.amd ||define.cmd)) {
    define([], function () {
        'use strict';
        return Slider;
    });
};
