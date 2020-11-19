<?php
class UnholyFactory {
	private $absorbed = array();

	public function absorb($type) {
		if (!is_subclass_of($type, 'Fighter'))
		{
			echo "(Factory can't absorb this, it's not a fighter)\n";
			return;
		}
		foreach ($this->absorbed as $a_type)
			if ($a_type->type == $type->type)
			{
				echo "(Factory already absorbed a fighter of type ".$type->type.")\n";
				return;
			}
		$this->absorbed[] = $type;
		echo "(Factory absorbed a fighter of type ".$type->type.")\n";
	}
	public function fabricate($type) {
		$valid = NULL;
		foreach ($this->absorbed as $a_type)
			if ($a_type->type === $type)
				$valid = $a_type;
		if ($valid === NULL)
			echo "(Factory hasn't absorbed any fighters of type ".$type.")\n";
		else
			echo "(Factory fabricates a fighter of type ".$type.")\n";
		return $valid;
	}
}
?>
