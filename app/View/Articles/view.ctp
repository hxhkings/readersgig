
<?php  

		$check = $this->Session->read('Auth.User.role_id') !== NULL;
        $userRole = $this->Session->read('Auth.User.role_id');

    ?>
<div class="row">
	<div class="col-md-4 col-md-offset-1">

		<h2 style="padding-left: 10px"><?php echo $article['Article']['title']; ?></h2>
		<h5>Created By: <strong style="color:#4422ff; text-shadow:0px 0px 10px #fff;"><?php echo $article['User']['username']; ?></strong> on <?php echo $article['Article']['created']; ?></h5>
		<h4><?php echo $article['Article']['body']; ?></h4>
		
		<?php
		if ($check && ($userRole == 1)):
		 echo $published == 0 ? '' :
			$this->Form->postLink('Unpublish', array('controller' => 'articles', 'action' => 'unpublish', $article['Article']['id']), 
		array('confirm' => 'Are you sure you want to unpublish this article?',  'class' => 'btn btn-default'))
		;
		endif;

		if ($check && ($userRole == 1 || $userRole == 4)):
		echo $this->Form->postLink('Share', array('controller' => 'articles', 'action' => 'share', $article['Article']['id']), 
		array('confirm' => 'Are you sure you want to share this article?',  'class' => 'btn btn-default'));
	 	endif;
		 ?>
		

		 <h4 style="color: #aa2211">Rating: <?php echo h($article['Article']['rating']); ?></h4>

		 <?php  
		 		if ($check && ($userRole == 4)):
		 		echo $this->Html->link("<span class='glyphicon glyphicon-thumbs-up'></span>", array('controller' => 'articles', 'action' => 'upvote', $article['Article']['id']),
		 							array('class' => 'btn btn-success', 'escape' => false, 'style' => 'margin-right: 5px')); 
		 		echo $this->Html->link("<span class='glyphicon glyphicon-thumbs-down'></span>", array('controller' => 'articles', 'action' => 'downvote', $article['Article']['id']),
		 							array('class' => 'btn btn-danger', 'escape' => false));
		 		endif;
		 							?>

		<h3>Comments:</h3>
		<?php if ($check && ($userRole == 4 || $userRole == 1)): ?>
			<?php echo $this->Form->create('Comment', array('url' => array('controller' => 'comments', 'action' => 'create', $article['Article']['id']))); ?>
			<div class="form-group"> 
			<?php echo $this->Form->input('comment', array('maxlength' => 100, 'required' => false, 'rows' => 2, 'class' => 'form-control', 'placeholder' => 'Write comment...')); ?>
			</div>
			<div class="form-group">
			<?php echo $this->Form->submit('Save', array('class' => 'btn btn-primary')); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		<?php endif; ?>
		<?php $i = 0; ?>
		<?php foreach ($article['Comment'] as $comment): ?>
			<h4 style="color: #aa2211"><?php echo $comment['body']; ?></h4>
			<h5>Created By: <?php echo $users[$i]; ?> on <?php echo substr($comment['created'], 0, 10); ?></h5>
			<?php if ($check && ($userRole == 1)): ?>
			<?php echo $this->Html->link('Edit', array('controller' => 'comments', 'action' => 'edit', $comment['id'], $article['Article']['id']), array('class' => 'btn btn-success')); ?>
			
			<?php echo $this->Form->postLink('Delete', 
					array('controller' => 'comments', 'action' => 'delete', $comment['id'], $article['Article']['id']), 
							array('confirm' => 'Are you sure you want to delete this comment?', 'class' => 'btn btn-danger'));
							 ?>
			
			<?php endif; ?>
		<?php
			$i++;
		 endforeach; ?>

	</div>
</div>
