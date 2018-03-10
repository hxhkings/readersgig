<h2 class="text-center">Log In</h2>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
	<?php echo $this->Flash->render('auth'); ?>
	<?php echo $this->Form->create(); ?>
	<div class="form-group">
		<?php echo $this->Form->input('username', array('required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('email', array('type' => 'email', 'required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('password', array('type' => 'password', 'required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->submit('Login', array('class' => 'btn btn-primary btn-lg')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->end(); ?>
	</div>
	</div>
</div>