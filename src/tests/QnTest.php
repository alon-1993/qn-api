<?php

namespace Ashin33\QnApi\tests;

use App\Modules\BenBen\BenBenApi;
use Ashin33\QnApi\Exceptions\SignException;
use Ashin33\QnApi\QnApi;
use PHPUnit\Framework\TestCase;

class QnTest extends TestCase
{
	private static $api = null;
	private static $instId = 90000032;
	private static $secret = 'mM4vjeFL3Epj7y9ei3I5wNTLbCRMvgoD';

	private static $qnPubKey = __DIR__ . '/qn_pub.key';
	private static $merchantPriKey = __DIR__ . '/merchant_pri.key';

	private static $host = 'https://testapi.qingbotech.com/';

	public function getApi()
	{
		if (!(self::$api instanceof QnApi)) {
			self::$api = new QnApi(
				self::$instId,
				self::$secret,
				self::$qnPubKey,
				self::$merchantPriKey,
				self::$host
			);
		}
		return self::$api;
	}

	public function testRegister()
	{
		$post = [
			"customer_name" => "安安",
			"cert_no" => "130102200101027389",
			"customer_mobile" => "15664326907",
			"bank_card_no" => "6215696000007894390",
			"bank_phone" => "15664326907"
		];

		try {
			$res = $this->getApi()->register($post);
			$this->assertSame(200, $res->getCode());
		} catch (\Exception $e) {
			$this->expectException(SignException::class);
		}
	}
}