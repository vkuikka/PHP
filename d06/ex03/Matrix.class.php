<?php
	require_once 'Vertex.class.php';
	require_once 'Vector.class.php';

	class Matrix {
		const IDENTITY = "ID";
		const SCALE = "SC";
		const RX = "RX";
		const RY = "RY";
		const RZ = "RZ";
		const TRANSLATION = "TR";
		const PROJECTION = "PR";

		private $matrix = array();

		static $verbose = false;

		public function getvX(){return $this->__vtcX;}
		public function getvY(){return $this->__vtcY;}
		public function getvZ(){return $this->__vtcZ;}

		function __construct(array $arr){
			if ($arr['preset'] == self::IDENTITY)
			{
				$this->matrix[0] = [1, 0, 0, 0];
				$this->matrix[1] = [0, 1, 0, 0];
				$this->matrix[2] = [0, 0, 1, 0];
				$this->matrix[3] = [0, 0, 0, 1];
				echo "Matrix IDENTITY instance constructed\n";
			}
			if ($arr['preset'] == self::SCALE && isset($arr['scale']))
			{
				$s = $arr['scale'];
				$this->matrix[0] = [$s,	0,	0,	0];
				$this->matrix[1] = [0,	$s,	0,	0];
				$this->matrix[2] = [0,	0,	$s,	0];
				$this->matrix[3] = [0,	0,	0,	1];
				echo "Matrix SCALE preset instance constructed\n";
			}
			if ($arr['preset'] == self::RX && isset($arr['angle']))
			{
				$c = cos($arr['angle']);
				$s = sin($arr['angle']);
				$this->matrix[0] = [1,	0,	0,	0];
				$this->matrix[1] = [0,	$c,	$s,	0];
				$this->matrix[2] = [0,	-$s,$c,	0];
				$this->matrix[3] = [0,	0,	0,	1];
				echo "Matrix Ox ROTATION preset instance constructed\n";
			}
			if ($arr['preset'] == self::RY && isset($arr['angle']))
			{
				$c = cos($arr['angle']);
				$s = sin($arr['angle']);
				$this->matrix[0] = [$c,	0,	-$s,0];
				$this->matrix[1] = [0,	1,	0,	0];
				$this->matrix[2] = [$s,	0,	$c,	0];
				$this->matrix[3] = [0,	0,	0,	1];
				echo "Matrix Oy ROTATION preset instance constructed\n";
			}
			if ($arr['preset'] == self::RZ && isset($arr['angle']))
			{
				$c = cos($arr['angle']);
				$s = sin($arr['angle']);
				$this->matrix[0] = [$c,	$s,	0,	0];
				$this->matrix[1] = [-$s,$c,	0,	0];
				$this->matrix[2] = [0,	0,	1,	0];
				$this->matrix[3] = [0,	0,	0,	1];
				echo "Matrix Oz ROTATION preset instance constructed\n";
			}
			if ($arr['preset'] == self::TRANSLATION && isset($arr['vtc']))
			{
				$v = $arr['vtc'];
				$this->matrix[0] = [1,	0,	0,	0];
				$this->matrix[1] = [0,	1,	0,	0];
				$this->matrix[2] = [0,	0,	1,	0];
				$this->matrix[3] = [$v->getX(),	$v->getY(),	$v->getZ(),	1];
				echo "Matrix TRANSLATION preset instance constructed\n";
			}
			if ($arr['preset'] == self::PROJECTION && isset($arr['ratio']))
			{
				$this->matrix[1][1] = 1 / tan(0.5 * deg2rad($arr['fov']));
				$this->matrix[0][0] = $this->matrix[1][1] / $arr['ratio'];
				$this->matrix[2][2] = -1 * ((float)-$arr['near'] - (float)$arr['far']) / (float)($arr['near'] - (float)$arr['far']);
				$this->matrix[2][3] = -1;
				$this->matrix[3][2] = (2 * (float)$arr['near'] * (float)$arr['far']) / (float)($arr['near'] - (float)$arr['far']);
				$this->matrix[3][3] = 0;
				echo "Matrix PROJECTION preset instance constructed\n";
			}
		}
		function __toString():string{
			$m = $this->matrix;
			return("M | vtcX | vtcY | vtcZ | vtxO
-----------------------------
x | ".sprintf("%.2f", $m[0][0])." | ".sprintf("%.2f", $m[1][0])." | ".sprintf("%.2f", $m[2][0])." | ".sprintf("%.2f", $m[3][0])."
y | ".sprintf("%.2f", $m[0][1])." | ".sprintf("%.2f", $m[1][1])." | ".sprintf("%.2f", $m[2][1])." | ".sprintf("%.2f", $m[3][1])."
z | ".sprintf("%.2f", $m[0][2])." | ".sprintf("%.2f", $m[1][2])." | ".sprintf("%.2f", $m[2][2])." | ".sprintf("%.2f", $m[3][2])."
w | ".sprintf("%.2f", $m[0][3])." | ".sprintf("%.2f", $m[1][3])." | ".sprintf("%.2f", $m[2][3])." | ".sprintf("%.2f", $m[3][3]));
		}
		function __destruct(){
			if (self::$verbose == true)
				print "Matrix instance destructed\n";
		}
		static function doc(){
			if (file_exists("Vector.doc.txt"))
				return file_get_contents("Vector.doc.txt");
		}
		function magnitude():float{
			return (sqrt($this->getX()**2 + $this->getY()**2 + $this->getZ()**2));
		}

		function mult(Matrix $rhs):Matrix{
            $res = new Matrix(array());
			for ($i = 0; $i < 4; $i++) {
				for ($j = 0; $j < 4; $j++) {
					$res->matrix[$i][$j] = 0;
					$res->matrix[$i][$j] += $this->matrix[0][$j] * $rhs->matrix[$i][0];
					$res->matrix[$i][$j] += $this->matrix[1][$j] * $rhs->matrix[$i][1];
					$res->matrix[$i][$j] += $this->matrix[2][$j] * $rhs->matrix[$i][2];
					$res->matrix[$i][$j] += $this->matrix[3][$j] * $rhs->matrix[$i][3];
				}
			}
			return $res;
		}
		function transformVertex(Vertex $vtx):Vertex{
			$m = $this->matrix;
			$vx = $vtx->getX();
			$vy = $vtx->getY();
			$vz = $vtx->getZ();
			$vw = $vtx->getW();
			if ($vw == NULL)
				$vw = 1;
			$tmp = array();
			$tmp['x'] = ($vx * $m[0][0]) + ($vy * $m[1][0]) + ($vz * $m[2][0]) + ($vw * $m[3][0]);
			$tmp['y'] = ($vx * $m[0][1]) + ($vy * $m[1][1]) + ($vz * $m[2][1]) + ($vw * $m[3][1]);
			$tmp['z'] = ($vx * $m[0][2]) + ($vy * $m[1][2]) + ($vz * $m[2][2]) + ($vw * $m[3][2]);
			$tmp['w'] = ($vx * $m[0][3]) + ($vy * $m[1][3]) + ($vz * $m[2][3]) + ($vw * $m[3][3]);
			$res = new Vertex($tmp);
			return $res;
		}
	}
?>
