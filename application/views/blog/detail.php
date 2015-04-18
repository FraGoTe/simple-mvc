<?php 
$this->layout = '~/views/shared/_defaultLayout.php';
?>
<div class="block bgWhite">
	<div class="content">
		<h1 style="font-size: 20px; font-weight: bold; margin-bottom:5px;"><?php echo $item['title']; ?></h1>
		<span style="float:right;margin-top:-20px;">
			Posted on <?php echo $item['last_update']; ?>
			by <?php echo $item['author']?>
		</span>
		<hr style="margin: 20px 0px;">	
		<div><?php echo nl2br($item['content']); ?></div>
		<hr style="margin: 20px 0px;">	
		<div style="float: right;">
			<form method="post" action="/mvc/blog/delete/<?php echo $item['id']?>">
				<input type="button" value="Edit" onclick="location='/mvc/blog/edit/<?php echo $item['id']?>'" />
				<input type="submit" value="Delete" onclick="return confirm('Do you want to delete this post?')" />				
			</form>			
		</div>
	</div>
</div>