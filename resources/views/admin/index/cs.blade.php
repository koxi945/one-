<?php echo widget('Admin.Common')->header(array('artdialog' => true)); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Common')->crumbs(); ?>
        <div class="main-content">
          
        <!-- 上传的示例 -->
        <?php echo widget('Admin.Upload')->setConfig(['id' => 'id', 'callback' => 'setformSubmitButton'])->uploadButton();?>

        <?php echo widget('Admin.Common')->footer(); ?>
            
        </div>
    </div>

<?php echo widget('Admin.Common')->htmlend(); ?>