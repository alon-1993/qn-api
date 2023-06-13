<?php

namespace Ashin33\QnApi\Facades;

use Ashin33\QnApi\Results\BalanceQueryResult;
use Ashin33\QnApi\Results\InvoiceApplyResult;
use Ashin33\QnApi\Results\InvoiceQueryResult;
use Ashin33\QnApi\Results\MerchantQueryResult;
use Ashin33\QnApi\Results\MerchantSignQueryResult;
use Ashin33\QnApi\Results\MerchantSignResult;
use Ashin33\QnApi\Results\PageResult;
use Ashin33\QnApi\Results\QnResult;
use Ashin33\QnApi\Results\SettlementQueryResult;
use Ashin33\QnApi\Results\SettlementSingleQueryResult;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Ashin33\QnApi\QnApi
 * 
 * @method static array request(string $url, array $data,array $extra = [])
 * @method static array decrypt(array $response)
 * @method static QnResult register(array $data)
 * @method static QnResult batchRegister(array $data)
 * @method static QnResult batchRegisterQuery(array $data)
 * @method static QnResult idCardUpload(array $data)
 * @method static QnResult idCardFileUpload(array $data, $idFrontFile, $idBackFile)
 * @method static QnResult createTask(array $data)
 * @method static PageResult taskList(array $data)
 * @method static PageResult invoiceCategoryList(array $data)
 * @method static QnResult taxSourceList(array $data)
 * @method static QnResult settlement(array $data)
 * @method static SettlementQueryResult settlementQuery(array $data)
 * @method static SettlementSingleQueryResult settlementSingleQuery(array $data)
 * @method static BalanceQueryResult balanceQuery(array $data)
 * @method static PageResult rechargeList(array $data)
 * @method static PageResult settlementList(array $data)
 * @method static InvoiceApplyResult invoiceApply(array $data)
 * @method static InvoiceQueryResult invoiceQuery(array $data)
 * @method static QnResult merchantApply(array $data)
 * @method static MerchantQueryResult merchantQuery(array $data)
 * @method static MerchantSignResult merchantSign(array $data)
 * @method static MerchantSignQueryResult merchantSignQuery(array $data)
 */
class QnApi extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'qn-api';
    }
}
