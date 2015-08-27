<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs('Content'); ?>
        <div class="main-content">
        <div id="sys-list">
          <div class="row">
              <div class="col-md-12">
                <form method="get" action="" class="form-inline">
                  <div class="form-group f-g">
                    <label for="search-keyword">关键词</label>
                    <input type="text" value="<?php if(isset($search['keyword'])) echo $search['keyword']; ?>" name="keyword" id="search-keyword" class="form-control" placeholder="请输入关键词" >
                  </div>

                  <div class="form-group f-g">
                    <label for="search-username">作者</label>
                    <select name="username" id="DropDownTimezone" class="form-control">
                      <option value="">请选择</option>
                      <?php if(isset($users) and is_array($users)): ?>
                        <?php foreach($users as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($search['username']) && $search['username'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group f-g">
                    <label for="search-classify">分类</label>
                    <select name="classify" id="DropDownTimezone" class="form-control">
                      <option value="">请选择</option>
                      <?php if(isset($classifyInfo) and is_array($classifyInfo)): ?>
                        <?php foreach($classifyInfo as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($search['classify']) && $search['classify'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group f-g">
                    <label for="search-position">推荐位</label>
                    <select name="position" id="DropDownTimezone" class="form-control">
                      <option value="">请选择</option>
                      <?php if(isset($positionInfo) and is_array($positionInfo)): ?>
                        <?php foreach($positionInfo as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($search['position']) && $search['position'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group f-g">
                    <label for="search-tag">标签</label>
                    <select name="tag" id="DropDownTimezone" class="form-control">
                      <option value="">请选择</option>
                      <?php if(isset($tagInfo) and is_array($tagInfo)): ?>
                        <?php foreach($tagInfo as $key => $value): ?>
                            <option value="<?php echo $value['id'];?>" <?php if(isset($search['tag']) && $search['tag'] == $value['id']) echo 'selected'; ?>><?php echo $value['name'];?></option>
                        <?php endforeach; ?>
                      <?php endif;?>
                    </select>
                  </div>

                  <div class="form-group f-g">
                    <label for="search-time">写作时间</label>
                    <input type="text" value="<?php if(isset($search['timeFrom'])) echo $search['timeFrom']; ?>" name="time_from" id="search-time" class="form-control">
                    到
                    <input type="text" value="<?php if(isset($search['timeTo'])) echo $search['timeTo']; ?>" name="time_to" id="search-time-to" class="form-control">
                  </div>

                  <div class="form-group f-g">
                    <input class="btn btn-primary" type="submit" value="查询">
                  </div>
                </form>
              </div>
              <div style="margin-bottom:5px; clear:both;"></div>
              <div class=" col-md-12">
                  <div class="panel panel-default">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="50%">标题</th>
                            <th>分类</th>
                            <th>作者</th>
                            <th>写作时间</th>
                            <th>状态</th>
                            <th>操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if( ! empty($list)): ?>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><a target="_blank" href="<?php echo route('home', ['class' => 'index', 'action' => 'detail', 'id' => $value['id']]); ?>"><?php echo $value['title']; ?></a></td>
                              <td><?php echo $value['classnames']; ?></td>
                              <td><?php echo $value['name']; ?></td>
                              <td><?php echo date('Y-m-d H:i', $value['write_time']); ?></td>
                              <td>
                                <?php echo $value['status'] == 1 ? '<i class="fa fa-check" style="color:green;"></i>' : '<i class="fa fa-times" style="color:red;"></i>'; ?>
                              </td>
                              <td>
                                <?php echo widget('Admin.Content')->edit($value); ?>
                                <?php echo widget('Admin.Content')->delete($value); ?>
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
          <?php echo $page; ?>
        </div>
        <?php echo widget('Admin.Common')->footer(); ?>
            
        </div>
    </div>
    <!-- js css -->
    <link rel="stylesheet" type="text/css" href="<?php echo loadStatic('/lib/datepicker/bootstrap-datetimepicker.min.css'); ?>">
    <script src="<?php echo loadStatic('/lib/datepicker/bootstrap-datetimepicker.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo loadStatic('/lib/datepicker/locales/bootstrap-datetimepicker.zh-CN.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript">
      $('#search-time').datetimepicker({
          language:  'zh-CN',
          format: "yyyy-mm-dd hh:ii:ss",
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0
      });

      $('#search-time-to').datetimepicker({
          language:  'zh-CN',
          format: "yyyy-mm-dd hh:ii:ss",
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          forceParse: 0
      });
    </script>
<?php echo widget('Admin.Common')->htmlend(); ?>