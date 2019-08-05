<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 21:32
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
    <script src="../bootstrap/js/bootstrap-table-zh-CN.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .table-hover tbody tr:hover{
            background-color: #f0ad4e;
        }
    </style>
</head>
<body>
<div id="personal-info" class="panel panel-primary">

    <div id="optional-course" class="panel panel-primary" style="width:65%;float: left">
        <div class="panel-heading" >
            <h4>可选课程</h4>
        </div>
        <div class="table-responsive">
            <table id="table" data-search="true" data-show-pagination-switch="true"
                   data-show-refresh="true"  class="table-condensed">
                <thead class="bg-info">
                </thead>
            </table>
        </div>
        <div id="toolbar">
            <div class="btn-group" role="group">
                <button id="sel" type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> 选入
                </button>
            </div>
        </div>
    </div>
    <div id="selected-course" class="panel panel-primary" style="width:34%;float: right" >
        <div class="panel-heading" >
            <h4>已选课程</h4>
        </div>
        <div class="table-responsive">
            <table id="table2" data-show-refresh="true"  class="table-condensed">
                <thead class="bg-info">
                </thead>
            </table>
        </div>
        <div id="toolbar2">
            <div class="btn-group" role="group">
                <button id="del" type="button" class="btn btn-danger ">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 重选
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var $table=$("#table");
        var $table2=$("#table2");
        //初始化表格
        $table.bootstrapTable({
            url:'../connections/courseclassinfo.php',
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
            }],
            pagination:'true',
            paginationLoop:false,
            pageNumber:1,
            pageSize:10,
            toolbar:'#toolbar',
            clickToSelect:'true'

        });

        $table2.bootstrapTable({
            url:'../connections/enrollinfo.php?studentNo=<?php echo $_SESSION['username'] ?>',
            method:'get',
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
                field:'courseClassNo',
                title:'开课班号'
            },{
                field:'courseName',
                title:'课程名'
            },{
                field:'teacherName',
                title:'任课教师'
            }],
            toolbar:'#toolbar2',
            clickToSelect:'true'

        });
        //选课相应操作
        $(function () {
            var arr=new Array(3);
            $("#sel").click(function () {
                var arrs = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row;
                });
                arr[0]=arrs[0].courseClassNo;
                arr[1]=arrs[0].courseNo;
                arr[2]=<?php echo $_SESSION['username'] ?>;
                $.post('../connections/courseclassinfo.php',{action:"select",arr:arr},function (data) {
                    if(data){
                        $table.bootstrapTable('refresh');
                        $table2.bootstrapTable('refresh');
                    }else{
                        alert("操作无效！");
                    }
                });
            });
            $("#del").click(function () {
                var arrs = $.map($table2.bootstrapTable('getSelections'), function (row) {
                    return row;
                });
                arr[0]=<?php echo $_SESSION['username'] ?>;
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
</body>
</HTML>