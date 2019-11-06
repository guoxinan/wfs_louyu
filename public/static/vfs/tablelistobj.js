var tablelistobj = {
    id: 'tablelist',
    filter: 'tablelist',
    elem: '#tablelist',
    tool_obj: {
        edit : {href: '', title: ''},
        add : {href: '', title: ''},
    },
    page: {
        layout: ['count', 'prev', 'page', 'next', 'skip'], //自定义分页布局
        curr: 1, //设定初始在第 5 页
        groups: 5, //只显示 1 个连续页码
        first: false, //不显示首页
        last: false, //不显示尾页
    },
    limit: 20,
    method : 'post',
    where :{},
    cols: [[
        {field: 'id', type: 'checkbox', width: 80},
        {field: 'id', width: 80, title: 'ID', sort: true},
        {field: 'title', title: '名称'},
    ]],
    form_width: 500,
    form_height: 500,
    render: function (layuitable) {
        var that = this;
        var id = that.id;
        var elem = that.elem;
        var page = that.page;
        var cols = that.cols;
        var limit = that.limit;
        var url = that.tool_obj.lists.href;
        var where = that.where;
        var method = that.method;
        layuitable.render({
            id: id,
            elem: elem,
            toolbar: '#tplToolbar',
            defaultToolbar: ['filter'],
            method: method,
            url: url,
            where : where,
            page: page,
            limit: limit,
            cols: cols,
            parseData: function (res) {
                if (res.code === 0) {
                    return {
                        "code": res.code, //解析接口状态
                        "msg": res.message, //解析提示文本
                        "count": res.data.count, //解析数据长度
                        "data": res.data.data //解析数据列表
                    };
                }
            }
        });
    },
    search: function (layuitable, layuiform) {
        var that = this;
        var filter = that.filter;
        layuiform.on('submit(tablelistReload)', function (data) {
            var where = data.field;
            layuitable.reload(filter, {
                method: 'post',
                page: {curr: 1},
                where: where
            });
            return false;
        });
    },
    tool: function (layuitable, layer) {
        var that = this;
        var filter = that.filter;
        layuitable.on('tool(' + filter + ')', function (obj) {
            var data = obj.data;
            var id = data.id;
            if (obj.event === 'del') {
                var url = that.tool_obj.del.href;
                var postData = {id: id};
                layer.confirm('你确定要删除吗', function (index) {
                    $.post(url, postData, function (res) {
                        var message = res.message;
                        if (res.code == 0) {
                            obj.del();
                            layer.msg(message, {icon: 1, time: 2000});
                        } else {
                            layer.msg(message, {icon: 2, time: 2000});
                        }
                        layer.close(index);
                    }, 'json');
                });
            } else {
                var eventname = obj.event;
                var tool_obj = that.tool_obj;
                var event_obj = tool_obj[eventname];
                var url = event_obj.href;
                url += '?id=' + id;
                var title = event_obj.title;
                that.form_open(layer, title, url);
            }
        });
    },
    toolbar: function (layuitable, layer) {
        var that = this;
        var filter = that.filter;
        layuitable.on('toolbar(' + filter + ')', function (obj) {
            var tableId = obj.config.id;
            var checkStatus = layuitable.checkStatus(tableId);
            switch (obj.event) {
                case 'buttonAdd':
                    var url = that.tool_obj.add.href;
                    var title = that.tool_obj.add.title;
                    that.form_open(layer, title, url);
                    break;
                case 'batchDel':
                    var data = checkStatus.data;
                    var length = data.length;
                    if (length > 0) {
                        var idArr = [];
                        $(data).each(function (i, n) {
                            idArr[i] = n.id;
                        });
                        var id = idArr.join(',');
                        var postData = {id: id};
                        var url = that.tool_obj.del.href;
                        layer.confirm('你确定要删除吗', function (index) {
                            $.post(url, postData, function (res) {
                                var message = res.message;
                                if (res.code == 0) {
                                    layuitable.reload(tableId, {
                                        method: 'post',
                                        where: {},
                                        page: {curr: 1}
                                    });
                                    layer.msg(message, {icon: 1, time: 2000});
                                } else {
                                    layer.msg(message, {icon: 2, time: 2000});
                                }
                                layer.close(index);
                            }, 'json');
                        });
                    }
                    break;
                case 'batchMenu':
                    var url = that.tool_obj.menu.href;
                    var postData = {};
                    layer.confirm('你确定要生成新菜单吗', function (index) {
                        $.post(url, postData, function (res) {
                            var message = res.message;
                            if (res.code == 0) {
                                layuitable.reload(tableId, {
                                    method: 'post',
                                    where: {},
                                    page: {curr: 1}
                                });
                                layer.msg(message, {icon: 1, time: 2000});
                            } else {
                                layer.msg(message, {icon: 2, time: 2000});
                            }
                            layer.close(index);
                        }, 'json');
                    });
            }
            ;
        });
    },
    form_open: function (layer, title, url) {
        var that = this;
        var width = that.form_width + 'px';
        var height = that.form_height + 'px';
        var index = layer.open({
            title: title,
            type: 2,
            content: url,
            area: [width, height],
            fix: false,
            maxmin: true,
            shadeClose: false,
            shade: 0.4,
        });
    }
};