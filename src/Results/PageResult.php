<?php

namespace Ashin33\QnApi\Results;

class PageResult extends QnResult
{
	public function getList()
	{
		return $this->getDataItem('data');
	}

	public function getCurrentPage()
	{
		return $this->getDataItem('current_page');
	}

	public function getLastPage()
	{
		return $this->getDataItem('last_page');
	}

	public function getPerPage()
	{
		return $this->getDataItem('per_page');
	}

	public function getTotal()
	{
		return $this->getDataItem('total');
	}
}