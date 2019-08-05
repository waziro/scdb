<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/26
 * Time: 23:53
 */
if(!isset($_POST['email'])){
    //若请求中无email参数，返回忘记密码页面，要求用户输入电子邮件地址
    echo '<script>window.location ="index.php";</script>';
}
$email=$_POST['email'];     //获得用户输入的电子邮件地址
if(trim($email)==''){       //电子邮件地址不允许为空白字符串
    echo '输入的电子邮件地址格式不正确！<a href="../index.php">返回登录界面</a>';
    exit;
}

include "../connections/db.php";
try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //创建查询字符串，从数据库中查找匹配用户输入的电子邮件地址的记录
    $sql="select studentNo,email from student where email='$email'";
    $pds=$pdo->query($sql);             //执行查询
    $row=$pds->fetch(PDO::FETCH_ASSOC);   //将查询结果集中的记录读入数组对象
    if($row==false){
        //说明电子邮件地址未注册，显示错误提示信息。
        echo '你输入的Email地址未注册，<a href="../index.php">返回登录界面</a>';
    }else{
        //电子邮件地址已注册，准备发送电子邮件
        //获取数据库中电子邮件地址记录的用户名,作为密码重置链接的URL参数。
        $no=$row['studentNo'];              //用户额
        require 'PHPMailerAutoload.php';    //加载电子邮件发送类
        $mail = new PHPMailer;              //创建用于发送电子邮件的PHPMailer对象
        $mail->isSMTP();                    //指定使用SMTP协议发送电子邮件
        $mail->Host = 'smtp.qq.com';        //指定使用QQ邮箱的SMTP服务器用于发送电子邮件
        $mail->SMTPAuth = true;             //启用SMTP授权
        $mail->Username = '736685835@qq.com';       //指定登录SMTP服务器的用户名，实现时***替换为qq号
        $mail->Password = 'ribmbkygouqzbfdf';       //指定登录SMTP服务器的密码，实现时***替换为密码
        $mail->SMTPSecure = 'ssl';          // 启用ssl
        $mail->Port =465;                   //设置SMTP端口号
        $mail->From = $mail->Username;      //指定发件人Email地址,与用户名一致
        $mail->FromName = '系统管理员';       //指定发件人名称
        $mail->addAddress($email, '重置密码');        //指定收件人地址和邮件标题
        $mail->isHTML(true);                        // 设置邮件内容为HTML格式
        //定义密码重置链接URL，其中的用户名用MD5()函数加密，避免泄露
        $url= 'http://localhost:8080/SCDB/phpmailer/resetpassword.php?key='.md5($no);
        $mail->Subject = '密码重置';    //设置邮件主题
        $mail->Body    = '这是一封密码重置邮件，如果你没有进行申请密码重置操作，请直接忽略该邮件！<br>'
                        .'如果你申请了密码重置，请单击下面的链接，跳转到指定界面进行相关操作。<br>'
                        .'<a href="'.$url.'">密码重置</a>';
        $mail->AltBody = '这是一封密码重置邮件，如果你未申请密码重置，请忽略该邮件！<br>'
                        .'如果你申请了密码重置，请URL复制到浏览器地址栏进行密码重置\n'.$url;
        if(!$mail->send()) {
            echo '邮件发送错误，请检查你输入的Email地址是否正确,<a href="index.php">返回</a>';
            echo '<br>出错了：'.$mail->ErrorInfo;
        } else {
            echo '密码重置邮件已发送到你的邮箱，请及时查收！';
        }
    }
    $pds=null;
    $pdo=null;
} catch (Exception $exc) {
    echo '<p>出错啦：因为某种原因暂时无法从后台获取个人数据！</p>';
}