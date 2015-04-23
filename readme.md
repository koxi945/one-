# phpblog轻博客

这是一个基于laravel 5.0框架的轻博客系统

一、如何安装
--------------------------

1、建立数据库名为：mrblog

2、把包目录下的mrblog.sql导到库mrblog中。

3、修改包目录下的.env文件，修改数据库连接为你的信息。

4、默认使用的域名为admin.opcache.net和www.opcache.net，如果你需要修改，那么修改文件

    config/sys.php

中的值

    sys_images_domain
    sys_admin_domain
    sys_blog_domain
    sys_blog_nopre_domain


5、配置你的域名并指向目录public

6、自行安装与配置sphinx，下面是建议的配置

    doc/sphinx.conf

二、需要的一些扩展
--------------------------------
* sphinx 主要用于博客的搜索

三、需要的环境要求
---------------------------------
至少满足laravel 5框架的要求。

四、一点预览
------------------------------------

![enter image description here](http://static.oschina.net/uploads/space/2015/0422/154701_YMQm_1777357.png)

![enter image description here](http://static.oschina.net/uploads/space/2015/0422/154701_svr4_1777357.png)

![enter image description here](http://static.oschina.net/uploads/space/2015/0422/154701_tTmd_1777357.png)

五、说明
------------------------------------
如果有问题，请联系我mylampblog@163.com 我会完善此文档。