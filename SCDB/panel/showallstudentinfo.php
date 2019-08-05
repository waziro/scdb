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
<div id="all-student-info" class="panel panel-primary">
    <div class="panel-heading" >
        <h4>学生信息</h4>
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
            url:'../connections/allstudentinfo.php',
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
                field:'studentNo',
                title:'学号'
            },{
                field:'studentName',
                title:'学生姓名'
            },{
                field:'sex',
                title:'性别'
            },{
                field:'birthday',
                title:'出生日期'
            },{
                field:'phoneNumber',
                title:'联系电话'
            },{
                field:'address',
                title:'家庭住址',
                formatter:function (value, row, index) {
                    return  row.value=row.province+row.city+row.street;
                }
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
            var arr = new Array(8);             //定义基本变量
            var oldIndex;
            var oldPk;
            //增加
            $("#add").click(function () {
                $("#addModal").modal('show');
            });
            $("#addData").click(function () {   //同步到数据库
                arr[0]=$("#add-studentNo").val();
                arr[1]=$("#add-studentName").val();
                arr[2]=$("#add-sex").val();
                arr[3]=$("#add-birthday").val();
                arr[4]=$("#add-phoneNumber").val();
                arr[5]=$("#add-province").val();
                arr[6]=$("#add-city").val();
                arr[7]=$("#add-street").val();
                $.post('../connections/allstudentinfo.php',{action:"add",arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('insertRow',
                            {
                                index:0,
                                row: {
                                    studentNo:arr[0],
                                    studentName:arr[1],
                                    sex:arr[2],
                                    birthday:arr[3],
                                    phoneNumber:arr[4],
                                    address:arr[5]+arr[6]+arr[7]
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
                arr[0]=arrs[0].studentNo;
                arr[1]=arrs[0].studentName;
                arr[2]=arrs[0].sex;
                arr[3]=arrs[0].birthday;
                arr[4]=arrs[0].phoneNumber;
                arr[5]=arrs[0].province;
                arr[6]=arrs[0].city;
                arr[7]=arrs[0].street;
                oldIndex=arrs[0].index;                  //存储行索引
                oldPk=arr[0];                            //存储原有主键值
                $("#modModal").modal('show');
                $("#mod-studentNo").val(arr[0]);       //加载原有数据
                $("#mod-studentName").val(arr[1]);
                $("#mod-sex").val(arr[2]);
                $("#mod-birthday").val(arr[3]);
                $("#mod-phoneNumber").val(arr[4]);
                $("#mod-province").val(arr[5]);
                $("#mod-city").val(arr[6]);
                $("#mod-street").val(arr[7]);
            });
            $("#modData").click(function () {       //同步到数据库
                arr[0]=$("#mod-studentNo").val();
                arr[1]=$("#mod-studentName").val();
                arr[2]=$("#mod-sex").val();
                arr[3]=$("#mod-birthday").val();
                arr[4]=$("#mod-phoneNumber").val();
                arr[5]=$("#mod-province").val();
                arr[6]=$("#mod-city").val();
                arr[7]=$("#mod-street").val();
                $.post('../connections/allstudentinfo.php',{action:"mod",oldPk:oldPk,arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('updateRow',
                            {
                                index:oldIndex-1,
                                row:{
                                    studentNo:arr[0],
                                    studentName:arr[1],
                                    sex:arr[2],
                                    birthday:arr[3],
                                    phoneNumber:arr[4],
                                    address:arr[5]+arr[6]+arr[7]
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
                    return row.studentNo;
                });
                if(ids!=""){
                    $.post('../connections/allstudentinfo.php',{action:"del",studentNos:ids},function (data) {
                        if(data){
                            $table.bootstrapTable('remove', {field: 'studentNo', values: ids});
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
                            <label for="add-studentNo" class="control-label">学号:</label>
                            <input type="text" class="form-control" id="add-studentNo" maxlength="12">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-studentName" class="control-label">学生姓名:</label>
                                    <input type="text" class="form-control" id="add-studentName">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-sex" class="control-label">性别:</label>
                                    <select type="text" class="form-control" id="add-sex">
                                        <option value="男">男</option>
                                        <option value="女">女</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-birthday" class="control-label">出生日期:</label>
                                    <input type="text" class="form-control" id="add-birthday" maxlength="10">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-phoneNumber" class="control-label">联系电话:</label>
                                    <input type="text" class="form-control" id="add-phoneNumber">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add-address" class="control-label">家庭住址:</label>
<!--                            <input type="text" class="form-control" id="add-address">-->
                            <input type="text" class="form-control" id="add-province" placeholder="省/市/自治区">
                            <input type="text" class="form-control" id="add-city" placeholder="省/市">
                            <input type="text" class="form-control" id="add-street" placeholder="区/街道">
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
                            <label for="mod-studentNo" class="control-label">学号:</label>
                            <input type="text" class="form-control" id="mod-studentNo" maxlength="12">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-studentName" class="control-label">学生姓名:</label>
                                    <input type="text" class="form-control" id="mod-studentName">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-sex" class="control-label">性别:</label>
                                    <select type="text" class="form-control" id="mod-sex">
                                        <option value="男">男</option>
                                        <option value="女">女</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-birthday" class="control-label">出生日期:</label>
                                    <input type="text" class="form-control" id="mod-birthday" maxlength="10">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-phoneNumber" class="control-label">联系电话:</label>
                                    <input type="text" class="form-control" id="mod-phoneNumber">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mod-address" class="control-label">家庭住址:</label>
                            <input type="text" class="form-control" id="mod-province" placeholder="省/市/自治区">
                            <input type="text" class="form-control" id="mod-city" placeholder="省/市">
                            <input type="text" class="form-control" id="mod-street" placeholder="区/街道">
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