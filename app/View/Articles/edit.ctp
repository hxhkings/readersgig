<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<h2 class="text-center">Edit Article</h2>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div style="margin:20px 0px">
		<?php echo $this->Html->link('Cancel', array('action' => 'index'), array('class' => 'btn btn-warning')); ?>
		</div>

	</div>
</div>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
	<?php echo $this->Form->create('Article', 
			array('id'=>'create-article', 'url' =>
			 array('controller' => 'articles', 'action' => 'edit'),
			 'class'=>'form-horizontal')); ?>
	
	<div class="form-group">
		<?php echo $this->Form->input('title', array('required' => false, 'class' => 'form-control')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->input('body', array('rows' => 10, 'required' => false, 'class' => 'form-control')); ?>
	</div>
	
		<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Submit', array('class' => 'btn btn-primary btn-lg')); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->end(); ?>
	</div>
	</div>
</div>