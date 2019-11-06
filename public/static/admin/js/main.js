layui.use(['form','element','layer','jquery'],function(){
    $(".panel a").click(function(){
        parent.addTab($(this));
    })
})