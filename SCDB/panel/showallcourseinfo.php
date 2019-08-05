<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 19:25
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>教学管理系统（测试）</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-table.css">
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.js"></script>
    <script src="../bootstrap/js/bootstrap-table.js"></script>
    <script src="../tableExport/tableExport.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/extensions/export/bootstrap-table-export.js"></script>
    <script src="../bootstrap/js/bootstrap-table-zh-CN.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .table-hover tbody tr:hover{
            background-color: #f0ad4e;
        }
    </style>
</head>
<body>
<div id="all-course-info" class="panel panel-primary">
    <div class="panel-heading" >
        <h4>课程信息</h4>
    </div>
    <div class="table-responsive">
        <table id="table" data-search="true" data-show-export="true"
               data-show-columns="true" data-show-pagination-switch="true"
               data-show-toggle="true" data-show-refresh="true"  class="table-condensed">
            <thead class="bg-info">
            </thead>
        </table>
        <div id="toolbar">
            <div class="btn-group" role="group">
                <button id="add" type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 增加
                </button>
                <button id="mod" type="button" class="btn btn-warning">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 修改
                </button>
                <button id="del" type="button" class="btn btn-danger ">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var $table=$("#table");
        $table.bootstrapTable('destroy');
        //初始化表格
        $table.bootstrapTable({
            url:'../connections/allcourseinfo.php',
            method:'post',
            dataType:'json',
            columns:[{
                checkbox:'true'
            },{
                field:"index",
                title:"ID",
                visible:true,
                formatter:function(value, row, index){
                    return row.index=index+1;
                }
            },{
                field:'courseNo',
                title:'课程号'
            },{
                field:'courseName',
                title:'课程名称'
            },{
                field:'creditHour',
                title:'学分'
            },{
                field:'courseHour',
                title:'课时'
            },{
                field:'instituteNo',
                title:'所属学院'
            }],
            pagination:'true',
            paginationLoop:'false',
            pageNumber:1,
            pageSize:10,
//            height:462,
            toolbar:'#toolbar',
            clickToSelect:'true'
        });
        //增加、修改、删除功能的实现
        $(function () {
            var arr = new Array(5);             //定义基本变量
            var oldIndex;
            var oldPk;
            //增加
            $("#add").click(function () {
                $("#addModal").modal('show');
            });
            $("#addData").click(function () {   //同步到数据库
                arr[0]=$("#add-courseNo").val();
                arr[1]=$("#add-courseName").val();
                arr[2]=$("#add-creditHour").val();
                arr[3]=$("#add-courseHour").val();
                arr[4]=$("#add-instituteNo").val();
                $.post('../connections/allcourseinfo.php',{action:"add",arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('insertRow',
                            {
                                index:0,
                                row: {
                                    courseNo:arr[0],
                                    courseName:arr[1],
                                    creditHour:arr[2],
                                    courseHour:arr[3],
                                    instituteNo:arr[4]
                                }
                            });
                    }else{
                        alert("操作无效！");
                    }
                });
            });
            //修改
            $("#mod").click(function () {
                var arrs = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row;
                });
                arr[0]=arrs[0].courseNo;
                arr[1]=arrs[0].courseName;
                arr[2]=arrs[0].creditHour;
                arr[3]=arrs[0].courseHour;
                arr[4]=arrs[0].instituteNo;
                oldIndex=arrs[0].index;                  //存储行索引
                oldPk=arr[0];                            //存储原有主键值
                $("#modModal").modal('show');
                $("#mod-courseNo").val(arr[0]);       //加载原有数据
                $("#mod-courseName").val(arr[1]);
                $("#mod-creditHour").val(arr[2]);
                $("#mod-courseHour").val(arr[3]);
                $("#mod-instituteNo").val(arr[4]);
            });
            $("#modData").click(function () {       //同步到数据库
                arr[0]=$("#mod-courseNo").val();
                arr[1]=$("#mod-courseName").val();
                arr[2]=$("#mod-creditHour").val();
                arr[3]=$("#mod-courseHour").val();
                arr[4]=$("#mod-instituteNo").val();
                $.post('../connections/allcourseinfo.php',{action:"mod",oldPk:oldPk,arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('updateRow',
                            {
                                index:oldIndex-1,
                                row:{
                                    courseNo:arr[0],
                                    courseName:arr[1],
                                    creditHour:arr[2],
                                    courseHour:arr[3],
                                    instituteNo:arr[4]
                                }
                            });
                    }else{
                        alert("操作无效！");
                    }
                });
            });
            //删除
            $("#del").click(function () {
//                alert('getSelections: ' + JSON.stringify($table.bootstrapTable('getSelections')));
                var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.courseNo;
                });
                if(ids!=""){
                    $.post('../connections/allcourseinfo.php',{action:"del",courseNos:ids},function (data) {
                        if(data){
                            $table.bootstrapTable('remove', {field: 'courseNo', values: ids});
                        }else{
                            alert("操作无效！");
                        }
                    });
                }
            });
        });
        //表格导出
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('destroy').bootstrapTable({
                exportDataType: $(this).val()
            });
        });
    });
</script>
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">增加行数据</h4>
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <form>
                        <br/>
                        <div class="form-group has-feedback">
                            <label for="add-courseNo" class="control-label">课程号:</label>
                            <input type="text" class="form-control" id="add-courseNo" maxlength="6">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="add-courseName" class="control-label">课程名称:</label>
                            <input type="text" class="form-control" id="add-courseName">
                        </div>
                        <div class="form-group">
                            <label for="add-creditHour" class="control-label">学分:</label>
                            <input type="text" class="form-control" id="add-creditHour" maxlength="1">
                        </div>
                        <div class="form-group">
                            <label for="add-courseHour" class="control-label">课时:</label>
                            <input type="text" class="form-control" id="add-courseHour" maxlength="3">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="add-instituteNo" class="control-label">所属学院:</label>
                            <input type="text" class="form-control" id="add-instituteNo" maxlength="2">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button class="btn btn-primary" id="addData" data-dismiss="modal">确认</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="modModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改行数据</h4>
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <form>
                        <br/>
                        <div class="form-group has-feedback">
                            <label for="mod-courseNo" class="control-label">课程号:</label>
                            <input type="text" class="form-control" id="mod-courseNo" maxlength="6">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="mod-courseName" class="control-label">课程名称:</label>
                            <input type="text" class="form-control" id="mod-courseName">
                        </div>
                        <div class="form-group">
                            <label for="mod-creditHour" class="control-label">学分:</label>
                            <input type="text" class="form-control" id="mod-creditHour" maxlength="1">
                        </div>
                        <div class="form-group">
                            <label for="mod-courseHour" class="control-label">课时:</label>
                            <input type="text" class="form-control" id="mod-courseHour" maxlength="3">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="mod-instituteNo" class="control-label">所属学院:</label>
                            <input type="text" class="form-control" id="mod-instituteNo" maxlength="2">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button class="btn btn-primary" id="modData" data-dismiss="modal">确认</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</HTML>