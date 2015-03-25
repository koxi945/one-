<div class="write-comment-main">
	<h3>说几句吧：</h3>
	<form id="tab" target="hiddenwin" method="post" >
		<textarea name="comment" rows="3" class="form-control" placeholder="三人行，必有我师。"></textarea>
		<div class="btn-toolbar list-toolbar">
          <a class="btn btn-primary sys-btn-submit" data-loading="保存中..." ><span class="sys-btn-submit-str">提交</span></a>
        </div>
	</form>
</div>
<?php if(isset($commentList) and is_array($commentList) and ! empty($commentList)): ?>
<?php
	//递归输出评论引用内容
	if( ! function_exists('showCommentReply'))
	{
		function showCommentReply($replyComment)
		{
			if( ! is_array($replyComment[0]) or empty($replyComment)) return '';
			$html = '';
			$value = $replyComment[0]; unset($replyComment[0]);
			$html .= '<div class="comment">';
			$nextValue = array_values($replyComment);
			if( ! empty($nextValue))
			{
				$html .= showCommentReply($nextValue);
			}
			$html .= '<div class="comment-content"><span class="blue f12"><span class="comment-nickname">'.$value['nickname'].'</span><span class="comment-date">于 '.showWriteTime($value['time']).'发布</span></span><br/><span>'.$value['content'].'</span></div>';
			$html .= '</div>';
			return $html;
		}
	}
?>
<div>
	<h3>评论内容：</h3>
</div>
	<?php foreach($commentList as $key => $value): ?>
	<div class="comment-main">
		<?php $replyComment = @ unserialize($value['reply_content']); ?>
		<?php if($replyComment !== false and is_array($replyComment) and ! empty($replyComment)): ?>
			<?php echo showCommentReply($replyComment); ?>
		<?php endif; ?>
		<div class="main">
			<span><?php echo $value['content']; ?></span>
			<div class="pull-right small comment-action">
				<span class="color-hui"><span class="comment-nickname"><?php echo $value['nickname']; ?></span>于 <?php echo showWriteTime($value['time']); ?>发布</span>
				<a href="javascript:void(0)">回复</a> 
				<a href="javascript:void(0)">支持</a>（<font id="support_3">0</font>）
			</div>
		</div>
		<div style="display:none" id="reply_3"></div>
	</div>
	<?php endforeach; ?>
<?php endif; ?>