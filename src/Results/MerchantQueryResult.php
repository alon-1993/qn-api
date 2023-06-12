<?php

namespace Ashin33\QnApi\Results;

class MerchantQueryResult extends QnResult
{
	public function getStatus()
	{
		return $this->getDataItem('status');
	}

	public function getRemark()
	{
		return $this->getDataItem('remark');
	}

	public function getInstId()
	{
		return $this->getDataItem('inst_id');
	}

	public function getSecret()
	{
		return $this->getDataItem('secret');
	}
}