<div class="header">
    <?php if($btnGroup !== false): ?>
        <?php echo widget('Admin.'.$btnGroup)->navBtn(); ?>
    <?php endif;?>
    <ul class="breadcrumb">
        <li><a href="<?php echo route('common', ['class' => 'index', 'action' => 'index']); ?>">后台首页</a> </li>
        <?php if(isset($navParentName['name'])): ?>
        <li class="active"><?php echo $navParentName['name']; ?> </li>
        <?php endif; ?>

        <?php if(isset($navSonName['name'])): ?>
        <li class="active"><?php echo $navSonName['name']; ?></li>
        <?php endif; ?>
    </ul>
</div>