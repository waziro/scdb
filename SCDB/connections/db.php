<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/10/27
 * Time: 21:17
 * 连接SCDB数据库
 */
$dsn="mysql:host=localhost:3306;dbname=scdb";
try{
    $pdo=new PDO($dsn,'root','admin0714');  //创建PDO对象，建立服务器连接
}catch (Exception $exc){
    echo $exc->getMessage();
}

