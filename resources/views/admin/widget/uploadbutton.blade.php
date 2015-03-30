<?php
  $onclick = "javascript:uploaddialog('{$config['id']}_dialog', '上传','{$config['id']}',{$config['callback']},'{$config['nums']},{$config['alowexts']},1,{$config['thumbExt']},{$config['waterSetting']}','{$config['authkey']}','{$config['uploadPath']}', '{$config['uploadUrl']}')";
?>
<a class="btn btn-primary" id="swf-upload-btn" style="font-size: 12px;" onclick="<?php echo $onclick; ?>" >
  <i class="fa fa-upload"></i>
  上传
</a>