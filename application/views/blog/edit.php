<?php 
$this->layout = '~/views/shared/_defaultLayout.php';
?>
<div class="block bgWhite">
	<div class="content">
		<form action="/mvc/blog/edit/<?php echo $item['id']; ?>" method="post">
			<table width="100%">
				<tr>
					<td width="100">Author</td>
					<td><input type="input" name = "author" value="<?php echo $item['author']; ?>" style="width:99%;"/></td>
				</tr>
				<tr>
					<td width="100">Title</td>
					<td><input type="input" name = "title" value="<?php echo $item['title']; ?>" style="width:99%;"/></td>
				</tr>
				<tr>
					<td>Content</td>
					<td><textarea rows="30" style="width:99%;" name="content"><?php echo $item['content']; ?></textarea></td>
				</tr>
				<tr>
					<td>Date</td>
					<td>
						<?php echo $item['last_update']; ?>
						<input type="hidden" name="id" value="<?php echo $item['id']; ?>" />
						</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;">
						<input type="button" value="Cancel" style="width:60px;" onclick="window.location.href='/mvc/blog/detail/<?php echo $item['id']; ?>'"/>
						<input type="submit" value="Save" style="width:60px;"/>
					</td>
				</tr>
			</table>			
		</form>
	</div>
</div>