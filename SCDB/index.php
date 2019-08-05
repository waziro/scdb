<?php
session_start();
//从$_POST中获取用户登录提交的用户名和密码
$nm='';
$pwd='';
if(isset($_POST['username']))
    $nm=$_POST['username'];
if(isset($_POST['password']))
    $pwd=$_POST['password'];
//在用户执行登录操作时才执行后继的登录验证操作
if(isset($_POST['username'])){
    //如果存在验证码，先进行验证码校验
    if(isset($_SESSION['checkcode']) AND strtolower($_POST['imgCode'])<>$_SESSION['checkcode']){
        echo '<script>alert("验证码错误！")</script>';
    }else{
        $nm=trim($nm);
        $length=strlen($nm);
        switch ($length){
            case 5: $check=checkLogTeacher($nm,$pwd);break;
            case 10: $check=checkLogAdmin($nm,$pwd);break;
            case 12: $check=checkLog($nm,$pwd);break;
            default: $check=false; break;
        }
        if($check===true){               //通过登录验证
            //设置SESSION
            $_SESSION['username']=$nm;
            //设置Cookie
            setcookie('username',$nm,time()+360);
            setcookie('isloged','TRUE',time()+360);
            //实现页面跳转
            if($length==12){
                echo '<script>window.location="info.php";</script>';
            }elseif($length==5){
                echo '<script>window.location="info2.php";</script>';
            }elseif($length==10){
                echo '<script>window.location="info3.php";</script>';
            }
        }else if($check===false){       //没有通过登录验证
            //检查登录失败次数
            if(!isset($_SESSION['logtimes'])){
                $_SESSION['logtimes']=1;
            }else if($_SESSION['logtimes']<3){
                $_SESSION['logtimes']++;    //更新登录失败次数
            }
            echo '<script>alert("用户名或密码错误！")</script>';
        }else{                          //其他错误原因
            echo '<script>alert('.$check.')</script>';
        }

    }
}
function checkLog($username,$password){
    $dsn="mysql:host=localhost:3306;dbname=scdb";
    try{
        $pdo=new PDO($dsn,'root','admin0714');
        $sql="select password from student WHERE studentNo=$username";
        $pds=$pdo->query($sql);
        $row=$pds->fetch();
        if($row==false||$row['password']<>$password){
            $result=false;
        }else{
            $result=true;
        }
        $pds=null;
        $pdo=null;
        return $result;
    }catch (Exception $exc){
        return $exc->getMessage();      //出错时显示错误信息
    }
}
function checkLogTeacher($username,$password){
    $dsn="mysql:host=localhost:3306;dbname=scdb";
    try{
        $pdo=new PDO($dsn,'root','admin0714');
        $sql="select password from teacher WHERE teacherNo='$username'";
        $pds=$pdo->query($sql);
        $row=$pds->fetch();
        if($row==false||$row['password']<>$password){
            $result=false;
        }else{
            $result=true;
        }
        $pds=null;
        $pdo=null;
        return $result;
    }catch (Exception $exc){
        return $exc->getMessage();      //出错时显示错误信息
    }
}
function checkLogAdmin($username,$password){
    $dsn="mysql:host=localhost:3306;dbname=scdb";
    try{
        $pdo=new PDO($dsn,'root','admin0714');
        $sql="select password from administrator WHERE username='$username'";
        $pds=$pdo->query($sql);
        $row=$pds->fetch();
        if($row==false||$row['password']<>$password){
            $result=false;
        }else{
            $result=true;
        }
        $pds=null;
        $pdo=null;
        return $result;
    }catch (Exception $exc){
        return $exc->getMessage();      //出错时显示错误信息
    }
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .form-horizontal{
            max-width: 300px;
            margin: 0 auto;
        }
        footer{
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        body,.jumbotron{
            background: url("001.jpg");
        }
    </style>
</head>
<body>
<div class="jumbotron" align="center" >
    <h1><strong>教务管理系统</strong></h1>
</div>
<div class="container">
    <form class="form-horizontal" method="post" action>
        <div class="form-group has-feedback">
            <label for="inputUsername" class="col-xs-1 control-label"></label>
            <div class="col-xs-10">
                <input name="username" type="text" class="form-control" id="inputUsername" placeholder="请输入学号或工号" maxlength="12" required autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
        </div>
        <div class="form-group has-feedback">
            <label for="inputPassword" class="col-xs-1 control-label"></label>
            <div class="col-xs-10">
                <input name="password" type="password" class="form-control" id="inputPassword" placeholder="请输入密码" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
        </div>
        <?php
        if($_SESSION['logtimes']>2){
            print <<<HTML
        <div class="form-group">
            <label for="imgCode" class="col-xs-1 control-label"></label>
            <div class="col-xs-5">
                <input name="imgCode" type="text" class="form-control" id="imgCode" placeholder="验证码" required>
            </div>
            <div class="col-xs-5">
                <img id="checkcode" src="getcheckcode.php"  onmouseup="refreshimage()"
                     alt="点击刷新"  title="点击刷新" style="cursor:pointer"/>
            </div>
        </div>
HTML;

        }
        ?>
        <div class="form-group">
            <div class="col-xs-offset-1 col-xs-5">
                <div class="checkbox">
                    <label>
                        <input type="checkbox">记住密码
                    </label>
                </div>
            </div>
            <div class="col-xs-offset-1 col-xs-5">
                <div class="checkbox" data-toggle="modal" data-target="#myModal">
                    <label>
                        <a href="javascript:void(0);">忘记密码</a>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-1 col-xs-10">
                <button type="submit" class="btn btn-primary btn-block">登录</button>
            </div>
        </div>
    </form>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">找回密码</h4>
            </div>
            <form action="phpmailer/sendcheckmail.php" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-8 col-xs-offset-2">
                            <div class="form-group">
                                <label for="email" class="control-label">电子邮箱：</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="请输入电子邮箱" maxlength="30" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" >提交</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<footer class="footer">
    <p>©2017-2017&nbsp;&nbsp;&nbsp;<a href="http://www.miitbeian.gov.cn/" target="_blank" >粤ICP备17125976号</a></p>
</footer>
</body>
</html>
<script>
    //脚本函数 refreshimage()用于刷新图形验证码
    function refreshimage() {
        //单击图形验证码时，刷新验证码，注意img的src属性不同时才会刷新
        document.getElementById('checkcode').src="getcheckcode.php?"+Math.random();
    }
</script>