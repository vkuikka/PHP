<?php
	require "../ex00/Color.class.php";
	class test {
	}

	class vertex {
		public $x;
		public $y;
		public $z;
		public $w;
		public $color;
		static $verbose = false;

		function __construct(array $coords){
			$this->$color = new Color;

			$this->x = $coords[0];
			$this->y = $coords[1];
			$this->z = $coords[2];
			$this->w = $coords[3];
			if ($this->verbose === TRUE)
				echo "construct\n";
		}
		function __destruct(){
			if ($this->verbose === TRUE)
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
	$arr = [1, 2, 3, 4];
	$obj = new Color($arr);

	var_dump($obj->blue);
	$new = $obj->add($obj);
	$new = $new->sub($obj);

	// var_dump($obj->blue);
	// var_dump($new);


?>