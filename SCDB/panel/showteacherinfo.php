<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 20:34
 */
session_start();
include "../connections/teacherinfo.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>教学管理系统（测试）</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="teacher-info" class="panel panel-primary">
    <div class="panel-heading">
        <h4>教师信息</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th colspan="100%"><h4>个人信息</h4></th>
                </tr>
                <tr>
                    <td>教工号：<span id="teacherNo"><?php echo $row['teacherNo'] ?></span></td>
                    <td>姓名：<span id="teacherName"><?php echo $row['teacherName'] ?></span></td>
                </tr>
                <tr>
                    <td>职称：<span id="title"><?php echo $row['title'] ?></span></td>
                    <td>学位：<span id="degree"><?php echo $row['degree'] ?></span></td>
                </tr>
                <tr>
                    <th colspan="100%"><h4>学院信息</h4></th>
                </tr>
                <tr>
                    <td>院号：<span id="instituteNo"><?php echo $row['instituteNo']; ?></span></td>
                    <td>院系：<span id="instituteName"><?php echo $row['instituteName']; ?></span></td>
                    <td>院长：<span id="deanName"><?php echo $row['deanName']; ?></span></td>
                </tr>
                <tr>
                    <td>主讲课程一：<span id="courseNo1"><?php echo $courseName[0] ?></span></td>
                    <td>主讲课程二：<span id="courseNo2"><?php echo $courseName[1] ?></span></td>
                    <td>主讲课程三：<span id="courseNo3"><?php echo $courseName[2] ?></span></td>
                </tr>
                <tr>
                    <td>聘用日期：<span id="hireDate"><?php echo $row['hireDate']; ?></span></td>
                </tr>
                <tr>
                    <th colspan="100%"><h4>其他信息</h4></th>
                </tr>
            </table>
        </div>
    </div>
    <div class="panel-footer">
        <button class="btn btn-default" id="mod">修改</button>
    </div>
</div>
<div id="modModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改信息</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="form-group">
                            <label for="mod-courseName1">主讲课程一</label>
                            <select type="text" class="form-control" id="mod-courseName1">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mod-courseName2">主讲课程二</label>
                            <select type="text" class="form-control" id="mod-courseName2">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mod-courseName3">主讲课程三</label>
                            <select type="text" class="form-control" id="mod-courseName3">
                            </select>
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

<script>
    $(document).ready(function () {
       $(function () {
           var arr = new Array(10);
           var oldPk = $("#teacherNo").text();
           $courseName1=$("#mod-courseName1");
           $courseName2=$("#mod-courseName2");
           $courseName3=$("#mod-courseName3");
           $("#mod").click(function () {
               $("#modModal").modal('show');
               $courseName1.empty();
               $courseName2.empty();
               $courseName3.empty();
               $courseName1.append("<option value='<?php echo $row[courseNo1]; ?>'>" + $("#courseNo1").text() + "</option>");
               $courseName2.append("<option value='<?php echo $row[courseNo2]; ?>'>" + $("#courseNo2").text() + "</option>");
               $courseName3.append("<option value='<?php echo $row[courseNo3]; ?>'>" + $("#courseNo3").text() + "</option>");
               $.post('../connections/allcourseinfo.php',{},function (data) {
                   if(data!=""){
                       var jsonObj=eval("(" + data + ")");
                       for(var i=0; i<jsonObj.length; i++){
                           $courseName1.append("<option value='" + jsonObj[i].courseNo + "'>" + jsonObj[i].courseName + "</option>");
                           $courseName2.append("<option value='" + jsonObj[i].courseNo + "'>" + jsonObj[i].courseName + "</option>");
                           $courseName3.append("<option value='" + jsonObj[i].courseNo + "'>" + jsonObj[i].courseName + "</option>");
                       }
                   }
               });
           });
           $("#modData").click(function () {
               arr[7]=$courseName1.val();
               arr[8]=$courseName2.val();
               arr[9]=$courseName3.val();
               $.post('../connections/teacherinfo.php',{action:"mod",arr:arr,oldPk:oldPk},function (data) {
                   if(data){
                       alert("修改成功！");
                       $("#courseNo1").text($("#mod-courseName1 option:selected").text());
                       $("#courseNo2").text($("#mod-courseName2 option:selected").text());
                       $("#courseNo3").text($("#mod-courseName3 option:selected").text());
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