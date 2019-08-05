<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/10/29
 * Time: 20:51
 */
session_start();
include "db.php";

//检测密码是否一致
$userNo=$_SESSION['username'];
$password1=$_POST['password1'];
$password2=$_POST['password2'];
if($password1==$password2) {
    try {
        switch (strlen($userNo)){
            case 5: $sql = "update teacher set password='$password1' where teacherNo='$userNo'"; break;
            case 10: $sql = "update administrator set password='$password1' where username='$userNo'"; break;
            case 12: $sql = "update student set password='$password1' where studentNo='$userNo'"; break;
            default: $sql = "update student set password='$password1' where md5(studentNo)='$userNo'"; break;
        };
        $pds = $pdo->exec($sql);
        if($pds){
            echo "修改密码成功！";
        }else{
            echo "修改密码失败！";
        }
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }
}
$pds=null;
$pdo=null;

