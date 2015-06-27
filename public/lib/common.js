//处理表单提单按钮，显示loading，禁用，启用。
function setformSubmitButton() {
    //模拟submit
    $(document).on('click', '.sys-btn-submit', function () {
        var isClick = false;
        var sysBtnSubmitObject = $(this);
        var has_Object_Form_Init = sysBtnSubmitObject.data('form-init') || false;
        var has_Object_Body_Init = sysBtnSubmitObject.data('body-init') || false;
        
        var oldText = sysBtnSubmitObject.find('.sys-btn-submit-str').html();

        //处理表单提交
        if( ! has_Object_Form_Init) {
            sysBtnSubmitObject.closest('form').submit(function(){
                var loading = sysBtnSubmitObject.attr('data-loading') || 'loading...';
                sysBtnSubmitObject.find('.sys-btn-submit-str').html(loading);
                sysBtnSubmitObject.attr('disabled', 'disabled');
                isClick = true;
            });
            sysBtnSubmitObject.data('form-init', true);
        }

        //取消按钮锁定
        if( ! has_Object_Body_Init) {
            $("body").on('click', function(){
                if(isClick){
                    sysBtnSubmitObject.removeAttr('disabled');
                    sysBtnSubmitObject.find('.sys-btn-submit-str').html(oldText);
                }
                isClick = false;
            });
           sysBtnSubmitObject.data('body-init', true);
        }

        sysBtnSubmitObject.closest('form').submit();

        return false;
    });
    
}

//confirm
function confirmNotic(content, callback) {
    var d = dialog({
        title: '提示',
        content: content,
        okValue: '确定',
        ok: function () {
            if(typeof callback === 'function') {
                this.title('提交中…');
                callback();
            }
        },
        cancelValue: '取消',
        cancel: function () {}
    });
    d.showModal();
}

//异步删除
function ajaxDelete(url, replaceID, notice) {
    confirmNotic(notice, function() {
        $.ajax({
            type:     'GET', 
            url:      url,
            dataType: 'json', 
            success:  function(data) {
                if(data.result == 'success') {
                    $('#' + replaceID).wrap("<div id='tmpDiv'></div>");
                    $('#tmpDiv').load(document.location.href + ' #' + replaceID, function(){
                        $('#tmpDiv').replaceWith($('#tmpDiv').html());
                    });
                } else {
                    alert(data.message);
                }
            },
            beforeSend: function() {
                loading();
            },
            complete: function() {
                unloading();
            }
        });
    });
}

//显示loading
function loading() {
    var loading_image = '<img src="'+SYS_DOMAIN+'/images/loading-icons/loading9.gif">';
    $.blockUI({
        message: loading_image,
        css: {
            border: 'none', 
            padding: '0px', 
            backgroundColor: 'none'
        }
    }); 
}

//关闭显示loading
function unloading() {
    $.unblockUI();
}

//权限给预选择
function selectAllPermission(checker, scope, type) { 
    if(scope) {
        if(type == 'button') {
            $('#' + scope + ' input').each(function() {
                $(this).prop("checked", true)
            });
        }
        else if(type == 'checkbox') {
            $('#' + scope + ' input').each(function() {
                $(this).prop("checked", checker.checked)
            });
         }
    } else {
        if(type == 'button') {
            $('input:checkbox').each(function() {
                $(this).prop("checked", true)
            });
        } else if(type == 'checkbox') { 
            $('input:checkbox').each(function() {
                $(this).prop("checked", checker.checked)
            });
        }
    }
}

//上传弹出窗口
function uploaddialog(uploadid, title, itemId, funcName, args, authkey, upload_url) {
    var args = args ? '&args=' + args : '';
    var setting = '&authkey=' + authkey;
    var d = dialog({
        title: title,
        id: uploadid,
        url: upload_url+'?_=' + Math.random() + args + setting,
        width: '500',
        height: '420',
        padding: 0,
        okValue: '确定',
        ok: function () {
            this.title('提交中…');
            if (funcName) {
                funcName.apply(this, [uploadid, itemId]);
            }
            this.close().remove();
            removeDialogIframe(uploadid);
            return false;
        },
        cancelValue: '取消',
        cancel: function () {
            this.close().remove();
            removeDialogIframe(uploadid);
            return false;
        }
    });
    d.showModal();
}

//artdialog关闭后还会有一个iframe，删除它
function removeDialogIframe(uploadid) {
    $('body').find('iframe[name="'+uploadid+'"]').remove();
}

$(document).ready(function(){
    setformSubmitButton();
});