<?php

namespace Ashin33\QnApi\Results;

class CreateTaskResult extends QnResult
{
    public function getTaskId()
    {
        return $this->getDataItem('id');
    }

    public function getTaxId()
    {
        return $this->getDataItem('tax_id');
    }

    public function getRemark()
    {
        return $this->getDataItem('remark');
    }

    public function getDescription()
    {
        return $this->getDataItem('description');
    }

    public function getName()
    {
        return $this->getDataItem('name');
    }

    public function getAmount()
    {
        return $this->getDataItem('amount');
    }
}