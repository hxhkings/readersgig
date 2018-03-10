<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Reader's Gig
		
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min.css');

		echo $this->fetch('meta');
		echo $this->fetch('css');

		echo $this->fetch('script');
	?>
  <style>
    input, div{
      font-family: Times Georgia Serif;
    }
    h2, h1.title, h3.body{
      margin:30px 0px; font-family:Times; color:#4422ff; text-shadow:0px 0px 10px #fff;font-size: 50px;
      background:#aaaaaa; width:100%
    }
    a:hover {
      text-decoration: none;
    }
  </style>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>

	<div class="container-fluid">
	<div style="position:fixed; z-index:-3; display:block; top:0; left:0">
        <?php echo $this->Html->image('coffee-cup-stack-break.jpg', 
                  array('alt' => 'Article', 'width'=>'100%')); ?>
</div>
<div class="row">
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php echo $this->Html->link('Reader\'s Gig', array('controller'=>'articles', 'action'=>'index'), array('class' => 'navbar-brand')); ?>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php 
          $check = $this->Session->read('Auth.User.role_id') !== NULL;
          $userRole = $this->Session->read('Auth.User.role_id');
          if ($check && ($userRole == 1)):
         ?>
        <li class="active"><?php echo $this->Html->link('Users', array('controller'=> 'users', 'action' => 'index')); ?></li>
         <?php endif; ?>
        <li><?php echo $this->Html->link('Articles', array('controller' => 'articles', 'action' => 'index')); ?></li>
       
      </ul>
      
      <?php 
        echo $this->Form->create('Article', array('url' => array( 'controller'=> 'articles', 'action' => 'search'),'class' => 'navbar-form navbar-left'));

      ?>
      <div class="form-group">
        <?php echo $this->Form->input('query', array( 'class' => 'form-control','placeholder' => 'Search', 'label' => false, 'required' => true)); ?>
      </div>
      <div class="form-group">
      <?php echo $this->Form->submit('Submit', array('class' => 'btn btn-default')); ?>
      </div>
      <?php echo $this->Form->end(); ?>
      <ul class="nav navbar-nav navbar-right">
        <li>

        <?php 

          
          $user = '<a href="">Username</a>';
           if ($check) {
              $id = $this->Session->read('Auth.User.id');
               $user = $this->Html->link($this->Session->read('Auth.User.username'),
                      array('controller'=>'users', 'action' => 'profile', $id)
                ); 
            }
          echo $user;

        ?>
          
        </li>
        <?php $role = array( 1 => 'Administrator', 2 => 'Publisher', 3 => 'Author', 4 => 'Reader'); ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo isset($role[$this->Session->read('Auth.User.role_id')]) ?
           $role[$this->Session->read('Auth.User.role_id')] : 'Member'; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <?php if(null === $this->Session->read('Auth.User.role_id')): ?>
            <li><?php echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login')); ?></li>
           <?php else: ?>
            
            <li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?></li>
            <?php endif; ?>
            <?php if(isset($role[$this->Session->read('Auth.User.role_id')]) && $role[$this->Session->read('Auth.User.role_id')] === 'Administrator' ): ?>
              <li role="separator" class="divider"></li>
              <li><?php echo $this->Html->link('Add User', array('controller' => 'users', 'action' => 'add')); ?></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  </div>
  <div class="flash-message" style="color:blue; font-size:24px; font-family:Times; background: #eeddff;">
       <?php echo $this->Session->flash(); ?>
      </div>
  <?php if ($userRole == 1): ?>
  <div class="row">

     <?php 
        echo $this->Form->create('User', array('url' => array( 'controller'=> 'users', 'action' => 'search'),'class' => 'navbar-form navbar-left'));

      ?>
      <h3>Search Users:</h3>
      <div class="form-group">

        <?php echo $this->Form->input('queryUser', array( 'class' => 'form-control','placeholder' => 'Search users', 'label' => false, 'required' => true)); ?>
      </div>
      <div class="form-group">
      <?php echo $this->Form->submit('Search', array('class' => 'btn btn-default')); ?>
      </div>
      <?php echo $this->Form->end(); ?>
     
  </div>
<?php endif; ?>
		<div id="content">
      
			<?php echo $this->fetch('content'); ?>
		</div>
		
	</div>
	<?php echo $this->Html->script('bootstrap.min')?>
</body>
</html>
