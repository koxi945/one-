<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Common')->crumbs('Acl'); ?>
        <div class="main-content">
          <div id="sys-list">
          <form id="aclListForm" target="hiddenwin" method="post" action="<?php echo R('common', 'foundation.acl.sort');?>">
          <div class="row">
              <div class="col-sm-6 col-md-12">
                  <div class="panel panel-default">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>排序</th>
                            <th>功能名字</th>
                            <th>功能代码（-为分隔线）</th>
                            <th>显示为菜单?</th>
                            <th>备注</th>
                            <th>操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><input type="text" name="sort[<?php echo $value['id']; ?>]" value="<?php echo $value['sort']; ?>" style="width:50px;text-align:center;"></td>
                              <td><?php echo $value['name']; ?></td>
                              <td><?php echo $value['class'].'-'.$value['action']; ?></td>
                              <td><?php echo $value['display'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?></td>
                              <td><?php echo $value['mark']; ?></td>
                              <td>
                                <?php echo widget('Admin.Acl')->edit($value); ?>
                                <?php echo widget('Admin.Acl')->delete($value); ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <?php echo widget('Admin.Acl')->sort(); ?>
          </form>
          <?php echo $page; ?>
          </div>
          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>