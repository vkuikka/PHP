<?php
	require_once 'Vertex.class.php';

	class Vector {
		private $_x;
		private $_y;
		private $_z;
		private $_w = 1.0;

		static $verbose = false;

		public function getX(){return $this->_x;}
		public function getY(){return $this->_y;}
		public function getZ(){return $this->_z;}
		public function getW(){return $this->_w;}

		function __construct(array $arr){
			if (!isset($arr['dest']))
			{
				echo "ERROR give 'dest' vertex for vector. Following was given:\n";
				var_dump($arr);
				exit;
			}
			if (!isset($arr['orig']))
				$arr['orig'] = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0, 'w' => 0.0));
			$this->_x = $arr['dest']->getX() - $arr['orig']->getX();
			$this->_y = $arr['dest']->getY() - $arr['orig']->getY();
			$this->_z = $arr['dest']->getZ() - $arr['orig']->getZ();
			if (($arr['dest']->getW()) !== NULL)
				$this->_w = $arr['dest']->getW() - $arr['orig']->getW();
			if (self::$verbose == true)
			{
				printf("Vector( x:%.2f, y:%.2f, z:%.2f, w:%.2f ) constructed" . PHP_EOL,
					$this->_x, $this->_y, $this->_z, $this->_w);
			}
		}
		function __toString():string{
			$str = sprintf("Vector( x:%.2f, y:%.2f, z:%.2f, w:%.2f",
					$this->_x, $this->_y, $this->_z, $this->_w);
			if (self::$verbose === true && isset($this->col))
				$str = $str.", ".$this->_col;
			$str .= " )";
			return $str;
		}
		function __destruct(){
			if (self::$verbose == true)
			{
				printf("Vector( x:%.2f, y:%.2f, z:%.2f, w:%.2f",
						$this->_x, $this->_y, $this->_z, $this->_w);
				if (isset($this->_col))
					print ", ".$this->_col;
				print " ) destructed\n";
			}
		}
		static function doc(){
			if (file_exists("Vector.doc.txt"))
				return file_get_contents("Vector.doc.txt");
		}
		function magnitude():float{
			return (sqrt($this->_x**2 + $this->_y**2 + $this->_z**2));
		}

		function normalize():Vector{
			$mag = $this->magnitude();
			$x = $this->_x / $mag;
			$y = $this->_y / $mag;
			$z = $this->_z / $mag;
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return ($new);
		}

		function add(Vector $other):Vector{
			$x = $this->_x + $other->getX();
			$y = $this->_y + $other->getY();
			$z = $this->_z + $other->getZ();
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return $new;
		}
		function sub(Vector $other):Vector{
			$x = $this->_x - $other->getX();
			$y = $this->_y - $other->getY();
			$z = $this->_z - $other->getZ();
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return $new;
		}
		function opposite():Vector{
			$x = -$this->getX();
			$y = -$this->getY();
			$z = -$this->getZ();
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return $new;
		}
		function scalarProduct($k):Vector{
			$x = $k * $this->getX();
			$y = $k * $this->getY();
			$z = $k * $this->getZ();
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return $new;
		}
		function dotProduct(Vector $rhs):float{
			$x = $rhs->getX() * $this->getX();
			$y = $rhs->getY() * $this->getY();
			$z = $rhs->getZ() * $this->getZ();
			return ($x + $y + $z);
		}
		function crossProduct(Vector $rhs):Vector{
			$x = $this->getY() * $rhs->getZ() - $rhs->getY() * $this->getZ();
			$y = $this->getZ() * $rhs->getX() - $rhs->getZ() * $this->getX();
			$z = $this->getX() * $rhs->getY() - $rhs->getX() * $this->getY();
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return ($new);
		}
		function cos(Vector $rhs):float{
			return $this->dotProduct($rhs) / ($this->magnitude() * $rhs->magnitude()); 
		}

	}
?>
