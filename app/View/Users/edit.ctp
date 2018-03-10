<h1 class="text-center title">Edit Profile</h1>


<div class="row">
	<div class="col-md-4 col-md-offset-4">
<?php echo $this->Form->create('User', array( 'url' => 
									array('controller' => 'users', 'action' => 'edit'))); ?>

		<div class="form-group">
			<?php echo $this->Form->input('first_name', array('required' => false, 'class' => 'form-control')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input('last_name', array('required' => false, 'class' => 'form-control')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input('birthday', array('required' => false, 'class' => 'form-control')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input('phone_number', array('required' => false, 'class' => 'form-control')); ?>
		</div>
		<div class="form-group">
		<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->submit('Save', array('class' => 'btn btn-primary')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
