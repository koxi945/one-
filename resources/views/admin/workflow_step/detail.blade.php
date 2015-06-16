<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('WorkflowStep'); ?>
        <div class="main-content">
          <div class="function-bar-text"><h5>工作流：<span style="color:#999;"><?php if(isset($workflowInfo['name'])) echo $workflowInfo['name']; ?></span></h5></div>
          <div id="sys-list">
          <div class="row">
              <div class=" col-md-12">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>工作流步骤名字</th>
                            <th>审核步骤</th>
                            <th>关联人员</th>
                            <th>备注</th>
                            <th>增加的时间</th>
                            <th>设置关联人员</th>
                            <th>操作</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($list)): ?>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><?php echo $value['name']; ?></td>
                              <td>第<?php echo $value['step_level']; ?>步</td>
                              <td></td>
                              <td><?php echo $value['description']; ?></td>
                              <td><?php echo date('Y-m-d', $value['addtime']); ?></td>
                              <td>
                                <?php echo widget('Admin.WorkflowStep')->relation($value); ?>
                              </td>
                              <td>
                                <?php echo widget('Admin.WorkflowStep')->edit($value); ?>
                                <?php echo widget('Admin.WorkflowStep')->delete($value); ?>
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