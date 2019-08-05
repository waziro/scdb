<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 11:58
 */
include "db.php";
$rows=1;
//增加行数据
if($_POST['action']==="add"){
    try{
        $arr=$_POST['arr'];
        $sql="insert into course values('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]')";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}
//删除行数据
if($_POST['action']==="del"){
    $courseNos=$_POST['courseNos'];
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();   //开启事务
        foreach ($courseNos as $oldNo){
            $sql="delete from course where courseNo='$oldNo'";
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
        $sql="update course set courseNo='$arr[0]',courseName='$arr[1]',creditHour='$arr[2]',courseHour='$arr[3]',instituteNo='$arr[4]' where courseNo='{$_POST['oldPk']}'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}

try{
    //查询课程信息
    $sql="select * from course";
    $pds=$pdo->query($sql);
    $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
}catch (Exception $exc){
    echo $exc->getMessage();
}
$pds=null;
$pdo=null;
echo json_encode($rows);