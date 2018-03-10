<?php  

		$check = $this->Session->read('Auth.User.role_id') !== NULL;
        $userRole = $this->Session->read('Auth.User.role_id');

    ?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<h1 class="text-center title">Published Articles</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-12 col-lg-12">
	<?php foreach($articles as $article): ?>
	
		<div class="article col-md-4 col-lg-4" style="background:snow;">

			<h1 class="text-center">
				<?php 
					if ($check && ($userRole == 1 || $userRole == 4 || $userRole == 3)){
						echo $this->Html->link(h($article['Article']['title']), 
						array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));
					} else {
						echo h($article['Article']['title']);
					}
				?> 
			</h1>
			<h3 class="text-center body"><?php echo substr(h($article['Article']['body']), 0, 9); ?>...</h3>
			<h5 class="text-center">Created at: <?php echo h($article['Article']['created']);?></h5>

			<?php if ($check && ($userRole == 3)): ?>
				<?php echo $this->Html->link('Edit', array('controller' => 'articles', 'action' => 'edit', $article['Article']['id']), array('class' => 'btn btn-success col-md-6')); ?>
			<?php endif; ?>
			<?php if ($check && ($userRole == 1)): ?>
				<?php echo $this->Form->postLink('Delete', array('controller' => 'articles', 'action' => 'delete', $article['Article']['id']), array('confirm' => 'Are you sure you want to delete this article?', 'class' => 'btn btn-danger col-md-6')); ?>
			<?php endif; ?>
		</div>
		
	<?php endforeach; ?>
	</div>
</div>