/**
 * Created by JS on 2015/9/24.
 */
define(function(require){

    require('../lib/zepto.min');

    function TabSwitch(opts){

        this._opts = opts || {};

        this._defaults = {

            id : null

        }

        this._options = $.extend({}, this._defaults, this._opts);

        this.init();

    }

    TabSwitch.prototype = {

        init : function(){

            this._initDom();

            this._initEvent();

        },

        _initDom : function(){

            this._tab = $('#'+this._options.id);

            this._tabTitle = this._tab.find('.tab-title');

            this._titleItem = this._tabTitle.find('a');

            this._titleLine = this._tabTitle.find('.title-line');

            this._tabBody = this._tab.find('.tab-body');

            this._bodyItem = this._tabBody.find('.body-item');

            this._current = 0;

            this._hasInit = false;

        },

        _initEvent : function(){

            if(!this._tab.length) return;

            this._initStatus();

            this._tab.on('touchstart', '.tab-title>.title-item>a', $.proxy(this._Events.titleCtrl, this));

        },

        _Events : {

            titleCtrl : function(e){

                var target = e.target;

                while(target.nodeName.toUpperCase() !== 'A') target = target.parentNode;

                target = $(target);

                var index = target.index();

                if(index === this._current) return;

                this._setTitle(index);

                this._setBody(index);

                this._current = index;

            }

        },

        _initStatus : function(){

            this._setTitle(0);

            this._setBody(0);

        },

        _setTitle : function(index){

            if(typeof index === 'undefined' || index === '') return;

            $(this._titleItem[this._current]).removeClass('active');

            var currentTitle = $(this._titleItem[index]);

            currentTitle.addClass('active');

            this._setTitleLine(currentTitle.offset().left);

        },

        _setTitleLine : function(pos){

            if(!this._hasInit) this._titleLine.width(window.innerWidth / this._titleItem.length), this._hasInit = true;

            this._titleLine[0].style[this.util._prefixStyle('transform')] = 'translate3D('+pos+'px, 0, 0)';

        },

        _setBody : function(index){

            if(typeof index === 'undefined' || index === '') return;

            $(this._bodyItem[this._current]).removeClass('active');

            $(this._bodyItem[index]).addClass('active');

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

    return TabSwitch;

})
