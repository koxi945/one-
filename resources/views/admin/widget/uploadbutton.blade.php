<?php
	$paramString = base64url_encode(implode(',', $config));
	$onclick = "javascript:uploaddialog('{$config['id']}_dialog', '上传文件','{$config['id']}',{$config['callback']},'{$paramString}','{$authkey}','{$config['uploadPath']}', '{$config['uploadUrl']}')";
?>
<a class="btn btn-primary" id="swf-upload-btn" style="font-size: 12px;" onclick="<?php echo $onclick; ?>" >
  <i class="fa fa-upload"></i>
  上传
</a>