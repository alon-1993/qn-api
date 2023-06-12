<h1 align="center"> qn-api SDK</h1>

<p align="center"> 清宁云服api接口SDK</p>


## 安装

```shell
$ composer require ashin33/qn-api -vvv
```

## 用法

### 实例化api
```php
$host = '清宁云服分配的实际请求域名';
$qnPublicKey = '***.key';//清波公钥
$merchantPrivateKey = '***.key';//商户私钥
$instId = '********';//清波分配的商户id
$secret = '*************************';//清波分配的秘钥
$api = new Ashin33\QnApi\QnApi($instId, $secret, $qnPublicKey, $merchantPrivateKey);
````

### 普通接口(以自由职业者注册接口为例)
```php
$data = [
    "customer_name" => "安*",
    "cert_no" => "1301****7389",
    "customer_mobile" => "156****6907",
    "bank_card_no" => "6215****4390",
    "bank_phone" => "156****6907"
];
$url = $host.'customers';
$res = $api->request($url, $data);
var_dump($res);
````

### 带附件的接口(以身份证信息上传接口为例)
```php
$data = [
    "customer_name" => "安*",
    "cert_no" => "1301****7389",
];
$extra = [
    'id_front' => new CURLFILE(__DIR__.'/file/front.png'),
    'id_back' => new CURLFILE(__DIR__.'/file/back.png'),
];
$url = $host.'identity_cards/file_upload';
$res = $api->request($url, $data, $extra);
var_dump($res);
````

## 可用方法

|         方法名称          |     中文名称      |           说明            |
|:---------------------:|:-------------:|:-----------------------:|
|        request        |     发送请求      |  加密请求参数并请求清宁云服,并解密返回参数  |
|        decrypt        |     解密返回      | 解密清宁云服返回参数,同样适用于异步回调的解密 |
|       register        |    ⾃由职业者注册    |                         |
|     batchRegister     |   ⾃由职业者批量注册   |                         |
|  batchRegisterQuery   |  ⾃由职业者批量注册查询  |                         |
|     idCardUpload      |    个⼈身份证上传    |                         |
|   idCardFileUpload    | 个⼈身份证上传<表单文件> |                         |
|      createTask       |    新建任务需求     |                         |
|       taskList        |    任务需求查询     |                         |
|  invoiceCategoryList  |    发票类目查询     |                         |
|     taxSourceList     |     税源地查询     |                         |
|      settlement       |     上传结算单     |                         |
|    settlementQuery    |     结算查询      |                         |
| settlementSingleQuery |    结算单笔查询     |                         |
|     balanceQuery      |     余额查询      |                         |
|     rechargeList      |    充值流水查询     |                         |
|    settlementList     |    结算流水查询     |                         |
|     invoiceApply      |     开票申请      |                         |
|     invoiceQuery      |    开票申请查询     |                         |
|     merchantApply     |     商户进件      |                         |
|     merchantQuery     |    商户进件查询     |                         |
|     merchantSign      |   发送企业签约短信    |                         |
|   merchantSignQuery   |     签约查询      |                         |

## 更新

```shell
$ composer update ashin33/qn-api
```

## 贡献

您可以通过以下三种方式之一做出贡献:

1. 使用 [issue tracker](https://github.com/ashin33/qn-api/issues) 上报bug.
2. 在 [issue tracker](https://github.com/ashin33/qn-api/issues) 中回复问题或bug.
3. 贡献新功能或更新 wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## 证书

MIT
