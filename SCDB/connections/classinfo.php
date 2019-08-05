<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/10/27
 * Time: 21:31
 */
include "db.php";
$rows=1;
try{
    //查询班级号
    $sql="select classNo from student where studentNo={$_SESSION['username']}";
    $pds=$pdo->query($sql);
    $row=$pds->fetch();
    //查询本班的学生信息
    $sql="select * from student where classNo={$row['classNo']}";
    $pds=$pdo->query($sql);
    $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
}catch (Exception $exc){
    echo $exc->getMessage();
}

$pds=null;
$pdo=null;
echo json_encode($rows);

