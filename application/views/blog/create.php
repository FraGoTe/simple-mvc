<?php 
$this->layout = '~/views/shared/_defaultLayout.php';
?>
<div class="block bgWhite">
	<div class="content">
		<form action="/mvc/blog/create" method="post">
			<table width="100%">
				<tr>
					<td width="100">Author</td>
					<td><input type="input" name = "author" value="" style="width:99%;"/></td>
				</tr>
				<tr>
					<td width="100">Title</td>
					<td><input type="input" name = "title" value="" style="width:99%;"/></td>
				</tr>
				<tr>
					<td>Content</td>
					<td><textarea rows="30" style="width:99%;" name="content"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;"><input type="submit" value="Save" style="width:40px;"/></td>
				</tr>
			</table>			
		</form>
	</div>
</div>