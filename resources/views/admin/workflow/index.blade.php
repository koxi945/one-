<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('Workflow'); ?>
        <div class="main-content">
          <div id="sys-list">
          <div class="row">
              <div class=" col-md-12">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>调用代码</th>
                            <th>工作流名字</th>
                            <th>备注</th>
                            <th>增加的时间</th>
                            <th>详情</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($list)): ?>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><?php echo $value['code']; ?></td>
                              <td><?php echo $value['name']; ?></td>
                              <td><?php echo $value['description']; ?></td>
                              <td><?php echo date('Y-m-d', $value['addtime']); ?></td>
                              <td>
                                <?php echo widget('Admin.Workflow')->edit($value); ?>
                                <?php echo widget('Admin.Workflow')->detail($value); ?>
                                <?php echo widget('Admin.Workflow')->delete($value); ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                      </table>
                      </div>
                  </div>
              </div>
          </div>
          <?php echo isset($page) ? $page : ''; ?>
          </div>
          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>