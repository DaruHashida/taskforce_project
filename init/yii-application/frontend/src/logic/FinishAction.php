<?php
namespace src\logic;
	class FinishAction extends Action
	{ 
	public function getName() : string
		{ 
		return ('Завершить');
			}
	protected function getInnerName () : string
	{
		return('act_finish');
	}
	static function getUserProperties (int $user_id, object $obj):bool
	{
	return ($obj->host_id === $user_id);
	}
	}