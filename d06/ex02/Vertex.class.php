<?php
	require_once "Color.class.php";

	class Vertex {
		private	$_x;
		private	$_y;
		private	$_z;
		private	$_w = 1.0;
		private	$_col;
		static	$verbose = false;

		public function getX(){return $this->_x;}
		public function getY(){return $this->_y;}
		public function getZ(){return $this->_z;}
		public function getW(){return $this->_w;}
		public function getColor(){return $this->_col;}
		function __construct(array $vertex){
			if (isset($vertex['color']))
				$this->_col = $vertex['color'];
			else
				$this->_col = new Color( array('red' => 255, 'green' => 255, 'blue' => 255));

			if (isset($vertex['x']) &&
				isset($vertex['y']) &&
				isset($vertex['z']))
			{
				$this->_x = $vertex['x'];
				$this->_y = $vertex['y'];
				$this->_z = $vertex['z'];
				if (isset($vertex['w']))
					$this->_w = $vertex['w'];
				else
					$this->_w = 1.0;
			}
			if (self::$verbose == true)
			{
				printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, ",
							$this->_x, $this->_y, $this->_z, $this->_w);
				print $this->_col." ) constructed\n";
			}
		}
		function __destruct(){
			if (self::$verbose == true)
			{
				printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, ",
						$this->_x, $this->_y, $this->_z, $this->_w);
				print $this->_col." ) destructed\n";
			}
		}
		function __toString():string{
			$str = sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f",
						$this->_x, $this->_y, $this->_z, $this->_w);
			if (self::$verbose === true && isset($this->_col))
				$str = $str.", ".$this->_col;
			$str .= " )";
			return $str;
		}
		static function doc(){
			if (file_exists("Vertex.doc.txt"))
				return file_get_contents("Vertex.doc.txt");
		}

		function add(Color $other):Color{
			$new['x'] = $this->_x + $other->_x;
			$new['y'] = $this->_y + $other->_y;
			$new['z'] = $this->_z + $other->_z;
			$new['w'] = $this->_w + $other->_w;
			$res = new Vertex($new);
			return $res;
		}
		function sub(Color $other):Color{
			$new['x'] = $this->_x - $other->_x;
			$new['y'] = $this->_y - $other->_y;
			$new['z'] = $this->_z - $other->_z;
			$new['w'] = $this->_w - $other->_w;
			$res = new Vertex($new);
			return $res;
		}
		function mult(int $mult):Color{
			$new['x'] = $this->_x * $mult;
			$new['y'] = $this->_y * $mult;
			$new['z'] = $this->_z * $mult;
			$new['w'] = $this->_w * $mult;
			$res = new Vertex($new);
			return $res;
		}
	}
?>
