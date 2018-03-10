<div class="row">
	<h1 class="text-center title">Searched Articles</h1>
</div>

<div class="row">
	<div class="col-md-12 col-lg-12">
	<?php foreach($articles as $article): ?>
		<div class="article col-md-4 col-lg-4" style="background:snow;">
			<h1 class="text-center"><?php echo $this->Html->link(h($article['Article']['title']), 
				array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));?> </h1>
			<h3 class="text-center body"><?php echo substr(h($article['Article']['body']), 0, 9); ?>...</h3>
			<h5 class="text-center">Created at: <?php echo h($article['Article']['created']);?></h5>
		</div>
	<?php endforeach; ?>
	</div>
</div>