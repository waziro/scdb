<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/10/28
 * Time: 22:32
 */
include "db.php";
$row=1;
//修改行数据
if($_POST['action']==="mod"){
    try{
        $arr=$_POST['arr'];
        $sql="update student set studentName='$arr[0]',sex='$arr[1]',birthday='$arr[2]',phoneNumber='$arr[3]',email='$arr[4]',province='$arr[5]',city='$arr[6]',street='$arr[7]' where studentNo='{$_POST['oldPk']}'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}

try{
    //查询学生信息，及其所在班级和所属学院信息
    $studentNo=$_SESSION['username'];
    $sql="select * from student,class,institute where studentNo='$studentNo' AND student.classNo=class.classNo AND institute.instituteNo=class.instituteNo";
    $pds=$pdo->query($sql);
    $row=$pds->fetch();
}catch (Exception $exc){
    echo $exc->getMessage();      //出错时显示错误信息
}
$pds=null;
$pdo=null;