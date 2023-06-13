<?php

namespace Ashin33\QnApi\Results;

class QnResult
{
	protected $code;
	protected $msg;
	protected $data;
	public function __construct($res)
	{
		$this->code = $res['code'];
		$this->msg = $res['msg'];
		$this->data = is_string($res['data']) ? json_decode($res['data'], true) : null;
	}

	public function toJsonString()
	{
		return json_encode([
			'code' => $this->code,
			'msg' => $this->msg,
			'data' => $this->data
		], JSON_UNESCAPED_UNICODE);
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getReason()
	{
		return $this->msg;
	}

	public function getData()
	{
		return $this->data;
	}

	public function isSuccess()
	{
		return $this->getCode() == 200;
	}

	public function isFail()
	{
		return $this->getCode() != 200;
	}

	public function getDataItem($item)
	{
		$data = $this->getData();
		return isset($data[$item]) ? $data[$item] : null;
	}
}