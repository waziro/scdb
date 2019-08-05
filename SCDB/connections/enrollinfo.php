<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/15
 * Time: 23:48
 */
include "db.php";
$rows=1;
//增加行数据
if($_POST['action']==="add"){
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();       //开启事务
        $arr=$_POST['arr'];
        $sql="insert into enroll values('$arr[0]','$arr[1]','$arr[2]',null,null)";      //更新选课表
        $pds=$pdo->exec($sql);
        $sql="update courseclass set enrollNumber=enrollNumber+1 where courseClassNo='$arr[2]'";   //更新开课班表
        $pds=$pdo->exec($sql);

        $pdo->commit();             //事务提交
        echo true;
    }catch(Exception $exc){
        $pdo->rollBack();           //事务回滚
        echo false;
    }
    exit;
}

//修改行数据
if($_POST['action']==="mod"){
    try{
        $arr=$_POST['arr'];
        $sql="update enroll set score='$arr[3]',recordDate='$arr[4]' where studentNo='$arr[0]' AND courseNo='$arr[1]' AND courseClassNo='$arr[2]'";
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
    }catch(Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}

//删除行数据
if($_POST['action']==="del"){
    try{
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();       //开启事务
        $arr=$_POST['arr'];
        $sql="delete from enroll where studentNo='$arr[0]' AND courseNo='$arr[1]' AND courseClassNo='$arr[2]'";
        $pds=$pdo->exec($sql);
        $sql="update courseclass set enrollNumber=enrollNumber-1 where courseClassNo='$arr[2]'";   //更新开课班表
        $pds=$pdo->exec($sql);
        echo $pds!=""?true:false;
        $pdo->commit();
    }catch (Exception $exc){
        $pdo->rollBack();
        echo $exc->getMessage();
    }
    exit;
}
//如果能够获取提交过来的班级号
if(isset($_GET['courseClassNo'])){
    //查询该开课班的学生信息
    try{
        $courseClassNo=$_GET['courseClassNo'];
        $sql="select * from enroll,student,class,institute where class.instituteNo=institute.instituteNo AND student.classNo=class.classNo AND enroll.courseClassNo='$courseClassNo' AND enroll.studentNo=student.studentNo";
        $pds=$pdo->query($sql);
        $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    }catch (Exception $exc){
        echo $exc->getMessage();
    }
    exit;
}

try{
    //查询个人选课信息及其相应课程信息
    $studentNo=$_GET['studentNo'];
    $sql="select * from enroll,course,teacher,courseclass,student where student.studentNo=enroll.studentNo AND enroll.studentNo='$studentNo' AND enroll.courseNo=course.courseNo AND teacher.teacherNo=courseclass.courseTeacherNo AND courseclass.courseClassNo=enroll.courseClassNo";
    $pds=$pdo->query($sql);
    $rows=$pds->fetchAll(PDO::FETCH_ASSOC);
}catch (Exception $exc){
    echo $exc->getMessage();
}
$pds=null;
$pdo=null;

echo json_encode($rows);