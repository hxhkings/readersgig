<div>
	<h1 class="text-center title">Edit Comment</h1>
</div>

<div class="row">
	<div class="col-md-4 col-md-offset-4">

		<?php echo $this->Form->create('Comment', array('url' => array('controller' => 'comments', 'action' => 'edit', $id[0], $id[1]))); ?>


		<div class="form-group">
			<?php echo $this->Form->input('edit_comment', array('maxlength' => 100, 'required' => false, 'rows' => 2, 'class' => 'form-control', 'placeholder' => 'Write comment...')); ?>
			
		</div>
		<div>
			<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->submit('Save', array('class' => 'btn btn-primary')); ?>
		</div>

		<?php echo $this->Form->end(); ?>
	</div>
</div>