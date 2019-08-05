<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/30
 * Time: 17:27
 */
session_start();
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
<div id="courseClass-info" class="panel panel-primary">
    <div class="panel-heading" >
        <h4>开课班</h4>
    </div>
    <div class="table-responsive">
        <table id="table" data-search="true" data-show-export="true"
               data-show-columns="true" data-show-pagination-switch="true"
               data-show-toggle="true" data-show-refresh="true"  class="table-condensed">
            <thead class="bg-info">
            </thead>
        </table>
    </div>
</div>
<div id="enroll-info" class="panel panel-primary" style="display: none">
    <div class="panel-heading" >
        <h4><span id="title">开课班学生信息</span></h4>
    </div>
    <div class="table-responsive">
        <table id="table2" data-search="true" data-show-export="true"
               data-show-columns="true" data-show-pagination-switch="true"
               data-show-toggle="true" data-show-refresh="true"  class="table-condensed">
            <thead class="bg-info">
            </thead>
        </table>
    </div>
    <div id="toolbar2">
        <div class="btn-group" role="group">
            <button id="back" type="button" class="btn btn-default ">
                <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> 返回
            </button>
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

<script>
    $(document).ready(function () {
        var $table=$("#table");
        //初始化表格
        $table.bootstrapTable({
            url:'../connections/courseclassinfo.php',
            method:'post',
            dataType:'json',
            columns:[{
                field:"index",
                title:"ID",
                visible:true,
                formatter:function(value, row, index){
                    return row.index=index+1;
                }
            },{
                field:'courseClassNo',
                title:'开课班号'
            },{
                field:'courseName',
                title:'课程名'
            },{
                field:'teacherName',
                title:'任课教师'
            },{
                field:'creditHour',
                title:'学分'
            },{
                field:'capacity',
                title:'限选'
            },{
                field:'enrollNumber',
                title:'已选'
            },{
                field:'open',
                title:'操作',
                align:'center',
                formatter:function(value, row, index){
                    return "<button type='button' class='open btn btn-xs btn-primary'>查看/更新</button>"
                },
                events:'operateEvents'
            }],
            pagination:'true',
            paginationLoop:false,
            pageNumber:1,
            pageSize:10,
            toolbar:'#toolbar',
            clickToSelect:'true'

        });
        $(function () {
            var $table2=$("#table2");
            var courseNo;       //课程号
            var courseClassNo;  //开课班号
            var courseName;     //课程名
           //查看、更新开课班信息表
            window.operateEvents = {
                'click .open':function (e,value,row,index) {
                    courseNo=row.courseNo;
                    courseClassNo=row.courseClassNo;
                    courseName=row.courseName;
                    $("#courseClass-info").hide();
                    $("#enroll-info").show();
                    $title=$("#title");
                    $title.text("班级号：" + courseClassNo + " 班级名：" +courseName + " 限选：" + row.capacity + " 任课教师：" + row.teacherName);
                    //初始化表格
                    $table2.bootstrapTable('destroy');
                    $table2.bootstrapTable({
                        url: '../connections/enrollinfo.php?courseClassNo=' + row.courseClassNo,
                        method: 'get',
                        dataType: 'json',
                        columns: [{
                            checkbox:'true'
                        },{
                            field: "index",
                            title: "ID",
                            visible: true,
                            formatter: function (value, row, index) {
                                return row.index = index + 1;
                            }
                        }, {
                            field: 'instituteName',
                            title: '学院名称'
                        }, {
                            field: 'className',
                            title: '班级名称'
                        }, {
                            field: 'studentNo',
                            title: '学号'
                        }, {
                            field: 'studentName',
                            title: '姓名'
                        }, {
                            field: 'sex',
                            title: '性别'
                        }, {
                            field: 'phoneNumber',
                            title: '联系电话'
                        }, {
                            field: 'score',
                            title: '总成绩',
                        }],
                        pagination: 'true',
                        paginationLoop: false,
                        pageNumber: 1,
                        pageSize: 10,
                        toolbar: '#toolbar2',
                        clickToSelect: 'true'
                    });
                }
            };
            //返回上一层
            $("#back").click(function () {
                $("#enroll-info").hide();
                $("#courseClass-info").show();
            });

            //增加、修改、删除学生选课信息
            //增加
            var arr=new Array(5);
            $("#add").click(function () {
                $("#addModal").modal('show');
            });
            $("#addData").click(function () {
                arr[0]=$("#add-studentNo").val();
                arr[1]=courseNo;
                arr[2]=courseClassNo;
                $.post('../connections/enrollinfo.php',{action:"add",arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('refresh');
                        $table2.bootstrapTable('refresh');
                    }else{
                        alert("操作无效！");
                    }
                });
            });

            //修改
            $("#mod").click(function () {
                $("#modModal").modal('show');
                var arrs = $.map($table2.bootstrapTable('getSelections'), function (row) {
                    return row;
                });
                arr[0]=arrs[0].studentNo;
                arr[1]=arrs[0].courseNo;
                arr[2]=arrs[0].courseClassNo;
                $("#mod-studentNo").val(arr[0]);
                $("#mod-studentName").val(arrs[0].studentName);
            });
            $("#modData").click(function () {
                arr[3]=$("#mod-grade").val();
                arr[4]="2008-08-08";
                $.post('../connections/enrollinfo.php',{action:"mod",arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('refresh');
                        $table2.bootstrapTable('refresh');
                    }else{
                        alert("操作无效！");
                    }
                });
            });
            //删除
            $("#del").click(function () {
                var arrs = $.map($table2.bootstrapTable('getSelections'), function (row) {
                    return row;
                });
                arr[0]=arrs[0].studentNo;
                arr[1]=arrs[0].courseNo;
                arr[2]=arrs[0].courseClassNo;
                $.post('../connections/enrollinfo.php',{action:"del",arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('refresh');
                        $table2.bootstrapTable('refresh');
                    }else{
                        alert("操作无效！");
                    }
                });
            });

        });
    });
</script>
<div id="addModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">增加选课学生</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <br/>
                        <div class="form-group has-feedback">
                            <label for="add-studentNo" class="control-label">学号:</label>
                            <input type="text" class="form-control" id="add-studentNo" maxlength="12">
                            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button class="btn btn-primary" id="addData" data-dismiss="modal">确认</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="modModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">登记成绩</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <br/>
                        <div class="form-group">
                            <label for="mod-studentNo" class="control-label">学号:</label>
                            <input type="text" class="form-control" id="mod-studentNo" maxlength="12" disabled>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-studentName" class="control-label">学生姓名:</label>
                                    <input type="text" class="form-control" id="mod-studentName" disabled>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-grade" class="control-label">成绩:</label>
                                    <input type="text" class="form-control" id="mod-grade" maxlength="3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button class="btn btn-primary" id="modData" data-dismiss="modal">确认</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</HTML>