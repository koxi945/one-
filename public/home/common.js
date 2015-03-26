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
            sysBtnSubmitObject.parent().parent('form').submit(function(){
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

        sysBtnSubmitObject.parent().parent('form').submit();

        return false;
    });
    
}

$(document).ready(function(){
    setformSubmitButton();
});