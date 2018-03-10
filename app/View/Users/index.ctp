<div>
	<h1 class="text-center title">Users Page</h1>
</div>

<div class="col-md-6 col-lg-6 col-md-offset-3">

	<?php foreach ($users as $user): ?>
		<div class="btn btn-default" style="width:100%">
			<a href="/readersgig/users/profile/<?php echo $user['User']['id']; ?>">
			<h2 class="text-center"><?php echo h($user['User']['username']); ?> is 
				<?php echo h($user['Role']['title']) === 'reader' || h($user['Role']['title']) === 'publisher'
				? 'a' : 'an'; ?> 
				<?php echo h($user['Role']['title']); ?></h2>
			<h4 style="background:#aaaaaa" class="text-center">Member since: <?php echo h($user['User']['created']); ?></h4>
			</a>
		</div>
	<?php endforeach; ?>
</div>