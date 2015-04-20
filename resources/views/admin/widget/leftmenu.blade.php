<div class="sidebar-nav">
    <ul>
        <?php
            $mcaName = \App\Services\Admin\MCAManager::MAC_BIND_NAME;
            $MCA = app()->make($mcaName);
        ?>
        <?php foreach($menu as $key => $value): ?>
        <?php $son = App\Services\Admin\Tree::getSonKey(); ?>
            <?php if(isset($value[$son])): ?>
                <?php $checkFirst = $MCA->matchFirstMenu($value['module'], $value['class'], $value['action']); ?>
                <li>
                    <a href="javascript:;" data-target=".dashboard-menu-<?php echo $key;?>" class="nav-header <?php if( ! $checkFirst) echo 'collapsed'; ?>" data-toggle="collapse">
                        <?php echo $value['name']; ?><i class="fa fa-collapse"></i>
                    </a>
                </li>
                <?php if(is_array($value[$son]) && !empty($value[$son])): ?>
                    <!-- sub menu -->
                    <li>
                        <ul class="dashboard-menu-<?php echo $key;?> nav nav-list collapse <?php if($checkFirst) echo 'in'; ?>">
                            <?php foreach($value[$son] as $skey => $svalue): ?>
                                <?php $checkSecond = $MCA->matchSecondMenu($svalue['module'], $svalue['class'], $svalue['action']); ?>
                                <?php $urlParam = $svalue['module'] .'.'. $svalue['class'] .'.'. $svalue['action']; ?>
                                <li <?php if($checkSecond): ?>style="border-left:4px solid #8989a6;overflow:hidden;"<?php endif; ?>>
                                    <a data-sid="<?php echo $skey;?>" data-pid="<?php echo $key;?>" data-href="<?php echo R('common', $urlParam); ?>" href="javascript:;" class="nav-sub-menu" <?php if($checkSecond): ?>style="background:#d2d2dd;margin-left:-4px"<?php endif; ?>>
                                        <span class="fa fa-caret-right"></span> <?php echo $svalue['name']; ?>
                                    </a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <!-- end of sub menu -->
                <?php endif;?>

            <?php else: ?>
                <li>
                    <a href="#" class="nav-header">
                        <?php echo $value['name']; ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach;?>
    </ul>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.nav-sub-menu', function(){
            var nav_pid = $(this).attr('data-pid');
            var nav_sid = $(this).attr('data-sid');
            var nav_href = $(this).attr('data-href');
            window.location.href = nav_href;
        });
    });
</script>