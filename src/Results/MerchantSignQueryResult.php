<?php

namespace Ashin33\QnApi\Results;

class MerchantSignQueryResult extends QnResult
{
	public function getTaxSignStatus()
	{
		return $this->getDataItem('tax_sign_status');
	}

	public function getMerchantSignStatus()
	{
		return $this->getDataItem('merchant_sign_status');
	}

	public function isTaxSigned()
	{
		return $this->getTaxSignStatus() == 'signed';
	}

	public function isMerchantSigned()
	{
		return $this->getMerchantSignStatus() == 'signed';
	}

	public function getFlowStatus()
	{
		return $this->getDataItem('flow_status');
	}

	public function getAgreementUrl()
	{
		return $this->getDataItem('agreement_url');
	}
}