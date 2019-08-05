<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 20:05
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
<div id="course-grade" class="panel panel-primary">
    <div class="panel-heading">
        <h4>课程成绩</h4>
    </div>
    <div class="table-responsive">
        <table id="table" data-search="true" data-show-columns="true" data-show-pagination-switch="true"
               data-show-toggle="true" data-show-refresh="true"  class="table-condensed">
            <thead class="bg-info">
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        var $table = $("#table");
        //初始化表格
        $table.bootstrapTable({
            url: '../connections/enrollinfo.php?studentNo=<?php echo $_SESSION['username'] ?>',
            method: 'get',
            dataType: 'json',
            columns: [{
                field: "index",
                title: "ID",
                visible: true,
                formatter: function (value, row, index) {
                    return row.index = index + 1;
                }
            }, {
                field: 'studentNo',
                title: '学号'
            }, {
                field: 'studentName',
                title: '姓名'
            }, {
                field: 'courseNo',
                title: '课程号'
            }, {
                field: 'courseName',
                title: '课程名称'
            }, {
                field: 'creditHour',
                title: '学分'
            }, {
                field: 'courseHour',
                title: '课时'
            }, {
                field: 'score',
                title: '总成绩'
            }, {
                field: 'ps',
                title: '备注'
            }],
            pagination: 'true',
            paginationLoop: false,
            pageNumber: 1,
            pageSize: 10,
            toolbar: '#toolbar',
            clickToSelect: 'true'

        });
    });
</script>
</body>
</HTML>