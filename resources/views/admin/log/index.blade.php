<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Menu')->contentMenu(); ?>
        <?php echo widget('Admin.Common')->crumbs(); ?>

        <style type="text/css">
          #search-username {width: 100px;}
          #search-realname {width: 100px;}
        </style>

        <div class="main-content">
          <div id="sys-list">
          <div class="row">
              <div class="col-sm-6 col-md-12">
                <form method="get" action="" class="form-inline">
                  <div class="form-group">
                    <label for="search-username">用户名</label>
                    <input type="text" value="<?php if(isset($data['username'])) echo $data['username']; ?>" name="username" id="search-username" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="search-realname">真实姓名</label>
                    <input type="text" value="<?php if(isset($data['realname'])) echo $data['realname']; ?>" name="realname" id="search-realname" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="search-time">操作时间</label>
                    <input type="text" value="<?php if(isset($data['timeFrom'])) echo $data['timeFrom']; ?>" name="time_from" id="search-time" class="form-control">
                    到
                    <input type="text" value="<?php if(isset($data['timeTo'])) echo $data['timeTo']; ?>" name="time_to" id="search-time-to" class="form-control">
                  </div>

                  <div class="form-group">
                    <input class="btn btn-default" type="submit" value="查询">
                  </div>
                </form>
              </div>
              <div style="margin-bottom:20px; clear:both;"></div>
              <div class="col-sm-6 col-md-12">
                  <div class="panel panel-default">
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>真实姓名</th>
                            <th>操作详情</th>
                            <th>登录IP</th>
                            <th>操作时间</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($list as $key => $value): ?>
                            <tr>
                              <td><?php echo $value['id']; ?></td>
                              <td><?php echo $value['username']; ?></td>
                              <td><?php echo $value['realname']; ?></td>
                              <td>
                                <?php echo $value['content']; ?>
                              </td>
                              <td>
                                <?php echo $value['ip']; ?>
                              </td>
                              <td>
                                <?php echo date('Y-m-d H:i:s', $value['add_time']); ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
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