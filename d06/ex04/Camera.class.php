<?php
	require_once 'Vertex.class.php';
	require_once 'Vector.class.php';
	require_once 'Matrix.class.php';

	class Camera {
		private $origin;
		private $orientation;
		private $width;
		private $height;
		private $ratio;
		private $fov;
		private $near;
		private $far;

		private $T;
		private $tT;
		private $tR;
		private $tRt;
		private $proj;

		static $verbose = false;

		function __construct(array $arr){
			if (isset($arr['origin']))
				$this->origin = $arr['origin'];
			if ($arr['orientation'])
				$this->orientation = $arr['orientation'];
			if ($arr['width'])
				$this->width = $arr['width'];
			if ($arr['height'])
				$this->height = $arr['height'];
			if ($arr['ratio'])
				$this->ratio = $arr['ratio'];
			else
				$this->ratio = $arr['width'] / $arr['height'];
			if ($arr['fov'])
				$this->fov = $arr['fov'];
			if ($arr['near'])
				$this->near = $arr['near'];
			if ($arr['far'])
				$this->far = $arr['far'];

			$ovec = new Vector(array('dest' => $this->origin));
			$this->T = $ovec->opposite();
			$this->tT = new Matrix(array('preset' => Matrix::TRANSLATION, 'vtc' => $this->T));
				
			$this->tR = $this->orientation->rot();

			$this->tRt = $this->tR->mult($this->tT);
			$this->proj = new Matrix(array( 
					'preset' => Matrix::PROJECTION,
					'fov' => $this->fov,
					'ratio' => $this->ratio,
					'near' => $this->near,
					'far' => $this->far));
			echo "Camera instance constructed\n";
		}
		function __toString():string{
			return("Camera(
+ Origine:\n".sprintf($this->origin)."
+ tT:\n".sprintf($this->tT)."
+ tR:\n".sprintf($this->tR)."
+ tR->mult( tT ):\n".sprintf($this->tRt)."
+ Proj:\n".sprintf($this->proj).")");
		}
		function __destruct(){
			if (self::$verbose == true)
				print "Matrix instance destructed\n";
		}
		static function doc(){
			if (file_exists("Camera.doc.txt"))
				echo file_get_contents("Camera.doc.txt");
		}
		public function watchVertex(Vertex $worldVertex):Vertex{

		}
	}
?>
