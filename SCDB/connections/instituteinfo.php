<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/3
 * Time: 23:09
 */
include "db.php";
$rows=1;
//增加行数据
if($_POST['action']==="add"){
    try{
        $arr=$_POST['arr'];
        $sql="insert into institute values('$arr[0]','$arr[1]','$arr[2]')";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}
//删除行数据
if($_POST['action']==="del"){
    $instituteNos=$_POST['instituteNos'];
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();           //开启事务
        foreach ($instituteNos as $oldNo){
            $sql="delete from institute where instituteNo='$oldNo'";
            $pds=$pdo->exec($sql);
        }
        $pdo->commit();                    //事务提交
        echo true;
    }catch (Exception $exc){
        $pdo->rollBack();                  //事务回滚
        echo false;
    }
    exit;
}
//修改行数据
if($_POST['action']==="mod"){
    try{
        $arr=$_POST['arr'];
        $oldPk=$_POST['oldPk'];
        $sql="update institute set instituteNo='$arr[0]',instituteName='$arr[1]',deanName='$arr[2]' where instituteNo='$oldPk'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}

try{
    //查询学院信息
    $sql="select * from institute";
    $pds=$pdo->query($sql);
    $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
}catch (Exception $exc){
    echo $exc->getMessage();
}
$pds=null;
$pdo=null;
echo json_encode($rows);