<?php

namespace Ashin33\QnApi\Results;

class SettlementNotifyResult extends QnResult
{
	public function getList()
	{
		return $this->getDataItem('list');
	}
}