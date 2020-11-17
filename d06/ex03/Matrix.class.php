<?php
	require_once '../ex01/Vertex.class.php';
	require_once '../ex02/Vector.class.php';

	class Matrix {
		const IDENTITY = "ID";
		const SCALE = "SC";
		const RX = "RX";
		const RY = "RY";
		const RZ = "RZ";
		const TRANSLATION = "TR";
		const PROJECTION = "PR";

		private $__vtcX;
		private $__vtcY;
		private $__vtcZ;
		private $__vtx0;

		static $verbose = false;

		public function getvX(){return $this->__vtcX;}
		public function getvY(){return $this->__vtcY;}
		public function getvZ(){return $this->__vtcZ;}

		function __construct(array $arr){
			if ((isset($vector['preset']) == SCALE &&
				!isset($vector['scale'])) ||

				((isset($vector['preset']) == RX ||
				isset($vector['preset']) == RY ||
				isset($vector['preset']) == RZ) &&
				!isset($vector['angle'])) ||

				((isset($vector['preset']) == TRANSLATION) &&
				!isset($vector['vtc'])) ||

				((isset($vector['preset']) == PROJECTION) &&
				(!isset($vector['fov']) ||
				!isset($vector['ratio']) ||
				!isset($vector['near']) ||
				!isset($vector['far']))))
			{
				echo "ERROR";
				exit;
			}

			if ($arr['preset'] == self::IDENTITY)
			{
				$vx['dest'] = new Vertex(array('x' => 1, 'y' => 0, 'z' => 0, 'w' => 0));
				$this->__vtcX = new Vector($vx);
				$vy['dest'] = new Vertex(array('x' => 0, 'y' => 1, 'z' => 0, 'w' => 0));
				$this->__vtcY = new Vector($vy);
				$vz['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 1, 'w' => 0));
				$this->__vtcZ = new Vector($vz);
				$v0['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
				$this->__vtx0 = new Vector($v0);
				echo "Matrix IDENTITY instance constructed\n";
			}
			if ($arr['preset'] == self::SCALE && isset($arr['scale']))
			{
				$vx['dest'] = new Vertex(array('x' => $arr['scale'], 'y' => 0, 'z' => 0, 'w' => 0));
				$this->__vtcX = new Vector($vx);
				$vy['dest'] = new Vertex(array('x' => 0, 'y' => $arr['scale'], 'z' => 0, 'w' => 0));
				$this->__vtcY = new Vector($vy);
				$vz['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => $arr['scale'], 'w' => 0));
				$this->__vtcZ = new Vector($vz);
				$v0['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
				$this->__vtx0 = new Vector($v0);
				echo "Matrix SCALE instance constructed\n";
			}
			if ($arr['preset'] == self::RX && isset($arr['angle']))
			{
				$vx['dest'] = new Vertex(array('x' => 1, 'y' => 0, 'z' => 0, 'w' => 0));
				$this->__vtcX = new Vector($vx);
				$vy['dest'] = new Vertex(array('x' => cos($arr['angle']), 'y' => -sin($arr['angle']), 'z' => 0, 'w' => 0));
				$this->__vtcY = new Vector($vy);
				$vz['dest'] = new Vertex(array('x' => sin($arr['angle']), 'y' => cos($arr['angle']), 'z' => 0, 'w' => 0));
				$this->__vtcZ = new Vector($vz);
				$v0['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
				$this->__vtx0 = new Vector($v0);
				echo "Matrix Ox ROTATION instance constructed\n";
			}
			if ($arr['preset'] == self::RY && isset($arr['angle']))
			{
				$vx['dest'] = new Vertex(array('x' => cos($arr['angle']), 'y' => 0, 'z' => sin($arr['angle']), 'w' => 0));
				$this->__vtcX = new Vector($vx);
				$vy['dest'] = new Vertex(array('x' => 0, 'y' => 1, 'z' => 0, 'w' => 0));
				$this->__vtcY = new Vector($vy);
				$vz['dest'] = new Vertex(array('x' => -sin($arr['angle']), 'y' => 0, 'z' => cos($arr['angle']), 'w' => 0));
				$this->__vtcZ = new Vector($vz);
				$v0['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
				$this->__vtx0 = new Vector($v0);
				echo "Matrix Oy ROTATION instance constructed\n";
			}
			if ($arr['preset'] == self::RZ && isset($arr['angle']))
			{
				$vx['dest'] = new Vertex(array('x' => cos($arr['angle']), 'y' => -sin($arr['angle']), 'z' => 0, 'w' => 0));
				$this->__vtcX = new Vector($vx);
				$vy['dest'] = new Vertex(array('x' => sin($arr['angle']), 'y' => cos($arr['angle']), 'z' => 0, 'w' => 0));
				$this->__vtcY = new Vector($vy);
				$vz['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 1, 'w' => 0));
				$this->__vtcZ = new Vector($vz);
				$v0['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => 1));
				$this->__vtx0 = new Vector($v0);
				echo "Matrix Oz ROTATION instance constructed\n";
			}
			if ($arr['preset'] == self::TRANSLATION && isset($arr['vtc']))
			{
				$vtc = $arr['vtc'];
				$vx['dest'] = new Vertex(array('x' => 1, 'y' => 0, 'z' => 0, 'w' => $vtc->getX()));
				$this->__vtcX = new Vector($vx);
				$vy['dest'] = new Vertex(array('x' => 0, 'y' => 1, 'z' => 0, 'w' => $vtc->getY()));
				$this->__vtcY = new Vector($vy);
				$vz['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 1, 'w' => $vtc->getZ()));
				$this->__vtcZ = new Vector($vz);
				$v0['dest'] = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0, 'w' => $vtc->getW()));
				$this->__vtx0 = new Vector($v0);
				echo "Matrix TRANSLATION instance constructed\n";
			}
		}
		function __toString():string{
			$vx = $this->__vtcX;
			$vy = $this->__vtcY;
			$vz = $this->__vtcZ;
			$vw = $this->__vtx0;
			return("M | vtcX | vtcY | vtcZ | vtxO
-----------------------------
x | ".sprintf("%.2f", $vx->getX())." | ".sprintf("%.2f", $vy->getX())." | ".sprintf("%.2f", $vz->getX())." | ".sprintf("%.2f", $vw->getX())."
y | ".sprintf("%.2f", $vx->getY())." | ".sprintf("%.2f", $vy->getY())." | ".sprintf("%.2f", $vz->getY())." | ".sprintf("%.2f", $vw->getY())."
z | ".sprintf("%.2f", $vx->getZ())." | ".sprintf("%.2f", $vy->getZ())." | ".sprintf("%.2f", $vz->getZ())." | ".sprintf("%.2f", $vw->getZ())."
w | ".sprintf("%.2f", $vx->getW())." | ".sprintf("%.2f", $vy->getW())." | ".sprintf("%.2f", $vz->getW())." | ".sprintf("%.2f", $vw->getW()));
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

		function mult(Matrix $rhs):Matrix{
			$res = new Matrix(
				new Vector(array(0, 0, 0, 0)),
				new Vector(array(0, 0, 0, 0)),
				new Vector(array(0, 0, 0, 0)),
				new Vector(array(0, 0, 0, 0))
			);



			$x = $this->getY() * $rhs->getZ() - $rhs->getY() * $this->getZ();
			$y = $this->getZ() * $rhs->getX() - $rhs->getZ() * $this->getX();
			$z = $this->getX() * $rhs->getY() - $rhs->getX() * $this->getY();
			$new = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			$new = new Vector(array('dest' => $new));
			return ($new);
		}
		// function transformVertex(Vector $vtx):Vector{

	}
?>
