<div class="navbar navbar-default" role="navigation">
<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  <a class="" href="index.html"><span class="navbar-brand">管理系统</span></a></div>

<div class="navbar-collapse collapse" style="height: 1px;">
  <ul id="main-menu" class="nav navbar-nav navbar-right">
    <li class="dropdown hidden-xs">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span> <?php echo $username; ?>
            <i class="fa fa-caret-down"></i>
        </a>

      <ul class="dropdown-menu">
        <li><a tabindex="-1" href="javascript:;" data-dialog-id="modify-password" class="modify-password">修改密码</a></li>
        <li class="divider"></li>
        <li><a tabindex="-1" href="<?php echo route('foundation.login.out'); ?>">退出</a></li>
      </ul>

    </li>
  </ul>

</div>
</div>
<div class="none modify-password-content">
  <div class="form-group">
    <label>旧密码</label>
    <input type="password" value="" name="old_password" class="form-control">
  </div>
  <div class="form-group">
    <label>新密码</label>
    <input type="password" value="" name="new_password" class="form-control">
  </div>
  <div class="form-group">
    <label>确认新密码</label>
    <input type="password" value="" name="new_password_repeat" class="form-control">
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    //修改密码
    var $modify_password = $('.modify-password');
    var $modify_password_content = $('.modify-password-content');
    $modify_password.click(function() {
      var $d = dialog({
        title: '修改密码',
        id: $modify_password.attr('data-dialog-id'),
        content: $modify_password_content.html(),
        width: '390',
        height: '300',
        okValue: '确定',
        ok: function () {
            var $this = this;
            $this.title('提交中…');
            var $old_password = $('input[name="old_password"]:visible').val();
            var $new_password = $('input[name="new_password"]:visible').val();
            var $new_password_repeat = $('input[name="new_password_repeat"]:visible').val();
            $.post('<?php echo R('common', 'foundation.user.mpassword'); ?>',
              {old_password:$old_password,new_password:$new_password,new_password_repeat:$new_password_repeat},
              function(data) {
                alert(data.message);
                $this.title('修改密码');
                if(data.result == 'success') {
                  $this.close().remove();
                  window.location.href = '/';
                }
              }
            );
            return false;
        },
        cancelValue: '取消',
        cancel: function () {
            //this.close().remove();
            //return false;
        }
      });
      $d.showModal();
    });
    
  });
</script>