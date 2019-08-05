<?php
/**
 * Created by PhpStorm.
 * User: Badboy
 * Date: 2017/11/26
 * Time: 19:54
 */
/*图形验证码生成包含几个关键步骤：
 * （1）在php.ini中启用GD2函数库；
 * （2）随机选择字符构成验证码字符串，验证码字符串存入Session以便验证调用；
 * （3）调用GD2函数imagecreate()创建图像；
 * （4）第一次调用GD2函数imagecolorallocate()函数设置图像背景色；
 * （5）再次调用imagecolorallocate()函数设置绘图颜色；
 * （6）调用GD2函数imagestring()将验证码字符串输出到图像；
 * （7）调用PHP的header()函数设置正确的HTML文件头；
 * （8）调用匹配的GD2函数imagejpeg()或imagepng()将图像输出到浏览器。
 * （9）调用GD2函数imagedestroy()销毁图像，释放图形资源。
 */
$chars='23456789abcdefghjklmnopqrstABCDEFGHIJKLMNOPQRST';//设置候选字符，排除易混淆字符
$n=strlen($chars);//获得候选字符串长度
//随机选择4个字符作为验证码
$str=$chars[rand(0,$n-1)].$chars[rand(0,$n-1)].$chars[rand(0,$n-1)].$chars[rand(0,$n-1)];
$_SESSION['checkcode']=strtolower($str);//将验证码存入Session，以便验证
$im = imagecreate(100,28);               //创建一个宽为60像素，高为20像素的图像
imagecolorallocate($im,240,245,220);    //设置图像背景色
$color=imagecolorallocate($im,0, 0, 0);  //生成绘图颜色
//将验证码用imagestring()函数输出到图像
imagestring($im,5,16,5, $str[0]." ".$str[1]." ".$str[2]." ".$str[3],$color);
//图形验证码为图片格式，因此正确HTML文件头才能保存客户端正确接收到图片
header("Content-Type:image/jpeg");
imagejpeg($im);     //将图像以jpg格式输出到浏览器
imagedestroy($im);  //释放图像资源
