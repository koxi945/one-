<div class="sidebar-nav">
    <ul>
        <?php $subShow = 1; ?>
        <?php foreach($menu as $key => $value): ?>
        <?php $son = App\Services\Admin\Tree::getSonKey(); ?>
            <?php if(isset($value[$son])): ?>
                <li>
                    <a id="nav-header-<?php echo $key;?>" href="javascript:;" data-target=".dashboard-menu-<?php echo $key;?>" class="nav-header collapsed" data-toggle="collapse">
                        <?php echo $value['name']; ?><i class="fa fa-collapse"></i>
                    </a>
                </li>
                <?php if(is_array($value[$son]) && !empty($value[$son])): ?>
                    <!-- sub menu -->
                    <li>
                        <ul class="dashboard-menu-<?php echo $key;?> nav nav-list collapse <?php if($subShow == 1): ?>inn<?php endif; ?>">
                            <?php foreach($value[$son] as $skey => $svalue): ?>
                                <?php $urlParam = $svalue['module'] .'.'. $svalue['class'] .'.'. $svalue['action']; ?>
                                <li id="nav-sub-<?php echo $skey;?>"><a id="nav-sub-a-<?php echo $skey;?>" data-sid="<?php echo $skey;?>" data-pid="<?php echo $key;?>" data-href="<?php echo R('common', $urlParam); ?>" href="javascript:;" class="nav-sub-menu"><span class="fa fa-caret-right"></span> <?php echo $svalue['name']; ?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <!-- end of sub menu -->
                <?php endif;?>

            <?php else: ?>
                <li>
                    <a href="help.html" class="nav-header">
                        <?php echo $value['name']; ?>
                    </a>
                </li>
            <?php endif; ?>
            
            <?php $subShow++; ?>
        <?php endforeach;?>
        
    </ul>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        //处理菜单展开问题
        var cookie_top_nav = 'nav_pid';
        var cookie_sub_nav = 'nav_sub';
        $(document).on('click', '.nav-sub-menu', function(){
            var nav_pid = $(this).attr('data-pid');
            var nav_sid = $(this).attr('data-sid');
            var nav_href = $(this).attr('data-href');
            $.cookie(cookie_top_nav, nav_pid, {path:"/"});
            $.cookie(cookie_sub_nav, nav_sid, {path:"/"});
            window.location.href = nav_href;
        });

        var nav_pid = $.cookie(cookie_top_nav);
        var nav_sid = $.cookie(cookie_sub_nav);
        $('#nav-header-'+nav_pid).trigger('click');
        $('#nav-sub-'+nav_sid).css('border-left', '4px solid #8989a6').css('overflow', 'hidden');
        $('#nav-sub-a-'+nav_sid).css('background', '#d2d2dd').css('margin-left', '-4px');
    });
</script>