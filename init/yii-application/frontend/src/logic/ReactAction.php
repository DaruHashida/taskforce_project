<?php
	namespace src\logic;
	class ReactAction extends Action
	{ 
	public function getName() : string
		{ 
		return ('Откликнуться');
			}
	protected function getInnerName () : string
	{
		return('act_react');
	}
	static function getUserProperties (int $user_id, object $obj):bool
	{
	return ($obj->host_id != $user_id);
	}
	}
	