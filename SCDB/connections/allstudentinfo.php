<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 12:19
 */
session_start();
include "db.php";
$rows=1;
//增加行数据
if($_POST['action']==="add"){
    try{
        $arr=$_POST['arr'];
        $sql="insert into student values('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]','$arr[7]',null,'123456',null)";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}
//删除行数据
if($_POST['action']==="del"){
    $studentNos=$_POST['studentNos'];
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();   //开启事务
        foreach ($studentNos as $oldNo){
            $sql="delete from student where studentNo='$oldNo'";
            $pds=$pdo->exec($sql);
        }
        $pdo->commit();             //事务提交
        echo true;
    }catch (Exception $exc){
        $pdo->rollBack();           //事务回滚
        echo false;
    }
    exit;
}
//修改行数据
if($_POST['action']==="mod"){
    try{
        $arr=$_POST['arr'];
        $oldPk=$_POST['oldPk'];
        $sql="update student set studentNo='$arr[0]',studentName='$arr[1]',sex='$arr[2]',birthday='$arr[3]',phoneNumber='$arr[4]',province='$arr[5]',city='$arr[6]',street='$arr[7]' where studentNo='$oldPk'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}

$studentNo=$_GET['studentNo'];
if($studentNo!=""){
    try{
        $classNo=substr($studentNo,0,8);
        //若能获取个人学号，则查询本班学生信息
        $sql="select * from student where student.classNo='$classNo'";
        $pds=$pdo->query($sql);
        $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
}else{
    try{
        //查询全校学生信息
        $sql="select * from student";
        $pds=$pdo->query($sql);
        $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
}

$pds=null;
$pdo=null;
echo json_encode($rows);