# laravel5 后台基础系统

这是一个基于laravel 5.1框架的后台基础系统

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

6、自行安装与配置sphinx（如果你使用blog的搜索功能的话），下面是建议的配置

    doc/sphinx.conf

二、需要的一些扩展（如果你使用blog的搜索功能的话）
--------------------------------
* sphinx 主要用于博客的搜索

三、需要的环境要求
---------------------------------
至少满足laravel 5.1框架的要求。

四、一点预览
------------------------------------

![enter image description here](http://static.oschina.net/uploads/space/2015/0707/125515_Kdi6_1777357.png)

![enter image description here](http://static.oschina.net/uploads/space/2015/0707/125516_rtVg_1777357.png)

![enter image description here](http://static.oschina.net/uploads/space/2015/0707/125516_7Kqi_1777357.png)

![enter image description here](http://static.oschina.net/uploads/space/2015/0707/125516_Eboi_1777357.png)

![enter image description here](http://static.oschina.net/uploads/space/2015/0707/125516_HeWC_1777357.png)

![enter image description here](http://static.oschina.net/uploads/space/2015/0707/125517_c5sd_1777357.png)

![enter image description here](http://static.oschina.net/uploads/space/2015/0707/125517_D1Ra_1777357.png)

五、说明
------------------------------------
其实本来是想做一个自己用的blog的，但是时间有限，做得更多的是系统的一些基本的东西。所以就是这样咯。

基于laravel 5 框架的后台基础系统。包括登录验证、用户管理，修改密码，用户权限，用户组权限，功能管理，系统日志，文件上传、工作流。目前还附加了简单的blog功能。可以快速基于此系统进行laravel5的快速开发，免去每次都写一次后台基础的痛苦。

关于用户组权限这一块，其实是有层级关系的，也就是建立用户组的时候的“用户组等级”，这样用户组等级低的用户是不能修改等级高的用户组信息或用户信息的。

关于给用户或用户组权限的时候，有一点要注意的是，只能给自己所拥有的权限。

关于工作流的应用，可以在app/http/admin/foundation/indexController.php中可以看到。

关于系统日志，其实只需要在业务逻辑里手动开启，实现是在另外的地方实现的，当前这个实现需要你自己来写（其实改变的只是所要记录的字符串而已）。

至于博客的功能，目前还是比较简单的，只是发表和展示以及评论的功能。当然你需要的话可以基于此进行扩展。

