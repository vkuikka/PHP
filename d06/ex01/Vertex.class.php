<?php
	require_once "../ex00/Color.class.php";

	class Vertex {
		public $x;
		public $y;
		public $z;
		public $col;
		public $w = 1.0;

		static $verbose = false;


		public function getX(){return $this->$x;}
		public function getY(){return $this->$y;}
		public function getZ(){return $this->$z;}
		public function getW(){return $this->$w;}
		function __construct(array $vertex){
			if (isset($vertex['color']))
				$this->col = $vertex['color'];
			else
				$this->col = new Color( array('red' => 255, 'green' => 255, 'blue' => 255));

			if (isset($vertex['x']) &&
				isset($vertex['y']) &&
				isset($vertex['z']))
			{
				$this->x = $vertex['x'];
				$this->y = $vertex['y'];
				$this->z = $vertex['z'];
				if (isset($vertex['w']))
					$this->w = $vertex['w'];
			}
			if (self::$verbose == true)
			{
				printf("Vertex( x: %.2f, y: %.2f, z: %.2f, w: %.2f, ",
							$this->x, $this->y, $this->z, $this->w);
				print $this->col." ) constructed\n";
			}
		}
		function __destruct(){
			if (self::$verbose == true)
			{
				printf("Vertex( x: %.2f, y: %.2f, z: %.2f, w: %.2f, ",
						$this->x, $this->y, $this->z, $this->w);
				print $this->col." ) destructed\n";
			}
		}
		function __toString():string{
			$str = sprintf("Vertex( x: %.2f, y: %.2f, z: %.2f, w: %.2f",
						$this->x, $this->y, $this->z, $this->w);
			if (self::$verbose === true && isset($this->col))
				$str = $str.", ".$this->col;
			$str .= " )";
			return $str;
		}
		static function doc(){
			if (file_exists("Vertex.doc.txt"))
				echo file_get_contents("Vertex.doc.txt");
		}

		function add(Color $other):Color{
			$new['x'] = $this->x + $other->x;
			$new['y'] = $this->y + $other->y;
			$new['z'] = $this->z + $other->z;
			$new['w'] = $this->w + $other->w;
			$res = new Vertex($new);
			return $res;
		}
		function sub(Color $other):Color{
			$new['x'] = $this->x - $other->x;
			$new['y'] = $this->y - $other->y;
			$new['z'] = $this->z - $other->z;
			$new['w'] = $this->w - $other->w;
			$res = new Vertex($new);
			return $res;
		}
		function mult(int $mult):Color{
			$new['x'] = $this->x * $mult;
			$new['y'] = $this->y - $mult;
			$new['z'] = $this->z - $mult;
			$new['w'] = $this->w - $mult;
			$res = new Vertex($new);
			return $res;
		}
	}
?>
