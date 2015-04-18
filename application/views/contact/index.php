<?php 
$this->layout = '~/views/shared/_defaultLayout.php';
?>
<div class="block bgWhite">
	<div class="content">
		<img src="http://www.expressremovals.com.au/wp-content/header-images/contact-banner.png" width="990" alt="" />
	</div>
</div>
<div class="block bgWhite">
	<div class="content">
		<div class="col">
			<h2>Our Office</h2>
			<?php include(MyHelpers::UrlContent('~/views/shared/_text1Part.php')); ?>
		</div>
		<div class="col">
			<h2>Our Location</h2>
			<?php include(MyHelpers::UrlContent('~/views/shared/_text1Part.php')); ?>
		</div>
		<div class="col">
			<h2>Send us your thoughts</h2>
			<?php include(MyHelpers::UrlContent('~/views/shared/_text1Part.php')); ?>	
		</div>
	</div>
</div>