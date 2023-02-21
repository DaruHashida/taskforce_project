<?php
	namespace src\logic;

	class CancelAction extends Action
	{ 
	public function getName() : string
		{ 
		return ('Отменить');
			}
	protected function getInnerName () : string
	{
		return('act_cancel');
	}
	static function getUserProperties (int $user_id, object $obj):bool
	{
	return ($obj->host_id === $user_id);
	}
	}