# phpblog轻博客

这是一个基于laravel 5.0框架的轻博客系统

一、如何安装
--------------------------
1、建立数据库名为：mrblog
2、把包目录下的mrblog.sql导到库mrblog中。
3、修改包目录下的.env文件，修改数据库连接为你的信息。
4、默认使用的域名为admin.opcache.net和www.opcache.net，如果你需要修改，那么修改文件

        app/Http/routes.php

更改

        Route::group(['domain' => 'admin.opcache.net'], function() {
        //还有
        $homeDoaminArray = ['home_empty_prefix' => 'opcache.net', 'home' => 'www.opcache.net', 'test' => 'test.opcache.net'];

为你需要的域名，如：

        Route::group(['domain' => 'admin.xx.net'], function() {
        //还有
        $homeDoaminArray = ['home_empty_prefix' => 'xx.net', 'home' => 'www.xx.net', 'test' => 'test.xx.net'];

5、配置你的域名并指向目录public
6、自行安装与配置sphinx，下面是建议的配置

        #源
        source mrblog_article
        {
        type                    = mysql
        sql_host                = localhost
        sql_user                = root
        sql_pass                = qqq111!!!
        sql_db                  = mrblog
        sql_port                = 3306
        sql_query_pre   = SET NAMES utf8
        sql_sock                = /tmp/mysql.sock

        sql_query               = \
                SELECT id, article_id, title, summary, content, added_date \
                FROM bk_search_index
        ##WARNING: attribute 'id' not found - IGNORING
        #出现这个的原因是因为不能使用主键,且上面的查询语句默认且必需第一个字段是id
        sql_attr_uint           = article_id 
        sql_attr_timestamp      = added_date
        sql_ranged_throttle     = 100
        }
        #索引
        index mrblog_article_1
        {
        source                  = mrblog_article
        path                    = /alidata/sphinx/data/mrblog_article_1
        docinfo                 = extern
        dict                    = keywords
        mlock                   = 0
        morphology              = none
        min_word_len            = 1
        ngram_len               = 1
        ngram_chars             = U+3000..U+2FA1F
        html_strip              = 100
        }


        source mrblog_articlethrottled : mrblog_article
        {
        sql_ranged_throttle     = 100
        }

        index rt
        {
        type                    = rt
        path                    = /alidata/sphinx/data/rt
        rt_field                = title
        rt_field                = content
        rt_attr_uint            = gid
        }

        indexer
        {
        mem_limit               = 128M
        }

        searchd
        {
        listen                  = 9312
        log                     = /alidata/sphinx/log/searchd.log
        query_log               = /alidata/sphinx/log/query.log
        read_timeout            = 5
        client_timeout          = 300
        max_children            = 30
        persistent_connections_limit    = 30
        pid_file                = /alidata/sphinx/data/searchd.pid
        preopen_indexes         = 1
        unlink_old              = 1
        mva_updates_pool        = 1M
        max_packet_size         = 8M
        max_filters             = 256
        max_filter_values       = 4096
        max_batch_queries       = 32
        workers                 = threads # for RT to work
        }

        common
        {

        }

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