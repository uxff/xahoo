<?php

class Factory {
	
	public static function Create( $class )
	{	
		return new $class();
	}
}

?>