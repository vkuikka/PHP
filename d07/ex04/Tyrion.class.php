<?php
class Tyrion extends Lannister {
	public function sleepWith($in) {
	if (get_class($in) == 'Jaime')
		echo "Not even if i'm drunk !\n";
	if (get_class($in) == 'Sansa')
		echo "let's do this.\n";
	if (get_class($in) == 'Cersei')
		echo "Not even if i'm drunk !\n";
	}
}
?>
