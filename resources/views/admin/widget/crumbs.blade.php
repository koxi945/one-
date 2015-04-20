<div class="header">
    <?php if($btnGroup !== false): ?>
        <?php echo widget('Admin.'.$btnGroup)->navBtn(); ?>
    <?php endif;?>
    <ul class="breadcrumb">
        <li><a href="<?php echo R('common', 'foundation.index.index'); ?>">后台首页</a> </li>
    </ul>
</div>