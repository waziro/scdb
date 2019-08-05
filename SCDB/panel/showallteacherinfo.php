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
<div id="all-teacher-info" class="panel panel-primary">
    <div class="panel-heading" >
        <h4>教师信息</h4>
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
            url:'../connections/allteacherinfo.php',
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
                field:'teacherNo',
                title:'教工号'
            },{
                field:'teacherName',
                title:'教师姓名'
            },{
                field:'title',
                title:'职称'
            },{
                field:'degree',
                title:'学位'
            },{
                field:'hireDate',
                title:'就职日期'
            },{
                field:'courseNo1',
                title:'主讲课程一'
            },{
                field:'courseNo2',
                title:'主讲课程二'
            },{
                field:'courseNo3',
                title:'主讲课程三'
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
            var arr = new Array(6);             //定义基本变量
            var oldIndex;
            var oldPk;
            //增加
            $("#add").click(function () {
                $("#addModal").modal('show');
            });
            $("#addData").click(function () {   //同步到数据库
                arr[0]=$("#add-teacherNo").val();
                arr[1]=$("#add-teacherName").val();
                arr[2]=$("#add-title").val();
                arr[3]=$("#add-degree").val();
                arr[4]=$("#add-hireDate").val();
                arr[5]=$("#add-instituteNo").val();
                $.post('../connections/allteacherinfo.php',{action:"add",arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('insertRow',
                            {
                                index:0,
                                row: {
                                    teacherNo:arr[0],
                                    teacherName:arr[1],
                                    title:arr[2],
                                    degree:arr[3],
                                    hireDate:arr[4],
                                    instituteNo:arr[5]
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
                arr[0]=arrs[0].teacherNo;
                arr[1]=arrs[0].teacherName;
                arr[2]=arrs[0].title;
                arr[3]=arrs[0].degree;
                arr[4]=arrs[0].hireDate;
                arr[5]=arrs[0].instituteNo;
                oldIndex=arrs[0].index;                  //存储行索引
                oldPk=arr[0];                            //存储原有主键值
                $("#modModal").modal('show');
                $("#mod-teacherNo").val(arr[0]);       //加载原有数据
                $("#mod-teacherName").val(arr[1]);
                $("#mod-title").val(arr[2]);
                $("#mod-degree").val(arr[3]);
                $("#mod-hireDate").val(arr[4]);
                $("#mod-instituteNo").val(arr[5]);
            });
            $("#modData").click(function () {       //同步到数据库
                arr[0]=$("#mod-teacherNo").val();
                arr[1]=$("#mod-teacherName").val();
                arr[2]=$("#mod-title").val();
                arr[3]=$("#mod-degree").val();
                arr[4]=$("#mod-hireDate").val();
                arr[5]=$("#mod-instituteNo").val();
                $.post('../connections/allteacherinfo.php',{action:"mod",oldPk:oldPk,arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('updateRow',
                            {
                                index:oldIndex-1,
                                row:{
                                    teacherNo:arr[0],
                                    teacherName:arr[1],
                                    title:arr[2],
                                    degree:arr[3],
                                    hireDate:arr[4],
                                    instituteNo:arr[5]
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
                    return row.teacherNo;
                });
                if(ids!=""){
                    $.post('../connections/allteacherinfo.php',{action:"del",teacherNos:ids},function (data) {
                        if(data){
                            $table.bootstrapTable('remove', {field: 'teacherNo', values: ids});
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
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <label for="add-teacherNo" class="control-label">教工号:</label>
                                    <input type="text" class="form-control" id="add-teacherNo" maxlength="5">
                                    <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-teacherName" class="control-label">教师姓名:</label>
                                    <input type="text" class="form-control" id="add-teacherName">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-title" class="control-label">职称:</label>
                                    <input type="text" class="form-control" id="add-title">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-degree" class="control-label">学位:</label>
                                    <input type="text" class="form-control" id="add-degree">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add-hireDate" class="control-label">就职日期:</label>
                            <input type="text" class="form-control" id="add-hireDate">
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
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group has-feedback">
                                    <label for="mod-teacherNo" class="control-label">教工号:</label>
                                    <input type="text" class="form-control" id="mod-teacherNo" maxlength="5">
                                    <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-teacherName" class="control-label">教师姓名:</label>
                                    <input type="text" class="form-control" id="mod-teacherName">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-title" class="control-label">职称:</label>
                                    <input type="text" class="form-control" id="mod-title">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-degree" class="control-label">学位:</label>
                                    <input type="text" class="form-control" id="mod-degree">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mod-hireDate" class="control-label">就职日期:</label>
                            <input type="text" class="form-control" id="mod-hireDate">
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