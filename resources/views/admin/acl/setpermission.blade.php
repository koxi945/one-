<?php echo widget('Admin.Common')->header(); ?>
    <?php echo widget('Admin.Common')->top(); ?>
    <?php echo widget('Admin.Menu')->leftMenu(); ?>
    <div class="content">
        <?php echo widget('Admin.Common')->crumbs('Acl'); ?>
        <div class="main-content">
          <div id="sys-list">
          <form id="aclListForm" target="hiddenwin" method="post" action="<?php echo R('common', 'foundation.acl.'.$router); ?>">
          <div class="row">
            <div class="col-sm-6 col-md-12">
              <div id="featurebar">
                <div class="heading"><?php echo isset($info['name']) ? $info['name'] : ''; ?><?php echo isset($info['group_name']) ? $info['group_name'] : ''; ?> : </div>
                <ul class="nav">
                  <li class="active">
                    <a href="<?php echo R('common', 'foundation.acl.'.$router, ['id' => $id]); ?>">所有权限</a>
                  </li>
                  <?php
                      $son = App\Services\Admin\Tree::getSonKey();
                      $all = array();
                      foreach($tree as $key => $value):
                        if( ! isset($value[$son])) continue;
                                  
                  ?>
                  <li class="active">
                    <a href="<?php echo R('common', 'foundation.acl.'.$router, ['id' => $id, 'pid' => $value['id'] ]); ?>"><?php echo $value['name']; ?></a>
                  </li>
                  <?php
                      endforeach;
                  ?>
                </ul>
              </div>
                <table class="table table-striped table-bordered table-form "> 
                  <thead>
                    <tr>
                      <th colspan="2" class="bg-w">选项</th>
                      <th class="bg-w" width="70%">配置</th>
                    </tr>
                  </thead>
                  <tbody>
                  
                  <!-- begin -->
                  <?php
                      $all = array();
                      foreach($tree as $key => $value):
                          if( ! isset($value[$son]) or ($pid && $value['id'] != $pid)) continue;
                              $all[] = $value['id'];
                              $count = count($value[$son]);
                              $mark = 0;
                              foreach($value[$son] as $key2 => $value2):
                                $all[] = $value2['id'];
                                  
                  ?>
                  <tr class="even" id="m<?php echo $value['id']; ?>">
                      <?php if($mark == 0): ?>
                      <th class="text-right w-100px bg-w" rowspan="<?php echo $count;?>">
                          <!-- b -->
                          <a onclick="$('#h_<?php echo $value['id']; ?>').click();" class="acl-set-all" href="javascript:;" title="点击我全选"><?php echo $value['name']; ?></a>
                          <input id="h_<?php echo $value['id']; ?>" type="checkbox" onclick="selectAllPermission(this, 'm<?php echo $value['id']; ?>', 'checkbox')" style="display:none;" />
                          <!-- e -->
                          
                          <input type="checkbox" <?php if(in_array($value['id'], $hasPermissions)) echo 'checked'; ?>  value="<?php echo $value['id']; ?>" name="permission[]">
                      </th>
                      <?php endif; ?>
                      <td class="pv-10px w-130px bg-w" style="padding-left:10px;line-height: 30px;">
                          <!-- b -->
                          <a onclick="$('#h_<?php echo $value2['id']; ?>').click();" class="acl-set-all" href="javascript:;" title="点击我全选"><?php echo $value2['name']; ?></a>
                          <input type="checkbox" <?php if(in_array($value2['id'], $hasPermissions)) echo 'checked'; ?>  value="<?php echo $value2['id']; ?>" name="permission[]" style="float:right;">
                          <!-- e -->
                          
                          <input id="h_<?php echo $value2['id']; ?>" type="checkbox" onclick="selectAllPermission(this, 'm<?php echo $value2['id']; ?>', 'checkbox')" style="display:none;">
                      </td>
                      <td class="pv-10px" id="m<?php echo $value2['id']; ?>">
                          <?php
                              if(isset($value2[$son])):
                                  foreach($value2[$son] as $key3 => $value3):
                                    $all[] = $value3['id'];
                          ?>
                          <div class="group-item">
                              <input type="checkbox" <?php if(in_array($value3['id'], $hasPermissions)) echo 'checked'; ?> value="<?php echo $value3['id']; ?>" name="permission[]">
                              <span id="index-index" class="priv"><?php echo $value3['name']; ?></span>
                          </div>
                          <?php
                                  endforeach;
                              endif;
                          ?>
                      </td>
                  </tr>
                  
                  <?php
                              $mark++;
                          endforeach;
                      endforeach;
                  ?>
                  <!-- end --> 
                  
                  <tr>
                    <th class="text-right bg-w" colspan="2">全选
                    <input type="checkbox" onclick="selectAllPermission(this, '', 'checkbox')" >
                    </th>
                    <td>
                      <a class="btn btn-primary sys-btn-submit" data-loading="保存中..." ><i class="fa fa-save"></i> <span class="sys-btn-submit-str">保存</span></a>
                      <button class="btn btn-default" onclick="javascript:history.go(-1);" type="button">返回</button>
                      <input type="hidden" name="id" value="<?php echo $id;?>" />
                      <input type="hidden" name="all" value="<?php echo implode(',', $all); ?>" />
                    </td>
                  </tr>
                              
                </tbody>
              </table>
            </div>
          </div>
          </form>
          </div>
          <?php echo widget('Admin.Common')->footer(); ?>
        </div>
    </div>
<?php echo widget('Admin.Common')->htmlend(); ?>