<?php 
$this->layout = '~/views/shared/_defaultLayout.php';
?>
<div class="block bgWhite">
	<div class="content">
		<img src="http://www.orbitsolutions.in/images/about_banner.jpg" width="990" alt="" />
	</div>
</div>
<div class="block bgWhite">
	<div class="content">
		<div class="col">
			<h2>Our Story</h2>
			<?php include(MyHelpers::UrlContent('~/views/shared/_text1Part.php')); ?>
		</div>
		<div class="col">
			<h2>Out Mission</h2>
			<?php include(MyHelpers::UrlContent('~/views/shared/_text1Part.php')); ?>
		</div>
		<div class="col">
			<h2>Work with us</h2>
			<?php include(MyHelpers::UrlContent('~/views/shared/_text1Part.php')); ?>	
		</div>
	</div>
</div>