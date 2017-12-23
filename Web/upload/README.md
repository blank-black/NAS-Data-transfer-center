form.php可添加到任何位置，可实现单个文件的上传
upload_file.php为上传后的跳转界面，可实现对上传文件移动到指定位置的操作（目的地址该用户需要有755权限）


上传文件需要修改php.ini中的
file_uploads = On
upload_tmp_dir = \tmp 任意地址，但不能为空
upload_max_filesize = 20M 最大传输文件

待更新：跳转后返回，多个文件共同上传