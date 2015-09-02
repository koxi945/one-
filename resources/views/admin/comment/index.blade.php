<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
        <div id="sys-list">
          <div class="row">
              <div class="col-md-12">
                  <div class="panel panel-default">
                    <div class="table-responsive" id="ajax-reload">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="70">选择</th>
                            <th>评论内容</th>
                            <th width="80">所属文章</th>
                            <th width="100">评论人</th>
                            <th width="150">评论时间</th>
                            <th width="80">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><input autocomplete="off" type="checkbox" name="ids[]" class="ids" value="<?php echo $value['id']; ?>"></td>
                              <td><?php echo $value['content']; ?></td>
                              <td><a target="_blank" href="<?php echo route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['object_id']]); ?>"><?php echo '查看'; ?></a></td>
                              <td><?php echo $value['nickname']; ?></td>
                              <td>
                                <?php echo date('Y-m-d H:i', $value['time']); ?>
                              </td>
                              <td>
                                <?php echo widget('Admin.Comment')->reply($value); ?>
                                <?php echo widget('Admin.Comment')->delete($value); ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
              </div>
          </div>
          <?php echo $deleteSelectButton = widget('Admin.Comment')->deleteSelect(); ?>
          <?php echo $page; ?>
        </div>
        <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
    <script type="text/javascript">
    <?php if( ! empty($deleteSelectButton)): ?>
      $('.pl-delete').click(function() {
          var ids = plSelectValue('ids');
          if(ids.length == 0) {
              alertNotic('请先选择需要删除的评论');
              return false;
          }
          confirmNotic('确定删除吗？', function() {
            var url = '<?php echo R('common', 'blog.comment.delete'); ?>';
            var params = {id:ids};
            Atag_Ajax_Submit(url, params, 'POST', $('.pl-delete'), 'ajax-reload');
          });
      });
    <?php endif; ?>

    $('.comment-reply').click(function() {
        var _id = $(this).attr('data-id');
        var _d = dialog({
          title: '回复评论',
          id: 'comment-reply',
          fixed: true,
          width: 500,
          height: 300,
          okValue: '确定',
          ok: function() {
            
          },
          cancelValue: '取消',
          cancel: function () {}
        });
        _d.showModal();
    });
    </script>
<?php echo widget('Admin.Common')->htmlend(); ?>