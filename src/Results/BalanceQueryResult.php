<?php

namespace Ashin33\QnApi\Results;

class BalanceQueryResult extends QnResult
{
	public function getBalance()
	{
		return $this->getDataItem('balance');
	}
}