<?php

namespace Ashin33\QnApi\Results;

class QnResult
{
	protected $res;
	public function __construct($res)
	{
		$this->res = $res;
	}

	public function getCode()
	{
		return $this->res['code'];
	}

	public function getReason()
	{
		return $this->res['msg'];
	}

	public function getData()
	{
		return json_decode($this->res['data'], true);
	}

	public function isSuccess()
	{
		return $this->getCode() == 200;
	}
}