<?php

namespace Ashin33\QnApi\Results;

class SettlementQueryResult extends QnResult
{
	public function getList()
	{
		return $this->getDataItem('list');
	}
}