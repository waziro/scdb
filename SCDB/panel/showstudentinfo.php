<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 19:55
 */
session_start();
include "../connections/studentinfo.php";
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
<div id="student-info" class="panel panel-primary">
    <div class="panel-heading">
        <h4>学籍信息</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive person">
            <table class="table" id="table">
                <tr>
                    <th colspan="100%"><h4>个人信息</h4></th>
                </tr>
                <tr>
                    <td>学号：<span id="studentNo"><?php echo $row[studentNo]; ?></span></td>
                    <td>姓名：<span id="studentName"><?php echo $row['studentName']; ?></span></td>
                    <td>性别：<span id="sex"><?php echo $row['sex']; ?></span></td>
                </tr>
                <tr>
                    <td>出生日期：<span id="birthday"><?php echo $row['birthday']; ?></span></td>
                    <td>联系电话：<span id="phoneNumber"><?php echo $row['phoneNumber']; ?></span></td>
                    <td>电子邮箱：<span id="email"><?php echo $row['email']; ?></span></td>
                </tr>
                <tr>
                    <td id="address" colspan="3">家庭住址：
                        <span id="province"><?php echo $row['province']; ?></span>
                        <span id="city"><?php echo $row['city']; ?></span>
                        <span id="street"><?php echo $row['street']; ?></span>
                    </td>
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
                    <td id="grade">年级：<?php echo $row['grade']; ?></td>
                    <td id="className">班级名称：<?php echo $row['className']; ?></td>
                </tr>
                <tr>
                    <th colspan="100%"><h4>其他信息</h4></th>
                </tr>
            </table>
        </div>
    </div>
    <div class="panel-footer">
        <button id="mod" class="btn btn-default">修改</button>
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mod-birthday" class="control-label">出生日期:</label>
                                    <input type="text" class="form-control" id="mod-birthday" maxlength="10">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mod-phoneNumber" class="control-label">联系电话:</label>
                                    <input type="text" class="form-control" id="mod-phoneNumber">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mod-email" class="control-label">电子邮箱:</label>
                            <input type="text" class="form-control" id="mod-email">
                        </div>
                        <div class="form-group">
                            <label for="mod-address" class="control-label">家庭住址:</label>
                            <input type="text" class="form-control" id="mod-province" placeholder="省/市/自治区">
                            <input type="text" class="form-control" id="mod-city" placeholder="省/市">
                            <input type="text" class="form-control" id="mod-street" placeholder="区/街道">
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
        $("#mod").click(function (){
            $("#modModal").modal('show');
            $("#mod-studentName").val($("#studentName").text());        //加载原有数据
            $("#mod-sex").val($("#sex").text());
            $("#mod-birthday").val($("#birthday").text());
            $("#mod-phoneNumber").val($("#phoneNumber").text());
            $("#mod-email").val($("#email").text());
            $("#mod-province").val($("#province").text());
            $("#mod-city").val($("#city").text());
            $("#mod-street").val($("#street").text());
        });
        $("#modData").click(function () {       //同步到数据库
            var arr = new Array(8);
            var oldPk=$("#studentNo").text();
            arr[0] = $("#mod-studentName").val();
            arr[1] = $("#mod-sex").val();
            arr[2] = $("#mod-birthday").val();
            arr[3] = $("#mod-phoneNumber").val();
            arr[4] = $("#mod-email").val();
            arr[5] = $("#mod-province").val();
            arr[6] = $("#mod-city").val();
            arr[7] = $("#mod-street").val();
            $.post('../connections/studentinfo.php', {action: "mod", oldPk: oldPk, arr: arr}, function (data) {
                if (data) {
                    alert("修改成功！");
                    $("#studentName").text(arr[0]);
                    $("#sex").text(arr[1]);
                    $("#birthday").text(arr[2]);
                    $("#phoneNumber").text(arr[3]);
                    $("#email").text(arr[4]);
                    $("#province").text(arr[5]);
                    $("#city").text(arr[6]);
                    $("#street").text(arr[7]);
                } else {
                    alert("操作无效！");
                }
            });
        });
    });
</script>
</body>
</HTML>