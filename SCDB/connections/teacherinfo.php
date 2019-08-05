<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/3
 * Time: 19:01
 */
session_start();
include "db.php";
$row=1;
//修改行数据
if($_POST['action']==="mod"){
    try{
        $arr=$_POST['arr'];
        $oldPK=$_POST['oldPk'];
        $sql="update teacher set courseNo1='$arr[7]',courseNo2='$arr[8]',courseNo3='$arr[9]' where teacherNo='$oldPK'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}

try{
    //查询教师信息，及其所属学院信息
    $teacherNo=$_SESSION['username'];
    $sql="select * from teacher,institute where teacherNo='$teacherNo' AND teacher.instituteNo=institute.instituteNo";
    $pds=$pdo->query($sql);
    $row=$pds->fetch();

    $courseName=array();
    $stmt=$pdo->prepare("select courseName from course where courseNo=?");   //预处理
    $stmt->bindParam(1,$courseNo);

    $courseNo=$row[courseNo1];
    $stmt->execute();
    array_push($courseName,$stmt->fetch()[0]);
    $courseNo=$row[courseNo2];
    $stmt->execute();
    array_push($courseName,$stmt->fetch()[0]);
    $courseNo=$row[courseNo3];
    $stmt->execute();
    array_push($courseName,$stmt->fetch()[0]);

}catch (Exception $exc){
    echo $exc->getMessage();      //出错时显示错误信息
}

$pds=null;
$pdo=null;