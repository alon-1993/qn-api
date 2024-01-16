<?php

namespace Ashin33\QnApi\tests;

use Ashin33\QnApi\QnApi;
use CURLFile;
use PHPUnit\Framework\TestCase;

class QnApiTest extends TestCase
{
	private static $api = null;
	private static $instId = 90000032;
	private static $secret = 'mM4vjeFL3Epj7y9ei3I5wNTLbCRMvgoD';

	private static $qnPubKey = __DIR__ . '/files/qn_pub.key';
	private static $merchantPriKey = __DIR__ . '/files/merchant_pri.key';

	private static $host = 'https://testapi.qingbotech.com/';

	private function uuid()
	{
		$chars = md5(uniqid(mt_rand(), true));
		return substr($chars, 0, 8)
			. substr($chars, 8, 4)
			. substr($chars, 12, 4)
			. substr($chars, 16, 4)
			. substr($chars, 20, 12);
	}

	private function getApi()
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

	public function testStringKey()
	{
		$qnPubKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzTehB7cozwQH0Ei4efGH1O5tiIePvrdsLHRRT3fBUjBIvcbN9+Rm7XX0DBg7biNXQMdjQDYo8W34VHnxcCtUQ5ebfvIxxIc5HU8OSNKHl0P2jDna6+U83vOODBXGDnK8qrSrHzXeTozLuSY2v3WwgOZH/z59U6qVe3D5Joc1uoSvQfKwRFIQZcQCPSDoCSRuAUgmUTlR1thu3rQkFS869VWLIS2MxNcpLdrUDfLkN2K0UlAT8h0gvEY3U3PYZEhRLPuUmGZ2ZEOQxCH/cR5+NbGmHCADqCWno3DMz+uhSJXn6UllnomziXwIJSjPRb6IaKKn3uz3kT92BJtBhFpsPwIDAQAB';
		$merchantPriKey = 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC4XjWBou6lyzEo0LiWQUxmQsa+z9cSl7cZl2fEY09vEuCo3Snzltro7nPCtcgRIrbUqGM2ETFoQdhc8G4WPrwULWm+YypaWmLWENRWYg6v1HsMw0S3X8Y43IMpln38uHylSBFXbNPsH3PsSQfVhyhBv/u+Crg+TqkvdWRx4r0VniwGAcShEN3Vy2p/f60IFsFDLcr0O3H9Ctnp/ieSA7T+5UPgsiIbj8Rn+NjQ/KoYoURce2G51MY1KC6a4PeJieKMH4T6znMZ8tJy/y+pTcCa+jnmYpSxij5MEOgH+pU3wR9tgSw3ykehujf0nfT9yij+3BKzb2O/WdfxGMkLK+rdAgMBAAECggEBAI3YBUhwhzTNCExDkNAg+ttuIqQpGWn3iWpJ/w6r7TAikO+6AA2lkVRGKI+z9XGhiJJB3tp5Dc8NYZ3XaIr6xw6rBcDxYGNVSNcy6XpwRKZoTic6kEKYj9Ota8fyPYnSkitDL/xYAQ+X/0LZyQoxyvoS72Z9rtRZBnc51QZ9kEXxNGCdaJQfRQernV623Z1z+695Kr3hZdbvjGsItAH004iWy1CozCf7L6UzKYLarbTuE+XptzAC6ztyeWHeuOv4CJ83/t5k0OAH+A9AQ0cifcyR+9sRiKvHvaVQ6kGA02wwCoQ+DO+TWGZ9vooCUqdDmC8T1L2HrOHNdthgAF8fAi0CgYEA7pu6owplNdJFZ5Sy9GsR2b7EFtghD4WdOjtVb+UIkZuLIYZW2nqSkdMrfkZHurfSiSH5Pnq/RX/PYgP7SSLV6Y87PxF8Ti2DLnAaSYE0eKvyHQw1C/gYt3ot/BtTav6Fo7AxrndEHUsBMDZtk5seri23Ev2KabUVVjncKWKT7zMCgYEAxc5kY/INOE87bnTs0V5P5Qbt7zGIjqrX8yEEtkLJPdqLPzWxc6o7pQKmQVfl1Mpj2d6q/mmQltvLFXdu1YST6W9ZnjfRFt7a8Vtk357FPiEVledd2G43gwbhQNrCpgHAOsO1xYFxYmMpSwxWtdUUTrUeN3JdasnFAObU7BDC/a8CgYAGqLfztuWOM/kV4/N+mMJdxlIopQ1/JmZ16pP+1HCBx8qBPAOOg181zKPpGUMFNf4dL6KKGNjfsqpx/NR1fRBlPUcVAoLql6CSmjRRmtaBC6NtJhsQ43KlJDbGU2jnkoTeRZuNV+zBuIcm9k3mkaywhbwXPpYvTwtyZZj8WrDwOwKBgQC/jvfDnoZU8M4iUxOAUrBWoJZNnQ+c8jA9oM06YIUY5IsTRME7vTETxPQStbe6keGO/UdlKABBSEts14O7PTAs0YvdYDqZxmoLcLHIqa5kU4/e4vgL//i8aC4+K1xzfaCWiC+BPLD8UgGMTz+tydNnwZioo5V6NDoXfHPYxQbAuwKBgFoBYuLsmJYEntHuakyTb19RVubYJ6KDaAUpnjzu/9n33lekthrIupCF5sfI5RwZ+AAEtyxhVLMsdAXHjnE6t6EoUdrIYT7aqgyMZUbRoLo+rW3OSYwNDCkB2bSao5r9su8771sCppbgObs+BT0E9pOwO/4X6dJnnqPAxGl2kPYX';
		$api = new QnApi(
			self::$instId,
			self::$secret,
			$qnPubKey,
			$merchantPriKey,
			self::$host
		);
		$data = [];
		try {
			$res = $api->taxSourceList($data);
			$this->assertTrue($res->isSuccess());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testRegister()
	{
		$data = [
			'customer_name' => '安安',
			'cert_no' => '130102200101027389',
			'customer_mobile' => '15664326907',
			'bank_card_no' => '6215696000007894390',
			'bank_phone' => '15664326907'
		];
		try {
			$res = $this->getApi()->register($data);
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
		$this->assertTrue($res->isSuccess());
	}

	public function testBatchRegister()
	{
		$data = [
			'batch_no' => $this->uuid(),
			'list' => [
				[
					'customer_name' => '景强',
					'cert_no' => '522629197305274100',
					'customer_mobile' => '15664326907',
					'bank_card_no' => '6215696000007894390'
				],
				[
					'customer_name' => '齐菊',
					'cert_no' => '211204198408071009',
					'customer_mobile' => '13454551544',
					'bank_card_no' => '6215696012307894390'
				]
			]
		];

		try {
			$res = $this->getApi()->batchRegister($data);
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
		$this->assertTrue($res->isSuccess());

	}

	public function testBatchRegisterQuery()
	{
		$data = [
			'batch_no' => '8bc8e902-3027-5dc3-075b-8877704f96ab'
		];

		try {
			$res = $this->getApi()->batchRegisterQuery($data);
			$this->assertTrue($res->isSuccess());
			$this->assertCount(2, $res->getData());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testIdCardUpload()
	{
		$data = [
			'customer_name' => '安安',
			'cert_no' => '130102200101027389',
			'id_front' => 'https://dev-test-1251913237.cos.ap-nanjing.myqcloud.com/local/61b7119eda11c_front.png',
			'id_back' => 'https://dev-test-1251913237.cos.ap-nanjing.myqcloud.com/local/61b711b490f8b_back.png',
		];

		try {
			$res = $this->getApi()->idCardUpload($data);
			$this->assertTrue($res->isSuccess());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testIdCardFileUpload()
	{
		$data = [
			'customer_name' => '安安',
			'cert_no' => '130102200101027389',
		];

		$idFront = new CURLFILE(__DIR__ . '/files/front.jpg');
		$idBack = new CURLFILE(__DIR__ . '/files/back.jpg');

		try {
			$res = $this->getApi()->idCardFileUpload($data, $idFront, $idBack);
			$this->assertTrue($res->isSuccess());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testFile()
	{
		$data = [
			'customer_name' => '安安',
			'cert_no' => '130102200101027389',
			'id_front' => 'https://dev-test-1251913237.cos.ap-nanjing.myqcloud.com/local/61b7119eda11c_front.png',
			'id_back' => 'https://dev-test-1251913237.cos.ap-nanjing.myqcloud.com/local/61b711b490f8b_back.png',
		];

		try {
			$res = $this->getApi()->idCardUpload($data);
			$this->assertTrue($res->isSuccess());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testCreateTask()
	{
		$data = [
			'tax_id' => 1,
			'name' => '产品营销需求',
			'description' => '我司在经营互联网推广业务过程中，需要自由职业者为我司提供以下服务：1.通过私域流量引流，带来客户转化;2.在公众号、抖音、小红书等多方媒体渠道增加公司产品曝光率;3.通过自发组织的活动为公司引流。',
			'remark' => '需求备注',
			'amount' => 99999.99,
		];

		try {
			$res = $this->getApi()->createTask($data);
			$this->assertTrue($res->isSuccess());
            echo 'task_id:' . $res->getTaskId(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testTaskList()
	{
		$data = [
			'tax_id' => 1,
			'limit' => 15,
			'page' => 1,
		];

		try {
			$res = $this->getApi()->taskList($data);
			$this->assertTrue($res->isSuccess());
			$this->assertSame(1, $res->getCurrentPage());
			$this->assertSame(15, $res->getPerPage());
			echo 'last_page:' . $res->getLastPage(), PHP_EOL;
			echo 'total:' . $res->getTotal(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testInvoiceCategoryList()
	{
		$data = [
			'invoice_category' => '现代服务*技术服务',
			'tax_id' => 1,
			'limit' => 15,
			'page' => 1,
		];

		try {
			$res = $this->getApi()->invoiceCategoryList($data);
			$this->assertTrue($res->isSuccess());
			$this->assertSame(1, $res->getCurrentPage());
			$this->assertSame(15, $res->getPerPage());
			echo 'last_page:' . $res->getLastPage(), PHP_EOL;
			echo 'total:' . $res->getTotal(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();

		}
	}

	public function testTaxSourceList()
	{
		$data = [
			'id' => 4,
		];

		try {
			$res = $this->getApi()->taxSourceList($data);
			$this->assertTrue($res->isSuccess());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testSettlement()
	{
		$data = [
			'batch_number' => $this->uuid(),
			'task_id' => 1078,
			'tax_id' => 4,
			'list' => [
				[
					'customer_name' => '景强',
					'cert_no' => '522629197305274100',
					'bank_card_no' => '6215696000007894390',
					'merchant_order_no' => $this->uuid(),
					'amount' => 11,
					'pay_remark' => '营销',
					'work_description' => '产品营销'
				], [
					'customer_name' => '齐菊',
					'cert_no' => '211204198408071009',
					'bank_card_no' => '6215696012307894390',
					'merchant_order_no' => $this->uuid(),
					'amount' => 12,
					'pay_remark' => '营销',
					'work_description' => '产品营销'
				]
			],
		];

		try {
			$res = $this->getApi()->settlement($data);
			$this->assertTrue($res->isSuccess());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testSettlementQuery()
	{
		$data = [
			'batch_number' => '9d63e3d12bddf02bb08fa25ba24bd955',
		];

		try {
			$res = $this->getApi()->settlementQuery($data);
			$this->assertTrue($res->isSuccess());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testSettlementSingleQuery()
	{
		$data = [
			'merchant_order_no' => '642b1e3ea26e76feaed7b56111d9edeb',
		];

		try {
			$res = $this->getApi()->settlementSingleQuery($data);
			$this->assertTrue($res->isSuccess());
			$this->assertTrue($res->isSettlementSuccess());
			echo 'status:' . $res->getStatus(), PHP_EOL;
			echo 'status_description:' . $res->getStatusDescription(), PHP_EOL;
			echo 'customer_name:' . $res->getCustomerName(), PHP_EOL;
			echo 'cert_no:' . $res->getCertNo(), PHP_EOL;
			echo 'bank_card_no:' . $res->getBankCardNo(), PHP_EOL;
			echo 'amount:' . $res->getAmount(), PHP_EOL;
			echo 'fee:' . $res->getFee(), PHP_EOL;
			echo 'send_at:' . $res->getSendAt(), PHP_EOL;
			echo 'pay_remark:' . $res->getPayRemark(), PHP_EOL;
			echo 'receipt_file_url:' . $res->getReceiptFleUrl(), PHP_EOL;
			echo 'work_hours:' . $res->getWorkHours(), PHP_EOL;
			echo 'work_description:' . $res->getWorkDescription(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testBalanceQuery()
	{
		$data = [
			'tax_id' => 4,
		];

		try {
			$res = $this->getApi()->balanceQuery($data);
			$this->assertTrue($res->isSuccess());
			echo $res->getBalance();
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testRechargeList()
	{
		$data = [
			'tax_id' => 4,
			'limit' => 15,
			'page' => 1
		];

		try {
			$res = $this->getApi()->rechargeList($data);
			$this->assertTrue($res->isSuccess());
			$this->assertSame(1, $res->getCurrentPage());
			$this->assertSame(15, $res->getPerPage());
			echo 'last_page:' . $res->getLastPage(), PHP_EOL;
			echo 'total:' . $res->getTotal(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testSettlementList()
	{
		$data = [
			'tax_id' => 4,
			'task_id' => 1078,
			'customer_name' => '景强',
			'cert_no' => '522629197305274100',
			'merchant_order_no' => '642b1e3ea26e76feaed7b56111d9edeb',
			'limit' => 15,
			'page' => 1
		];

		try {
			$res = $this->getApi()->settlementList($data);
			$this->assertTrue($res->isSuccess());
			$this->assertSame(1, $res->getCurrentPage());
			$this->assertSame(15, $res->getPerPage());
			echo 'last_page:' . $res->getLastPage(), PHP_EOL;
			echo 'total:' . $res->getTotal(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testInvoiceApply()
	{
		$data = [
			'batch_number' => [
				'9d63e3d12bddf02bb08fa25ba24bd955'
			],
			'invoice_type' => 'general_ticket',
			'merchant_address' => '上海市杨浦区三门路200号',
			'telephone' => '18186080625',
			'bank_card_no' => '6217909235101988567',
			'bank_name' => '中国银行',
			'addressee' => '小王',
			'phone' => '18201728000',
			'province' => '上海市',
			'city' => '上海市',
			'area' => '杨浦区',
			'address' => '上海市杨浦区三门路200号',
			'invoice_category_id' => 4
		];

		try {
			$res = $this->getApi()->invoiceApply($data);
			$this->assertTrue($res->isSuccess());
			$this->assertIsString($res->getApplyNumber());
			echo 'apply_number:' . $res->getApplyNumber();
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testInvoiceQuery()
	{
		$data = [
			'apply_number' => '20230612115439648696ff1ad17'
		];
		try {
			$res = $this->getApi()->invoiceQuery($data);
			$this->assertTrue($res->isSuccess());
			echo 'status:' . $res->getStatus(), PHP_EOL, PHP_EOL;
			$this->assertTrue($res->isRefused());

			$data = [
				'apply_number' => '2023061211071864868be6c3850'
			];
			$res = $this->getApi()->invoiceQuery($data);
			$this->assertTrue($res->isSuccess());
			echo 'status:' . $res->getStatus(), PHP_EOL, PHP_EOL;
			$this->assertTrue($res->isWaiting());

			$data = [
				'apply_number' => '2023061211241564868fdf16c47'
			];
			$res = $this->getApi()->invoiceQuery($data);
			$this->assertTrue($res->isSuccess());
			echo 'status:' . $res->getStatus(), PHP_EOL, PHP_EOL;
			$this->assertTrue($res->isToBeSent());

			$data = [
				'apply_number' => '2023061211201664868ef076f46'
			];
			$res = $this->getApi()->invoiceQuery($data);
			$this->assertTrue($res->isSuccess());
			echo 'status:' . $res->getStatus(), PHP_EOL;
			$this->assertTrue($res->isSent());
			echo 'express_number:' . $res->getExpressNumber(), PHP_EOL;
			echo 'amount:' . $res->getAmount(), PHP_EOL;
			var_dump($res->getInvoiceImages());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testMerchantApply()
	{
		$data = [
			'name' => '进件商户',
			'corporate_name' => '孟娟',
			'corporate_type' => 'id_card',
			'corporation_mobile' => '19814112421',
			'corporation_cert_no' => '54844520140718645x',
			'social_code' => uniqid('code_'),
			'registered_address' => '上海市杨浦区政立路',
			'office_address' => '上海市杨浦区政立路',
			'corporation_front' => 'http=>//dummyimage.com/250x250.jpg',
			'corporate_back' => 'http=>//dummyimage.com/120x600.jpg',
			'business_license_img' => 'http=>//dummyimage.com/125x125.jpg',
			'bank_card_no' => '4026586997190411',
			'bank_name' => '招商银行',
			'bank_branch_name' => '招商银行江湾支行',
			'bank_phone' => '18185128046',
			'office_front_img' => 'http=>//dummyimage.com/120x90.jpg',
			'office_img' => [
				'http=>//dummyimage.com/120x90.jpg',
				'http=>//dummyimage.com/728x90.jpg'
			],
			'other_img' => [
				'http=>//dummyimage.com/180x150.jpg',
				'http=>//dummyimage.com/125x125.jpg',
				'http=>//dummyimage.com/120x600.jpg',
				'http=>//dummyimage.com/336x280.jpg'
			],
			'contact_phone' => '18642231245',
			'contact_name' => '罗丽',
			'contact_email' => 'luo@qignbotech.com',
			'contact_cert_no' => '340302198206189122',
			'business_mode' => '业务模式说明,请简单描述下企业的主营业务或者结算的场景'
		];

		try {
			$res = $this->getApi()->merchantApply($data);
			$this->assertTrue($res->isSuccess());
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testMerchantQuery()
	{
		$data = [
			'social_code' => '33479519819874579X',
		];
		try {
			$res = $this->getApi()->merchantQuery($data);
			$this->assertTrue($res->isSuccess());
			echo $res->getStatus(), PHP_EOL;
			echo $res->getRemark(), PHP_EOL;
			echo $res->getInstId(), PHP_EOL;
			echo $res->getSecret(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testMerchantSign()
	{
		$data = [
			'tax_id' => 4,
			'sign_date' => '2022-08-04',
			'business' => '测试业务',
			'base_rate' => '0.65',
			'merchant_contact' => '罗丽',
			'office_address' => '上海市杨浦区政立路',
			'expiration_date' => '2042-01-01',
			'merchant_contact_phone' => '18642231245',
			'deduction_type' => 0,
			'effective_date' => '2022-01-01'
		];
		try {
			$res = $this->getApi()->merchantSign($data);
			$this->assertTrue($res->isSuccess());
			echo $res->getFlowId(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}

	public function testMerchantSignQuery()
	{
		$data = [
			'flow_id' => '3105766247908835533',
		];
		try {
			$res = $this->getApi()->merchantSignQuery($data);
			$this->assertTrue($res->isSuccess());
			$this->assertTrue($res->isTaxSigned());
			$this->assertTrue(!$res->isMerchantSigned());
			echo $res->getTaxSignStatus(), PHP_EOL;
			echo $res->getMerchantSignStatus(), PHP_EOL;
			echo $res->getFlowStatus(), PHP_EOL;
			echo $res->getAgreementUrl(), PHP_EOL;
		} catch (\Exception $e) {
			echo $e->getMessage();
			$this->fail();
		}
	}
}