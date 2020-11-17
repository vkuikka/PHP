<?php
	require_once '../ex01/Vertex.class.php';

	class Vector {
		private $__x;
		private $__y;
		private $__z;
		private $__w = 0.0;

		static $verbose = false;

		public function getX(){return $this->__x;}
		public function getY(){return $this->__y;}
		public function getZ(){return $this->__z;}

		public function getW(){return $this->__w;}

		function __construct(array $vector){
			if (!isset($vector['dest']))
			{
				echo "ERROR give destination vertex for vector. Following was given:\n";
				var_dump($vector);
				exit;
			}
			if (!isset($vector['orig']))
				$vector['orig'] = new Vertex(array('x' => 0.0, 'y' => 0.0, 'z' => 0.0));

			$this->__x = $vector['dest']->x - $vector['orig']->x;
			$this->__y = $vector['dest']->y - $vector['orig']->y;
			$this->__z = $vector['dest']->z - $vector['orig']->z;


			if (self::$verbose == true)
			{
				printf("Vector( x: %.2f, y: %.2f, z: %.2f, w: %.2f ) constructed" . PHP_EOL,
					$this->__x, $this->__y, $this->__z, $this->__w);
			}
		}
		function __toString():string{
			$str = sprintf("Vector( x: %.2f, y: %.2f, z: %.2f, w: %.2f",
					$this->__x, $this->__y, $this->__z, $this->__w);
			if (self::$verbose === true && isset($this->col))
				$str = $str.", ".$this->col;
			$str .= " )";
			return $str;
		}
		function __destruct(){
			if (self::$verbose == true)
			{
				printf("Vector( x: %.2f, y: %.2f, z: %.2f, w: %.2f",
						$this->__x, $this->__y, $this->__z, $this->__w);
				if (isset($this->col))
					print ", ".$this->col;
				print " ) destructed\n";
			}
		}
		static function doc(){
			if (file_exists("Vector.doc.txt"))
				echo file_get_contents("Vector.doc.txt");
		}
		function magnitude():float{
			return (sqrt($this->getX()**2 + $this->getY()**2 + $this->getZ()**2));
		}

		function normalize():Vector{
			$mag = $this->magnitude();
			$x = $this->__x / $mag;
			$y = $this->__y / $mag;
			$z = $this->__z / $mag;
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return ($new);
		}

		function add(Vector $other):Vector{
			$x = $this->__x + $other->getX();
			$y = $this->__y + $other->getY();
			$z = $this->__z + $other->getZ();
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return $new;
		}
		function sub(Vector $other):Vector{
			$x = $this->__x - $other->getX();
			$y = $this->__y - $other->getY();
			$z = $this->__z - $other->getZ();
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
