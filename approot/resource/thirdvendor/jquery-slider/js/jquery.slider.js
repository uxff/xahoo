; (function ($) {
    //{
    //    imgBaseUrl: "img/",
    //    img: [{ url: "slider1.jpg", describe: "win8平版更薄" }, { url: "slider2.jpg", describe: "win8平版更轻" }, { url: "slider3.jpg", describe: "win8平版更快" }, { url: "slider4.jpg", describe: "win8平版更耐电" }],
    //    action: "mousemove",
    //    autoPlay: false,
    //    renderTo: $("#sliderCTT")
    //}
    var Slider = function (option) {
        var defaultOption = {
            action: "click",
            autoPlay: true
        }
        var option = $.extend({}, defaultOption, option);
        var lisHTML = "", navLisHTML = "",len=option.img.length;
        for (var i = 0; i < len; i++) {
            var item = option.img[i];
            lisHTML += '<li >'
                                + '<img src="' + option.imgBaseUrl + item.url + '" />'
                                 + '<span>' + item.describe + '</span>'
                             + '</li>';
            navLisHTML += '<li '+ ((i == 0) ? 'class="active"' : '')+'></li>';
        }

        var html = '<div class="surper-slider">'
                            + '<ul class="surper-slider-scroll">'
                               +lisHTML
                            + '</ul>'
                            + '<ul class="surper-slider-nav">'
                               + navLisHTML
                            + '</ul>'
                        + '</div>';
       
        $node = $(html);    
        option.renderTo.append($node);
        $ul = $node.find(".surper-slider-scroll");
        $navLi = $node.find(".surper-slider-nav li");
        var oUlWidth=1520*option.img.length;
        $('.surper-slider-scroll').css('width',oUlWidth);
        this.index = 0;
        var self = this;
  
        $navLi.on(option.action, function () {
            if ($ul.is(':animated')) return;
            var targetIndex = $navLi.index($(this));
            self.index = targetIndex;
            $navLi.removeClass("active");
            $(this).addClass("active");
            $ul.stop().animate({ left: -1520 * targetIndex }, 1520);

        })

        if (option.autoPlay) {

            setInterval(function () {
                if ($ul.is(':animated')) return;
                var targetIndex = 0;
                if (self.index == len - 1) {
                    targetIndex = 0;
                } else {
                    targetIndex = self.index + 1;
                }
                self.index = targetIndex;
               
                $ul.stop().animate({ left: -1520 * targetIndex }, 1520, function () {
                    $navLi.removeClass("active");
                    $navLi.eq(self.index).addClass("active");
                });

            }, 4000)

        }
    }







    $.createSlider = function (option) {
        return new Slider(option);
    }


})(jQuery);