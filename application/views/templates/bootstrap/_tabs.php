<?php defined('BASEPATH') OR exit('No direct script access allowed');

ksort($this->tabs);

if(sizeof($this->tabs)>0){
	foreach ($this->tabs as $key => $tab) {
?>
	<li class="<?php echo $tab['class'];?>">
		<a href="<?php echo $tab['src'];?>"><?php echo $tab['title'];?></a>
	</li>
<?php
	}
}