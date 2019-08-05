<?php
if(!isset($_GET['key'])){
    echo '<script>window.location ="../index.php";</script>';
}else{
    $key=$_GET['key'];
    session_start();
    $_SESSION['username']=$key;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>密码重置</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-table.css">
    <link rel="stylesheet" href="../style/my.css">
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<!--密码修改模态框-->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">重置密码</h4>
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="confirmPassword">确认</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</body>
<script>
    $myModal=$('#myModal');
    $myModal.modal('show');
    $myModal.on('hidden.bs.modal', function (e) {
        $pwd1=$('#newPassword1').val();
        $pwd2=$('#newPassword2').val();
        if($pwd1==""||$pwd2==""){
            alert("密码不能为空！请重新输入");
            $myModal.modal('show');
        }else if($pwd1!=$pwd2){
            alert("两次输入密码不一致！请重新输入");
            $myModal.modal('show');
        }else{
            $.post("../connections/modifypasswd.php",{password1:$pwd1,password2:$pwd2},function (data) {
                alert(data);
                window.location="../index.php";
            });
        }
    })
</script>
</html>
