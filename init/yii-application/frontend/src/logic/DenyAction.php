<?php
	namespace src\logic;
	class DenyAction extends Action
	{ 
	public function getName() : string
		{ 
		return ('Провалено');
			}
	protected function getInnerName () : string
	{
		return('act_deny');
	}
	static function getUserProperties (int $user_id, object $obj):bool
	{
	return ($obj->performer_id === $user_id);
	}
	}