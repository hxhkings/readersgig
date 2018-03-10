<?php  

		$check = $this->Session->read('Auth.User.role_id') !== NULL;
        $userRole = $this->Session->read('Auth.User.role_id');

    ?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<h1 class="text-center title">Articles Page</h1>
	</div>
</div>
	
<div class="row">
	<div class="col-md-12 col-lg-12">
	<?php foreach($articles as $article): ?>
		
		<div class="article col-md-4 col-lg-4" style="background:snow;">

			<h1 class="text-center">

				<?php 
					if ($check && ($userRole == 1 || $userRole == 4 || $userRole == 3)){
						echo $this->Html->link($article['Article']['title'], 
						array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));
					} else {
						echo $article['Article']['title'];
					}
				?>
			 </h1>
			<h3 class="text-center"><?php echo h($article['Article']['body']);?></h3>
			<h5 class="text-center">Created at: <?php echo h($article['Article']['created']);?></h5>
			<div class="col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
			<?php
			if ($check && ($userRole == 2)):
			 echo $article['Article']['published'] == 0 ? $this->Form->postLink('Publish', array('controller' => 'articles', 'action' => 'publish', $article['Article']['id']), 
		array('confirm' => 'Are you sure you want to publish this article?',  'class' => 'btn btn-default')) :
			$this->Form->postLink('Unpublish', array('controller' => 'articles', 'action' => 'unpublish', $article['Article']['id']), 
		array('confirm' => 'Are you sure you want to unpublish this article?',  'class' => 'btn btn-default'))
		;
		endif;
		 ?>
			</div>
		</div>
		
	<?php endforeach; ?>
	</div>
</div>