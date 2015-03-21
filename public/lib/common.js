//处理表单提单按钮，显示loading，禁用，启用。
function setformSubmitButton() {
    var isClick = false;
    var sysBtnSubmitObject = $('form .sys-btn-submit');
    var oldText = sysBtnSubmitObject.find('.sys-btn-submit-str').html();
    //处理表单提交
    $('form').submit(function(){
        var loading = sysBtnSubmitObject.attr('data-loading') || 'loading...';
        sysBtnSubmitObject.find('.sys-btn-submit-str').html(loading);
        sysBtnSubmitObject.attr('disabled', 'disabled');
        isClick = true;
    });
    //模拟submit
    sysBtnSubmitObject.on('click', function () {
        sysBtnSubmitObject.parents('form').submit();
        return false;
    });
    //取消按钮锁定
    $("body").on('click', function(){
        if(isClick){
            sysBtnSubmitObject.removeAttr('disabled');
            sysBtnSubmitObject.find('.sys-btn-submit-str').html(oldText);
        }
        isClick = false;
    });
}

//异步删除
function ajaxDelete(url, replaceID, notice) {
    if(confirm(notice)) {
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
    }
}

//显示loading
function loading() {
    var loading_image = '<img src="images/loading-icons/loading9.gif">';
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

$(document).ready(function(){
    setformSubmitButton();
});