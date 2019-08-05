<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 18:50
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
</head>
<body>
<div id="all-class-info" class="panel panel-primary">
    <div class="panel-heading" >
        <h4>班级信息</h4>
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
            url:'../connections/allclassinfo.php',
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
                field:'classNo',
                title:'班级号'
            },{
                field:'className',
                title:'班级名称'
            },{
                field:'grade',
                title:'年级'
            },{
                field:'classNumber',
                title:'班级人数'
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
                arr[0]=$("#add-classNo").val();
                arr[1]=$("#add-className").val();
                arr[2]=$("#add-grade").val();
                arr[3]=$("#add-classNumber").val();
                arr[4]=$("#add-instituteNo").val();
                $.post('../connections/allclassinfo.php',{action:"add",arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('insertRow',
                            {
                                index:0,
                                row: {
                                    classNo:arr[0],
                                    className:arr[1],
                                    grade:arr[2],
                                    classNumber:arr[3],
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
                arr[0]=arrs[0].classNo;
                arr[1]=arrs[0].className;
                arr[2]=arrs[0].grade;
                arr[3]=arrs[0].classNumber;
                arr[4]=arrs[0].instituteNo;
                oldIndex=arrs[0].index;                  //存储行索引
                oldPk=arr[0];                           //存储原有主键值
                $("#modModal").modal('show');
                $("#mod-classNo").val(arr[0]);      //加载原有数据
                $("#mod-className").val(arr[1]);
                $("#mod-grade").val(arr[2]);
                $("#mod-classNumber").val(arr[3]);
                $("#mod-instituteNo").val(arr[4]);

                });
            $("#modData").click(function () {       //同步到数据库
                arr[0]=$("#mod-classNo").val();
                arr[1]=$("#mod-className").val();
                arr[2]=$("#mod-grade").val();
                arr[3]=$("#mod-classNumber").val();
                arr[4]=$("#mod-instituteNo").val();
                $.post('../connections/allclassinfo.php',{action:"mod",oldPk:oldPk,arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('updateRow',
                            {
                                index:oldIndex-1,
                                row:{
                                    classNo:arr[0],
                                    className:arr[1],
                                    grade:arr[2],
                                    classNumber:arr[3],
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
                var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row.classNo;
                });
                if(ids!=""){
                    $.post('../connections/allclassinfo.php',{action:"del",classNos:ids},function (data) {
                        if(data){
                            $table.bootstrapTable('remove', {field: 'classNo', values: ids});
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
                            <label for="add-classNo" class="control-label">班级号:</label>
                            <input type="text" class="form-control" id="add-classNo" maxlength="8">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="add-className" class="control-label">班级名称:</label>
                            <input type="text" class="form-control" id="add-className">
                        </div>
                        <div class="form-group">
                            <label for="add-grade" class="control-label">年级:</label>
                            <input type="text" class="form-control" id="add-grade" maxlength="4">
                        </div>
                        <div class="form-group">
                            <label for="add-classNumber" class="control-label">班级人数:</label>
                            <input type="text" class="form-control" id="add-classNumber" maxlength="3">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="add-instituteNo" class="control-label">所属学院:</label>
                            <input type="text" class="form-control" id="add-instituteNo">
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
                            <label for="mod-classNo" class="control-label">班级号:</label>
                            <input type="text" class="form-control" id="mod-classNo" maxlength="8">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label for="mod-className" class="control-label">班级名称:</label>
                            <input type="text" class="form-control" id="mod-className">
                        </div>
                        <div class="form-group">
                            <label for="mod-grade" class="control-label">年级:</label>
                            <input type="text" class="form-control" id="mod-grade" maxlength="4">
                        </div>
                        <div class="form-group">
                            <label for="mod-classNumber" class="control-label">班级人数:</label>
                            <input type="text" class="form-control" id="mod-classNumber" maxlength="3">
                        </div>
                        <div class="form-group has-feedback">
                            <label for="mod-instituteNo" class="control-label">所属学院:</label>
                            <input type="text" class="form-control" id="mod-instituteNo">
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