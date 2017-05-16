
<style>
    body {
        margin: 0;
        padding: 0;
        background: #333;
        overflow: hidden;
    }
    /*ul wrapper*/
    #iSlider-wrapper {
        height: 100%;
        width: 100%;
        overflow: hidden;
        position: absolute;
    }

    #iSlider-wrapper ul {
        list-style: none;
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
    }
    #iSlider-wrapper li {
        position: absolute;
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-pack: center;
        -webkit-box-align: center;
        list-style: none;
    }
    #iSlider-wrapper li  img{
        max-width: 100%;
        max-height: 100%;
    }
    #iSlider-wrapper .icon-remove-sign{
        position: absolute;
        top:20px;
        right:20px;
        z-index: 1;
        font-size: 3rem;
        color:#fff;
    }

</style>
</head>

<body>
    <!-- Outer Canvas 外层画布 -->
    <div id="iSlider-wrapper">
        <a href="javascript:history.go(-1);" class="icon-remove-sign" id="back"></a>
    </div>
    <script src="{$resourceThirdVendorPath}/iSlider/islider.js"></script>
    <script src="{$resourceThirdVendorPath}/zepto1.0/zepto.js"></script>
    <script src="{$resourceThirdVendorPath}/zepto1.0/touch.js"></script>
    <script>
        var list = {$arrPhotos};

        var islider = new iSlider({
            type: 'pic',
            data: list,
            dom: document.getElementById("iSlider-wrapper"),
            isLooping: true,
            animateType: 'depth',
        });

        $('#back').on('tap', function() {
            window.history.back(-1);
        });

    </script>
</body>

