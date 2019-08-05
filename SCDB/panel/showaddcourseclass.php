<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 21:28
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
    <script src="../bootstrap/js/bootstrap-table-zh-CN.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .table-hover tbody tr:hover{
            background-color: #f0ad4e;
        }
    </style>
</head>
<body>
<div id="add-courseclass" class="panel panel-info">
    <div id="all-course-info" class="panel panel-primary" style="width:49%;float: left">
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
                <button id="add" type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 加入
                </button>
            </div>
        </div>
    </div>
    <div id="courseclass-info" class="panel panel-primary" style="width:49%;float: right" >
        <div class="panel-heading" >
            <h4>开课班</h4>
        </div>
        <div class="table-responsive">
            <table id="table2" data-search="true" data-show-pagination-switch="true"
                   data-show-refresh="true"  class="table-condensed">
                <thead class="bg-info">
                </thead>
            </table>
        </div>
        <div id="toolbar2">
            <div class="btn-group" role="group">
                <button id="open" type="button" class="btn btn-success">
                    <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> 开放
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
        var $table2=$("#table2");
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
            paginationLoop:false,
            pageNumber:1,
            pageSize:10,
            toolbar:'#toolbar',
            clickToSelect:'true'

        });
        $table2.bootstrapTable({
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
                title:'开课班号',
                sortable:'true'
            },{
                field:'courseNo',
                title:'课程号'
            },{
                field:'courseName',
                title:'课程名'
            },{
                field:'teacherName',
                title:'任课教师'
            },{
                field:'year',
                title:'年份'
            },{
                field:'semester',
                title:'学期'
            },{
                field:'capacity',
                title:'班级容量'
            },{
                field:'enrollNumber',
                title:'已选人数'
            }],
            pagination:'true',
            paginationLoop:false,
            pageNumber:1,
            pageSize:10,
            toolbar:'#toolbar2',
            clickToSelect:'true',

        });
        //设置开课班
        $(function () {
            var arr=new Array(6);             //定义基本变量
            var oldIndex;
            var oldPk;
           //新增开课班
            $("#add").click(function () {
                var arrs = $.map($table.bootstrapTable('getSelections'), function (row) {
                    return row;
                });
                arr[1]=arrs[0].courseNo;
                $("#addModal").modal('show');
                $("#add-courseNo").val(arr[1]);         //加载选中数据
                $("#add-enrollNumber").val(0);

                $courseTeacherNo=$("#add-courseTeacherNo"); //设置主讲该课程的任课老师下拉单选框
                $courseTeacherNo.empty();
                $.post('../connections/allteacherinfo.php',{},function (data) {
                    var flag=true;
                    if(data!=""){
                        var jsonObj = eval("(" + data + ")");   //json数据转换为json对象
                        for(var i=0; i<jsonObj.length; i++){
                            if(jsonObj[i].courseNo1==arr[1]||jsonObj[i].courseNo2==arr[1]||jsonObj[i].courseNo3==arr[1]){
                                $courseTeacherNo.append("<option value='" + jsonObj[i].teacherNo + "'>" + jsonObj[i].teacherName + "</option>");
                                flag=false;
                            }
                        }
                    }
                    if(flag){
                        $courseTeacherNo.append("<option>该课程暂无任课教师</option>");
                    }
                });
            });
            $("#addData").click(function () {
                arr[0]=$("#add-courseClassNo").val();
                arr[1]=$("#add-courseNo").val();
                arr[2]=$("#add-courseTeacherNo").val();
                arr[3]=$("#add-year").val();
                arr[4]=$("#add-semester").val();
                arr[5]=$("#add-capacity").val();
                arr[6]=$("#add-enrollNumber").val();
                if(arr[0]!=""){
                    $.post('../connections/courseclassinfo.php',{action:"add",arr:arr},function (data) {
                        if(data){
                            $table2.bootstrapTable('refresh');
                        }else{
                            alert("操作无效！");
                        }
                    });
                }else{
                    alert("输入数据有误！");
                }
            });
            //修改开课班
            $("#mod").click(function () {
                var arrs = $.map($table2.bootstrapTable('getSelections'), function (row) {
                    return row;
                });
                arr[0]=arrs[0].courseClassNo;
                arr[1]=arrs[0].courseNo;
                arr[2]=arrs[0].courseTeacherNo;
                arr[3]=arrs[0].year;
                arr[4]=arrs[0].semester;
                arr[5]=arrs[0].capacity;
                arr[6]=arrs[0].enrollNumber;
                oldIndex=arrs[0].index;                  //存储行索引
                oldPk=arr[0];                            //存储原有主键值
                $("#modModal").modal('show');
                $("#mod-courseClassNo").val(arr[0]);       //加载原有数据
                $("#mod-courseNo").val(arr[1]);
                $("#mod-year").val(arr[3]);
                $("#mod-semester").val(arr[4]);
                $("#mod-capacity").val(arr[5]);
                $("#mod-enrollNumber").val(arr[6]);

                $courseTeacherNo=$("#mod-courseTeacherNo"); //设置主讲该课程的任课老师下拉单选框
                $courseTeacherNo.empty();
                $courseTeacherNo.append("<option value='" + arr[2] + "'>" + arrs[0].teacherName + "</option>");
                $.post('../connections/allteacherinfo.php',{},function (data) {
                    var flag=true;
                    if(data!=""){
                        var jsonObj = eval("(" + data + ")");   //json数据转换为json对象
                        for(var i=0; i<jsonObj.length; i++){
                            if(jsonObj[i].courseNo1==arr[1]||jsonObj[i].courseNo2==arr[1]||jsonObj[i].courseNo3==arr[1]){
                                $courseTeacherNo.append("<option value='" + jsonObj[i].teacherNo + "'>" + jsonObj[i].teacherName + "</option>");
                                flag=false;
                            }
                        }
                    }
                    if(flag){
                        $courseTeacherNo.append("<option>该课程暂无任课教师</option>");
                    }
                });
            });
            $("#modData").click(function () {       //同步到数据库
                arr[0]=$("#mod-courseClassNo").val();
                arr[1]=$("#mod-courseNo").val();
                arr[2]=$("#mod-courseTeacherNo").val();
                arr[3]=$("#mod-year").val();
                arr[4]=$("#mod-semester").val();
                arr[5]=$("#mod-capacity").val();
                arr[6]=$("#mod-enrollNumber").val();
                if(arr[0]!=""){
                    $.post('../connections/courseclassinfo.php',{action:"mod",oldPk:oldPk,arr:arr},function (data) {
                        if(data){
                            $table2.bootstrapTable('refresh');
                        }else{
                            alert("操作无效！");
                        }
                    });
                }else{
                    alert("输入数据有误！");
                }
            });
            //删除开课班级
            $("#del").click(function () {
                var ids = $.map($table2.bootstrapTable('getSelections'), function (row) {
                    return row.courseClassNo;
                });
                $.post('../connections/courseclassinfo.php',{action:"del",courseClassNos:ids},function (data) {
                    if(data){
                        $table2.bootstrapTable('remove', {field: 'courseClassNo', values: ids});
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
                <h4 class="modal-title">新增开课班</h4>
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <form>
                        <br/>
                        <div class="form-group">
                            <label for="add-courseClassNo" class="control-label">开课班号:</label>
                            <input type="text" class="form-control" id="add-courseClassNo" maxlength="8">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-courseNo" class="control-label">课程号:</label>
                                    <input type="text" class="form-control" id="add-courseNo" disabled>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-courseTeacherNo" class="control-label">任课教师:</label>
                                    <select type="text" class="form-control" id="add-courseTeacherNo">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-year" class="control-label">年份:</label>
                                    <input type="text" class="form-control" id="add-year" maxlength="4">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-semester" class="control-label">学期:</label>
                                    <input type="text" class="form-control" id="add-semester" maxlength="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-capacity" class="control-label">班级容量:</label>
                                    <input type="text" class="form-control" id="add-capacity" maxlength="3">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="add-enrollNumber" class="control-label">已选人数:</label>
                                    <input type="text" class="form-control" id="add-enrollNumber" maxlength="3">
                                </div>
                            </div>
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
                <h4 class="modal-title">新增开课班</h4>
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2">
                    <form>
                        <br/>
                        <div class="form-group">
                            <label for="mod-courseClassNo" class="control-label">开课班号:</label>
                            <input type="text" class="form-control" id="mod-courseClassNo" maxlength="8">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-courseNo" class="control-label">课程号:</label>
                                    <input type="text" class="form-control" id="mod-courseNo" disabled>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-courseTeacherNo" class="control-label">任课教师:</label>
                                    <select type="text" class="form-control" id="mod-courseTeacherNo">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-year" class="control-label">年份:</label>
                                    <input type="text" class="form-control" id="mod-year" maxlength="4">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-semester" class="control-label">学期:</label>
                                    <input type="text" class="mod-control" id="mod-semester" maxlength="1">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-capacity" class="control-label">班级容量:</label>
                                    <input type="text" class="form-control" id="mod-capacity" maxlength="3">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="mod-enrollNumber" class="control-label">已选人数:</label>
                                    <input type="text" class="form-control" id="mod-enrollNumber" maxlength="3">
                                </div>
                            </div>
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