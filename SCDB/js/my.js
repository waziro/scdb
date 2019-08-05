/**
 * Created by Badboy on 2017/10/22.
 */
$(document).ready(function () {
    $("#info-query").click(function () {
        $(".sidebar ul").attr("style","display:none");
        $("#1").attr("style","display:block");
    });
    $("#course-enroll").click(function () {
        $(".sidebar ul").attr("style","display:none");
        $("#2").attr("style","display:block");
    });
    $("#enroll-management").click(function () {
        $(".sidebar ul").attr("style","display:none");
        $("#3").attr("style","display:block");
    });
    //学生用户相关版块
    $(".call-student-info").click(function () {
        $(".content .panel").hide();
        $("#student-info").show();
    });
    $(".call-class-info").click(function () {
        $(".content .panel").hide();
        $("#class-info").show();
    });
    $(".call-course-grade").click(function () {
        $(".content .panel").hide();
        $("#course-grade").show();
    });
    $(".call-personal-enroll").click(function () {
        $(".content .panel").hide();
        $("#personal-enroll").show();
    });
    //检测新密码输入是否一致
    $("#newPassword1").focusout(function () {
        if($("#newPassword1").val()==$("#newPassword2").val()){
            $("#confirmPassword").removeAttr("disabled");
            $("#notSame").hide();
        }else{
            $("#confirmPassword").attr("disabled","false");
            $("#notSame").show();
        }
    });
    $("#newPassword2").focusout(function () {
        if($("#newPassword1").val()==$("#newPassword2").val()){
            $("#confirmPassword").removeAttr("disabled");
            $("#notSame").hide();
        }else{
            $("#confirmPassword").attr("disabled","false");
            $("#notSame").show();
        }
    });
    //执行修改密码操作
    $("#confirmPassword").click(function () {
        $.post("connections/modifypasswd.php",{password1:$("#newPassword1").val(),password2:$("#newPassword2").val()},function (data) {
            alert(data);
        });
    });
    $("#destroySession").click(function () {
        $("#destroySession").load("connections/destroysession.php");
    });
    //教师用户相关板块
    $(".call-teacher-info").click(function () {
        $(".content .panel").hide();
        $("#teacher-info").show();
    });
    $(".call-courseclass-info").click(function () {
        $(".content .panel").hide();
        $("#courseclass-info").show();
    });
    //系统管理员用户相关板块
    $(".call-institute-info").click(function () {
        $(".content .panel").hide();
        $("#institute-info").show();
    });
    $(".call-all-class-info").click(function () {
        $(".content .panel").hide();
        $("#all-class-info").show();
    });
    $(".call-all-teacher-info").click(function () {
        $(".content .panel").hide();
        $("#all-teacher-info").show();
    });
    $(".call-all-course-info").click(function () {
        $(".content .panel").hide();
        $("#all-course-info").show();
    });
    $(".call-all-student-info").click(function () {
        $(".content .panel").hide();
        $("#all-student-info").show();
    });
    $(".call-add-courseclass").click(function () {
        $(".content .panel").hide();
        $("#add-courseclass").show();
    });
    $(".call-add-enroll-info").click(function () {
        $(".content .panel").hide();
        $("#all-enroll-info").show();
    });
});