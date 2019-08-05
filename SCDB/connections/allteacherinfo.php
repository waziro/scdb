<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 11:54
 */
include "db.php";
$rows=1;
//增加行数据
if($_POST['action']==="add"){
    try{
        $arr=$_POST['arr'];
        $sql="insert into teacher values('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','',null,null,null)";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}
//删除行数据
if($_POST['action']==="del"){
    $teacherNos=$_POST['teacherNos'];
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();   //开启事务
        foreach ($teacherNos as $oldNo){
            $sql="delete from teacher where teacherNo='$oldNo'";
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
        $sql="update teacher set teacherNo='$arr[0]',teacherName='$arr[1]',title='$arr[2]',degree='$arr[3]',hireDate='$arr[4]',instituteNo='$arr[5]' where teacherNo='{$_POST['oldPk']}'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}

try{
    //查询教师信息
    $sql="select * from teacher";
    $pds=$pdo->query($sql);
    $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
}catch (Exception $exc){
    echo $exc->getMessage();
}
$pds=null;
$pdo=null;
echo json_encode($rows);