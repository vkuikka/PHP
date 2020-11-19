<?php
class Lannister {
}
class Jaime extends Lannister {
	public function sleepWith($in) {
	if (get_class($in) == 'Tyrion')
		echo "Not even if i'm drunk !\n";
	if (get_class($in) == 'Sansa')
		echo "let's do this.\n";
	if (get_class($in) == 'Cersei')
		echo "With pleasure, but only in a tower in Winterfell, then.\n";
	}
}
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
