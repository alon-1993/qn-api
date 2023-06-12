<?php

namespace Ashin33\QnApi\Results;

class InvoiceApplyResult extends QnResult
{
	public function getApplyNumber()
	{
		return $this->getDataItem('apply_number');
	}
}