<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 12:03
 */
include "db.php";
$rows=1;
//增加行数据
if($_POST['action']==="add"){
    try{
        $arr=$_POST['arr'];
        $sql="insert into class values('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]')";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}
//删除行数据
if($_POST['action']==="del"){
    $classNos=$_POST['classNos'];
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();       //开启事务
        foreach ($classNos as $oldNo){
            $sql="delete from class where classNo='$oldNo'";
            $pds=$pdo->exec($sql);
        }
        $pdo->commit();                 //事务提交
        echo true;
    }catch (Exception $exc){
        $pdo->rollBack();               //事务回滚
        echo false;
    }
    exit;
}
//修改行数据
if($_POST['action']==="mod"){
    try{
        $arr=$_POST['arr'];
        $oldPK=$_POST['oldPk'];
        $sql="update class set classNo='$arr[0]',className='$arr[1]',grade='$arr[2]',classNumber='$arr[3]',instituteNo='$arr[4]' where classNo='$oldPK'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}
try{
    //查询班级信息
    $sql="select * from class";
    $pds=$pdo->query($sql);
    $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
}catch (Exception $exc){
    echo $exc->getMessage();
}
$pds=null;
$pdo=null;
echo json_encode($rows);