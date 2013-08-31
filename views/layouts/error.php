<!DOCTYPE>
<html>
<head>
	<meta charset="UTF-8">
	<title>le site intranet de la DOPC</title>
	<?php echo $this->link('css', 'bootstrap.min'); ?>

	<?php echo $this->link('css', 'layout'); ?>
	<?php echo $this->link('javascript', 'modernizer'); ?>
	<?php echo $this->link('javascript', 'jquery'); ?>
	
	<?php echo $this->link('javascript', 'bootstrap.min'); ?>
	<?php //echo $this->link('javascript', 'tinymce/tinymce.min'); ?>
</head>
<body>
	<div class="row-fluid">
		<div class="span8 offset2">
			<?php $this->img('design/logo_wheel404.png'); ?>

		</div>
	</div>
	<div class="row-fluid">
		<div class="span8 offset2">
			<?php echo $content_for_layout; ?>
		</div>
	</div>	

			
</body>
</html>