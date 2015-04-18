<?php
	$pages = array();
	$pages["index"]="Home";
	$pages["blog"]="Blog";
	$pages["contact"]="Contact";
	$pages["about"]="About";	
?>
<nav>
	<ul>
		<?php foreach($pages as $link=>$title) {
				 $current = ($this->_controller==$link) ? " class='current'" : "";
				 $addr = $link == 'index' ? '' : $link;
				 echo "<li{$current}><a class='link' href='/mvc/{$addr}'>{$title}</a></li>";
		      }			
		?>
	</ul>		
</nav>		