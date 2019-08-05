<?php
session_start();
//读取Cookie数据
if(isset($_SESSION['username']) and isset($_COOKIE['username']) and $_COOKIE['isloged']=='TRUE'){

}else{
    //如果Cookie中没有登录信息，则自动跳转到登录页面
    echo '<script>window.location="index.php";</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>教学管理系统（测试）</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="style/my.css">
    <script src="bootstrap/js/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="js/my.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!--顶部导航栏-->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0);"><strong>VOTOBE</strong></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav" id="mytab">
                <li class="dropdown active">
                    <a id="info-query" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">信息查询
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="call-institute-info"><a href="javascript:void(0);">院系信息</a></li>
                        <li role="presentation" class="divider"></li>
                        <li class="call-all-class-info"><a href="javascript:void(0);">班级信息</a></li>
                        <li role="presentation" class="divider"></li>
                        <li class="call-all-course-info"><a href="javascript:void(0);">课程信息</a></li>
                        <li role="presentation" class="divider"></li>
                        <li class="call-all-teacher-info"><a href="javascript:void(0);">教师信息</a></li>
                        <li role="presentation" class="divider"></li>
                        <li class="call-all-student-info"><a href="javascript:void(0);">学生信息</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a id="enroll-management" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">开课管理
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="call-add-courseclass"><a href="javascript:void(0);">新增开课班</a></li>
                        <li role="presentation" class="divider"></li>
                        <li class="call-add-enroll-info"><a href="javascript:void(0);">选课情况</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a id="user-manager" href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">账户管理
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li data-toggle="modal" data-target="#myModal"><a href="javascript:void(0);">修改密码</a></li>
                        <li role="presentation" class="divider"></li>
                        <li id="destroySession"><a href="javascript:void(0);">注销账号</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-right">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="关键字查找">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
                <button type="submit" class="btn btn-default">确认</button>
            </form>
        </div>
    </div>
</nav>
<script>
    $("#mytab").find("a").click(function (e) {
        e.preventDefault();
        $(this).tab("show");
    })
</script>
<br/><br/><br/>
<!--主体内容-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2 col-md-2 sidebar">
            <ul id="1" class="nav navbar-default" style="display: block">
                <li class="call-institute-info"><a href="javascript:void(0);">院系信息</a></li>
                <li class="call-all-class-info"><a href="javascript:void(0);">班级信息</a></li>
                <li class="call-all-course-info"><a href="javascript:void(0);">课程信息</a></li>
                <li class="call-all-teacher-info"><a href="javascript:void(0);">教师信息</a></li>
                <li class="call-all-student-info"><a href="javascript:void(0);">学生信息</a></li>
            </ul>
            <ul id="3" class="nav navbar-default" style="display: none">
                <li class="call-add-courseclass"><a href="javascript:void(0);">新增开课班</a></li>
                <li class="call-add-enroll-info"><a href="javascript:void(0);">选课情况</a></li>
            </ul>
        </div>
        <div class="col-sm-10 col-md-10 col-sm-offset-2 col-md-offset-2 content">
            <div id="institute-info" class="panel" style="display: block">
                <div class="embed-responsive" style="height: 620px">
                    <iframe class="embed-responsive-item" src="panel/showinstituteinfo.php"></iframe>
                </div>
            </div>
            <div id="all-class-info" class="panel" style="display: none">
                <div class="embed-responsive" style="height: 620px">
                    <iframe class="embed-responsive-item" src="panel/showallclassinfo.php"></iframe>
                </div>
            </div>
            <div id="all-course-info" class="panel" style="display: none">
                <div class="embed-responsive" style="height: 620px">
                    <iframe class="embed-responsive-item" src="panel/showallcourseinfo.php"></iframe>
                </div>
            </div>
            <div id="all-teacher-info" class="panel" style="display: none">
                <div class="embed-responsive" style="height: 620px">
                    <iframe class="embed-responsive-item" src="panel/showallteacherinfo.php"></iframe>
                </div>
            </div>
            <div id="all-student-info" class="panel" style="display: none">
                <div class="embed-responsive" style="height: 620px">
                    <iframe class="embed-responsive-item" src="panel/showallstudentinfo.php"></iframe>
                </div>
            </div>
            <div id="add-courseclass" class="panel" style="display: none">
                <div class="embed-responsive" style="height: 620px">
                    <iframe class="embed-responsive-item" src="panel/showaddcourseclass.php"></iframe>
                </div>
            </div>
            <div id="all-enroll-info" class="panel" style="display: none">
                <div class="embed-responsive" style="height: 620px">
                    <iframe class="embed-responsive-item" src="panel/showenrollinfo.php"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!--密码修改模态框-->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="form-group">
                            <input name="newPassword1" type="password" class="form-control" id="newPassword1" placeholder="请输入新密码" required>
                        </div>
                        <div class="form-group">
                            <input name="newPassword2" type="password" class="form-control" id="newPassword2" placeholder="请再次输入" required>
                        </div>
                        <span class="label label-warning" id="notSame"  style="display:none">输入的密码不一致</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" disabled  data-dismiss="modal" id="confirmPassword">确认</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>