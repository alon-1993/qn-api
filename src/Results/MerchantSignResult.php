<?php

namespace Ashin33\QnApi\Results;

class MerchantSignResult extends QnResult
{
	public function getFlowId()
	{
		return $this->getDataItem('flow_id');
	}
}