<?php

namespace Ashin33\QnApi\Results;

class RefundNotifyResult extends QnResult
{
    public function getBatchNumber()
    {
        return $this->getDataItem('batch_number');
    }

    public function getMerchantOrderNo()
    {
        return $this->getDataItem('merchant_order_no');
    }

    public function getCustomerName()
    {
        return $this->getDataItem('customer_name');
    }

    public function getCertNo()
    {
        return $this->getDataItem('cert_no');
    }

    public function getBankCardNo()
    {
        return $this->getDataItem('bank_card_no');
    }

    public function getAmount()
    {
        return $this->getDataItem('amount');
    }

    public function getFee()
    {
        return $this->getDataItem('fee');
    }

    public function getStatus()
    {
        return $this->getDataItem('status');
    }

    public function getStatusDescription()
    {
        return $this->getDataItem('status_description');
    }

    public function getSendAt()
    {
        return $this->getDataItem('send_at');
    }

    public function getWorkDescription()
    {
        return $this->getDataItem('work_description');
    }

    public function getWorkHours()
    {
        return $this->getDataItem('work_hours');
    }

    public function getPayRemark()
    {
        return $this->getDataItem('pay_remark');
    }
}