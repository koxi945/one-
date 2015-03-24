<?php echo widget('Home.Common')->header(); ?>
<body class="theme-3">
    <div class="content">
        <?php echo widget('Home.Common')->top(); ?>
        <?php if( (isset($object->category) and ! empty($object->category)) or (isset($object->tag) and ! empty($object->tag))): ?>
            <div class="tag-category-title" style="color:#ccc;padding-bottom:10px;">以下为分类（标签）的筛选数据：</div>
        <?php endif; ?>
        <div class="main-content">
          <div class="row blog-post">
            <div class="col-sm-9 main-content">

                <div id="blog-posts">
                    <p class="pull-right small">
                        <a href="#"><i class="icon-comments"></i> 0 Comments</a>
                    </p>
                    <p class="text-sm p_h_info">
                        <span class="span_h_info">分类：</span><?php echo $info['classnames']; ?> &nbsp&nbsp&nbsp
                        <span class="span_h_info">标签：</span><?php echo $info['tagsnames']; ?> &nbsp&nbsp&nbsp
                        <span class="span_h_info">发布时间：</span><?php echo showWriteTime($info['write_time']); ?>
                    </p>
                    <div class="main-article-detail">
                        <?php echo $info['content']; ?>
                    </div>
                </div>

            </div>
            <?php echo widget('Home.Common')->right(); ?>
          </div>
        <?php echo widget('Home.Common')->footer(); ?>
            
        </div>
    </div>
</body></html>