<?php
	class Color {
		public $red;
		public $green;
		public $blue;
		static $verbose = false;

		function __construct(array $colors){
			$this->red = $colors[0];
			$this->green = $colors[1];
			$this->blue = $colors[2];
			echo "construct\n";
		}
		function __destruct(){
			echo "destruct\n";
		}
		function __toString():string{
			return "tostring\n";
		}
		static function doc(){
			echo "documentation\n";
		}
		function add(Color $other):Color{
			$new = new Color(array(0, 0, 0));
			$new->red = $this->red + $other->red;
			$new->green = $this->green + $other->green;
			$new->blue = $this->blue + $other->blue;
			return $new;
		}
		function sub(Color $other):Color{
			$new = new Color(array(0, 0, 0));
			$new->red = $this->red - $other->red;
			$new->green = $this->green - $other->green;
			$new->blue = $this->blue - $other->blue;
			return $new;
		}
		function mult(Color $other):Color{
			$new = new Color(array(0, 0, 0));
			$new->red = $this->red * $other->red;
			$new->green = $this->green * $other->green;
			$new->blue = $this->blue * $other->blue;
			return $new;
		}
	}
	$arr = [1, 2, 3];
	$obj = new Color($arr);

	var_dump($obj->blue);
	$new = $obj->add($obj);
	$new = $new->sub($obj);

	// var_dump($obj->blue);
	// var_dump($new);


	return;
?>
