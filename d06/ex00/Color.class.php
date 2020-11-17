<?php
	class Color {
		public $red = 255;
		public $green = 255;
		public $blue = 255;
		static $verbose = false;

		function __construct(array $colors){
			if (isset($colors['rgb']))
			{
				$col = dechex($colors['rgb']);
				while (strlen($col) != 6)
					$col = "0".$col;
				$this->red = hexdec($col[0].$col[1]);
				$this->green = hexdec($col[2].$col[3]);
				$this->blue = hexdec($col[4].$col[5]);
			}
			else if (isset($colors['red']) &&
					isset($colors['green']) &&
					isset($colors['blue']))
			{
				$this->red = $colors['red'];
				$this->green = $colors['green'];
				$this->blue = $colors['blue'];
			}
			if (self::$verbose == true)
				printf("Color( red: %3d, green: %3d, blue: %3d ) constructed\n",
							$this->red, $this->green, $this->blue);
		}
		function __destruct(){
			if (self::$verbose == true)
				printf("Color( red: %3d, green: %3d, blue: %3d ) destructed\n",
							$this->red, $this->green, $this->blue);
		}
		function __toString():string{
			return (sprintf("Color( red: %3d, green: %3d, blue: %3d )",
						$this->red, $this->green, $this->blue));
		}
		static function doc(){
			if (file_exists("Color.doc.txt"))
				echo file_get_contents("Color.doc.txt");
		}
		function add(Color $other):Color{
			$new['red'] = $this->red + $other->red;
			$new['green'] = $this->green + $other->green;
			$new['blue'] = $this->blue + $other->blue;
			$res = new Color($new);
			return $res;
		}
		function sub(Color $other):Color{
			$new['red'] = $this->red - $other->red;
			$new['green'] = $this->green - $other->green;
			$new['blue'] = $this->blue - $other->blue;
			$res = new Color($new);
			return $res;
		}
		function mult(int $mult):Color{
			$new['red'] = $this->red * $mult;
			$new['green'] = $this->green * $mult;
			$new['blue'] = $this->blue * $mult;
			$res = new Color($new);
			return $res;
		}
	}
?>
