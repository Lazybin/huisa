<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" href="{{url('/')}}/huodong/css/reset.css">
    <link rel="stylesheet" href="{{url('/')}}/huodong/css/atom.css">
    <link rel="stylesheet" href="{{url('/')}}/huodong/css/global.css">
    <link rel="stylesheet" href="{{url('/')}}/huodong/css/open.css">
    <title>Zepto.js插件实现宝箱开启动画抽奖 - 站长素材</title>
</head>
<body ontouchstart="" class="open-body">
<div class="wrapper">

    <div class="bg rotate"></div>
    <div class="open-has ">
        <h3 class="title-close"><span class="user">站长素材</span>给你发了一个宝箱</h3>
        <h3 class="title-open">恭喜你，</br>成功领取<span class="user">站长素材</span>发的全民飞机大战宝箱</h3>

        <div class="mod-chest">

            <div class="chest-close show ">
                <div class="gift"></div>
                <div class="tips">
                    <i class="arrow"></i>
                </div>
            </div>
            <div class="chest-open ">
                <div class="mod-chest-cont open-cont">
                    <div class="content">
                        <div class="gift">
                            <div class="icon"><img src="{{url('/')}}/huodong/img/chest-icon-zuan.png"></div> x 500
                        </div>
                        <div class="func">
                            <button class="chest-btn">查看详情并提取</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="open-none" style="display:none">
        <h3>你来晚啦，下次早点吧！</h3>
        <div class="mod-chest">
            <div class="chest-open show"></div>
        </div>
        <div class="func">
            <button class="chest-btn">查看领取详情</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{url('/')}}/huodong/js/zepto.min.js"></script>
<script type="text/javascript">

    $(".chest-close").click(function(){

        $(this).addClass("shake");
        var that=this;

        this.addEventListener("webkitAnimationEnd", function(){

            $(that).closest(".open-has").addClass("opened");
            setTimeout(function(){
                $(that).removeClass("show");
                $(that).closest(".mod-chest").find(".chest-open").addClass("show");
                setTimeout(function(){
                    $(".chest-open").addClass("blur");
                },500)
            },200)
        }, false);
    })
</script>

</body>
</html>