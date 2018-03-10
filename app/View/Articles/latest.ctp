<div class="row">
	<h1 class="text-center title">Latest Article</h1>
</div>

<div class="row">
	<div class="col-md-12 col-lg-12">
	
		<div class="article col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3" style="background:snow;">
			<h1 class="text-center"><?php echo $this->Html->link(h($article['Article']['title']), 
				array('controller' => 'articles', 'action' => 'view', $article['Article']['id']));?> </h1>
			<h3 class="text-center body"><?php echo h($article['Article']['body']); ?></h3>

			<h5 class="text-center">Created at: <?php echo h($article['Article']['created']);?></h5>
		</div>
	
	</div>
</div>