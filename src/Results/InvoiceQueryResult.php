<?php

namespace Ashin33\QnApi\Results;

class InvoiceQueryResult extends QnResult
{
	public function getStatus()
	{
		return $this->getDataItem('status');
	}

	public function isWaiting()
	{
		return $this->getStatus() == 'waiting';
	}

	public function isToBeSent()
	{
		return $this->getStatus() == 'to_be_sent';
	}

	public function isSent()
	{
		return $this->getStatus() == 'sent';
	}

	public function isRefused()
	{
		return $this->getStatus() == 'refused';
	}

	public function getExpressNumber()
	{
		return $this->getDataItem('express_number');
	}

	public function getInvoiceImages()
	{
		return $this->getDataItem('invoice_images');
	}

	public function getAmount()
	{
		return $this->getDataItem('amount');
	}
}