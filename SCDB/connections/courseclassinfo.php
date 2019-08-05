<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/4
 * Time: 22:07
 */
include "db.php";
$rows=1;

//学生选课相关操作
if($_POST['action']==="select"){
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();       //开启事务
        $arr=$_POST['arr'];
        //查询开课班信息和对应课程信息
        $sql="select * from courseclass WHERE courseClassNo='$arr[0]'";
        $pds=$pdo->query($sql);
        $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            if($row[enrollNumber]<$row[capacity]){  //已选人数<限选人数
                $sql="update courseclass set enrollNumber=enrollNumber+1 where courseClassNo='$arr[0]'";   //更新开课班表
                $pds=$pdo->exec($sql);
                $sql="insert into enroll values('$arr[2]','$arr[1]','$arr[0]',null,null)";     //更新选课表
                $pds=$pdo->exec($sql);
            }
        }
        $pdo->commit();             //事务提交
        echo true;
    }catch (Exception $exc){
        $pdo->rollBack();           //事务回滚
        echo false;
    }
    exit;
}

//增加行数据
if($_POST['action']==="add"){
    try{
        $arr=$_POST['arr'];
        $sql="insert into courseclass values('$arr[0]','$arr[1]','$arr[2]','$arr[3]','$arr[4]','$arr[5]','$arr[6]')";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}
//删除行数据
if($_POST['action']==="del"){
    $courseClassNos=$_POST['courseClassNos'];
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();   //开启事务
        foreach ($courseClassNos as $oldNo){
            $sql="delete from courseclass where courseClassNo='$oldNo'";
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
        $sql="update courseclass set courseClassNo='$arr[0]',courseNo='$arr[1]',courseTeacherNo='$arr[2]',year='$arr[3]',semester='$arr[4]',capacity='$arr[5]',enrollNumber='$arr[6]' where courseClassNo='$oldPk'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}


try{
    //查询开课班信息和对应课程信息以及任课教师信息
    $teacherNo=$_GET['teacherNo'];
    if($teacherNo!=""){
        $sql="select * from courseclass,teacher,course WHERE course.courseNo=courseclass.courseNo AND courseclass.courseTeacherNo='$teacherNo' AND teacher.teacherNo='$teacherNo'";
        $pds=$pdo->query($sql);
        $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
    }else{
        $sql="select * from courseclass,course,teacher WHERE courseclass.courseNo=course.courseNo AND courseclass.courseTeacherNo=teacher.teacherNo";
        $pds=$pdo->query($sql);
        $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
    }
}catch (Exception $exc){
    echo $exc->getMessage();
}


$pds=null;
$pdo=null;
echo json_encode($rows);