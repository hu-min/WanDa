<?php
print_r ( $_FILES ['upload'] );
print '<pre>';
$store_dir = 'd:\\'; // 文件上传后存储在服务器的路径
$uploadfile = "$store_dir" . basename ( $_FILES ['sendfile'] ['name'] ); // 上传文件的原始名字
$uploadfile_tmp = $_FILES ['sendfile'] ['tmp_name']; // 上传文件的临时名字
$err_msg = $_FILES ['sendfile'] ['error']; // 上传文件时产生的错误信息
if ($err_msg) // 如果存在错误代码则打印出来
{
	print "错误代码：$err_msg<br/>";
}


if (! is_writeable ( $store_dir )) // 检查上传文件夹是否可写
{
	print "$store_dir 目录不可写\n";
	exit ();
} else {
	print "$store_dir 目录可写\n";
}



if (isset ( $_FILES ['sendfile'] )) {
	if (is_uploaded_file ( $uploadfile_tmp )) // 检查上传的文件是否存在
{
		print "文件检验成功\n";
	} else {
		print "文件检验失败，可能遭受文件上传攻击！\n";
		exit ();
	}
	if (move_uploaded_file ( $uploadfile_tmp, $uploadfile )) // 对上传的合法文件，将其重命名并移动到服务器的上传文件夹中
{
		print "文件移动成功\n";
	} else {
		print "文件移动失败，可能遭受文件上传攻击！\n";
		exit ();
	}
	print "文件上传成功！<br/>";
} else {
	print "文件上传失败！<br/>";
}




print '$_FILES=';
print_r ( $_FILES );
print '</pre>';
?>