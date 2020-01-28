<header>
	Home
</header>
<nav>
	<ul>
	<?php
		session_start();
		foreach ($content as $page => $location) {
			echo "<li><a href='$location' ".($page==$currentpage?" class='active'":"").">".$page."</a></li>";
		}
	?>
	</ul>
</nav>
