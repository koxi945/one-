<?php if( ! empty($contentMenu) and is_array($contentMenu)): ?>
<div class="content-menu">
	<?php foreach($contentMenu as $key => $value): ?>
	<?php $urlParam = $value['module'] .'.'. $value['class'] .'.'. $value['action']; ?>
	<?php $arrData[] = '<a href="'.R('common', $urlParam).'" style="color:#333;">'.$value['name'].'</a>'; ?>
	<?php endforeach; ?>
	<?php if(isset($arrData) and is_array($arrData)) echo implode('&nbsp;&nbsp;|&nbsp;&nbsp;', $arrData); ?>
</div>
<?php endif; ?>