<?php
date_default_timezone_set(config('app.timezone'));
return [
    'url' => env('XINWANG_REQUEST_URL',''),
    'platformNo' => env('XINWANG_PLATFORMNO',''),
    'keySerial' => '1',
    'privateKey' => env('XINWANG_PRIVATE_KEY',''),
    'lmpublicKey' => env('XINWANG_LM_PUBLIC_KEY',''),
    'mock_callback' => [
        'url' => env('API_URL','').'/Sys/XinwangCallback',
        'appkey' => env('API_APP_KEY',''),
        'appsecret' => env('API_APP_SECRET',''),
    ],

    'gateway' => [ //数组中第一个值为请求的值，第二个值为是否必填，第三个值是否只读
        //账户接口
        'PERSONAL_REGISTER_EXPAND' => [
            'name' => '个人绑卡注册',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //流水号
            'realName' => [''], //姓名
            'idCardNo' => [''], //身份证号
            'bankcardNo' => [''], //银行卡号
            'mobile' => [''], //预留手机号
            'idCardType' => ['PRC_ID'], // 证件类型
            'userRole' => ['INVESTOR', 1], //用户角色
            'checkType' => ['LIMIT', 1], //鉴权验证类型
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], //回调地址
            'userLimitType' => ['ID_CARD_NO_UNIQUE', 0], //验证身份唯一性
            'authList' => [''], //用户授权列表
            'failTime' => [''], //授权期限
            'amount' => [''], //授权金额
            
        ],
        'ENTERPRISE_REGISTER' => [
            'name' => '企业绑卡注册',
            'requestNo' => ['', 1, 1], //请求流水号
            "platformUserNo" => ["xinwang_enterprise_0001", 1], //平台用户编号
            "enterpriseName" => ['北京沙小僧有限公司', 1], //企业名称
            "bankLicense" => ['', 1], //开户银行许可证号
            "orgNo" => [''], //组织机构代码
            "businessLicense" => [''], //营业执照编号
            "taxNo" => [''], //税务登记号
            "unifiedCode" => [''], //统一社会信用代码（可代替三证）
            "creditCode" => [''], //机构信用代码
            "legal" => ['张艺馨', 1], //法人姓名
            "idCardType" => ['PRC_ID', 1], //证件类型
            "legalIdCardNo" => ["100162190001013219", 1], //法人证件号
            "contact" => ['张艺馨', 1], //企业联系人
            "contactPhone" => ['13200551234', 1], //联系人手机号
            "userRole" => ['BORROWERS', 1, 1], // 企业角色
            "bankcardNo" => ['1234', 1], //企业对公账户后四位
            "bankcode" => ['CMBC', 1], //银行编码
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], //回调地址
            'authList' => [''], //用户授权列表
            'failTime' => [''], //授权期限
            'amount' => [''], //授权金额
        ],
        'PERSONAL_BIND_BANKCARD_EXPAND' => [
            'name' => '个人换绑卡',
            'requestNo' => ['', 1, 1], //请求流水号
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'mobile' => [''], //预留手机号
            'bankcardNo' => [''], //银行卡号
            'checkType' => ['LIMIT', 1], // 鉴权验证类型
            'bindType' => ['UPDATE_BANKCARD'], // 鉴权验证类型          
        ],
        'ENTERPRISE_BIND_BANKCARD' => [
            'name' => '企业绑卡',
            'requestNo' => ['', 1, 1], //请求流水号
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            'platformUserNo' => ['xinwang_enterprise_0001', 1], //平台用户编号
            'bankcardNo' => ['', 1], //银行账户号
            'bankcode' => ['CMBC', 1], //银行编码
            'bindType' => ['UPDATE_BANKCARD'], // 鉴权验证类型
        ],
    	'UNBIND_BANKCARD' => [
    		'name' => '解绑银行卡',
            'requestNo' => ['', 1, 1], //请求流水号   		
    		'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
    	],
    	'RESET_PASSWORD' => [
    		'name' => '修改密码',
    		'requestNo' => ['', 1, 1], //请求流水号
    		'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'isSkip' => ['Remember'], //变更类型
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
    	],
    	'CHECK_PASSWORD' => [
    		'name' => '验证密码',
            'requestNo' => ['', 1, 1], //请求流水号
    		'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
    		'bizTypeDescription' => ['验证密码测试', 1], //平台根据自定的业务描述
    		'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
    	],
    	'MODIFY_MOBILE_EXPAND' => [
    		'name' => '预留手机号更新',
    		'requestNo' => ['', 1, 1], //请求流水号
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'mobile' => [''], //预留手机号
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            'checkType' => ['LIMIT', 1], // 鉴权验证类型
            
    	],
    	'ENTERPRISE_INFORMATION_UPDATE' => [
            'name' => '企业信息修改',
            'requestNo' => ['', 1, 1], //请求流水号
            'platformUserNo' => ['xinwang_enterprise_0001', 1], //平台用户编号
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
        ],
        "ACTIVATE_STOCKED_USER" => [
            "name" => '会员激活',
            'requestNo' => ['', 1, 1], //请求流水号
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'authList' => [''], //用户授权列表
            'checkType' => ['LIMIT'], //鉴权验证类型
            'cardChange' => ['UNMOD'], //银行卡号是否可以修改
            'failTime' => [''], //授权期限
            'amount' => [''], //授权金额
        ],

        //充提接口（充值|提现）
        "RECHARGE" => [
            "name" => '充值',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //请求流水号
            "amount" => ['10000', 1], //充值金额
            "commission" => [''], //平台佣金
            "expectPayCompany" => ['YEEPAY', 1], //偏好支付公司
            "rechargeWay" => ['WEB', 1], //支付方式 支持网银（WEB）、快捷支付（SWIFT）
            "bankcode" => [''], //银行编码
            "payType" => [''], //【网银类型】，若支付方式填写为网银，且对【银行编码】进行了填写，则此处必填
            "authtradeType" => [''], //授权交易类型
            "authtenderAmount" => [''], //授权投标金额
            "projectNo" => [''], //标的号
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            "expired" => [date('YmdHis', time() + 1800), 1], //超过此时间 页面过期
            "callbackMode" => [''], //快捷充值回调模式
        ],
        "WITHDRAW" => [
            'name' => '提现',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //请求流水号
            "expired" => [date('YmdHis', time() + 1800), 1], //超过此时间 页面过期
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            'withdrawType' => ['NORMAL'], //提现方式 目前仅支持正常提现
            'withdrawForm' => [''], //提现类型，IMMEDIATE 为直接提现，CONFIRMED 为待确认提现，默认为直接提现方式
            "amount" => ['100', 1], //提现金额
            "commission" => [''], //提现分佣
        ],
        //交易接口
        'USER_PRE_TRANSACTION' => [
            'name' => '用户预处理',
            'requestNo' => ['', 1, 1], //请求流水号
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            "bizType" => ['TENDER', 1], //预处理业务类型
            "amount" => ['100', 1], //冻结金额
            "preMarketingAmount" => [''], //预备使用的红包金额，只记录不冻结，仅限投标业务类型
            "expired" => [date('YmdHis', time() + 300), 1], //超过此时间 页面过期
            "remark" => [""], //备注
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            "projectNo" => ['', 1], //标的号
            "share" => [''], //购买债转份额，业务类型为债权认购时，需要传此参数
            "creditsaleRequestNo" => [''], // 债权出让请求流水号，只有债权认购业务需填此参数
        ],
        "USER_AUTHORIZATION" => [
            "name" => "用户授权",
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //请求流水号
            "authList" => ['', 1], //用户授权列表
            'failTime' => [''], //授权期限
            'amount' => [''], //授权金额
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
        ],
        "VERIFY_DEDUCT" => [
            "name" => "验密扣费",
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //请求流水号
            "amount" => ['0.01', 1], //扣费金额
            "customDefine" => [''], //扣费说明
            "targetPlatformUserNo" => ['', 1], //收款方平台用户编号
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            "expired" => [date('YmdHis', time() + 1800), 1], //超过此时间 页面过期
        ],
    ],
    'direct' => [ //数组中第一个值为请求的值，第二个值为是否必填，第三个值是否只读
        //账户接口
        'CHANGE_USER_BANKCARD' => [
            'name' => '未激活换卡',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //流水号
            'bankcardNo' => ['',1], //银行卡号
        ],
        'DIRECT_RECHARGE' => [
            'name' => '自动充值',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //流水号
            'amount' => ['100',1], //充值金额
            'commission' => [''], //平台佣金
            'expectPayCompany' => ['YEEPAY',1], //偏好支付公司
            'rechargeWay' => ['PROXY',1], //支付方式
            'bankcode' => [''], //银行卡号
        ],
        'CONFIRM_WITHDRAW' => [
            'name' => '提现确认',
            'requestNo' => ['', 1, 1], //流水号
            'preTransactionNo' => ['',1], //待确认提现请求流水号
            'withdrawType' => ['NORMAL'], //提现方式 目前仅支持正常提现
        ],
        'CANCEL_WITHDRAW' => [
            'name' => '提现取消',
            'requestNo' => ['', 1, 1], //流水号
            'preTransactionNo' => ['',1], //待确认提现请求流水号
        ],
        'AUTO_WITHDRAW' => [
            'name' => '自动提现',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //流水号
            'amount' => ['100',1], //充值金额
            'withdrawType' => ['NORMAL',1], //提现方式
            'commission' => [''], //提现分佣
        ],
        'INTERCEPT_WITHDRAW' => [
            'name' => '提现拦截',
            'requestNo' => ['', 1, 1], //流水号
            'withdrawRequestNo' => ['',1], //提现请求流水号
        ],
        'ESTABLISH_PROJECT' => [
            'name' => '创建标的',
            'platformUserNo' => ['xinwang_enterprise_0001', 1], //借款方平台用户编号
            'requestNo' => ['', 1, 1], //流水号
            'projectNo' => ['CY2017050001',1], //标的号
            'projectAmount' => ['100000',1], //标的金额
            'projectName' => ['四方化缘',1], //标的名称
            'projectDescription' => ['测试标的'], //标的描述
            'projectType' => ['STANDARDPOWDER',1], //标的类型
            'projectPeriod' => ['30'], //标的期限（单位：天）
            'annnualInterestRate' => ['0.12',1], //年化利率
            'repaymentWay' => ['FIRSEINTREST_LASTPRICIPAL',1], //还款方式
            'extend' => [''], //标的扩展信息
        ],
        'MODIFY_PROJECT' => [
            'name' => '变更标的',
            'requestNo' => ['', 1, 1], //流水号
            'projectNo' => ['CY2017050001',1], //标的号
            'status' => ['REPAYING',1], //更新标的状态
        ],
        'CANCEL_PRE_TRANSACTION' => [
            'name' => '预处理取消',
            'requestNo' => ['', 1, 1], //流水号
            'preTransactionNo' => ['',1], //预处理业务流水号
            'amount' => ['',1], //取消金额
        ],
        'SYNC_TRANSACTION' => [
            'name' => '单笔交易',
            'requestNo' => ['', 1, 1], //流水号
            'tradeType' => ['TENDER',1], //交易类型
            'projectNo' => [''], //标的号
            'saleRequestNo' => [''], //债权出让请求流水号
            'details[0][bizType]' => ['TENDER',1], //业务类型
            'details[0][freezeRequestNo]' => [''],//预处理请求流水号
            'details[0][sourcePlatformUserNo]' => [''], //出款方用户编号
            'details[0][targetPlatformUserNo]' => [''], //收款方用户编号
            'details[0][amount]' => ['100',1], //交易金额（有利息时为本息和）
            'details[0][income]' => [''], //利息
            'details[0][share]' => [''], //债权份额（债权认购且需校验债权关系的必传）
            'details[0][customDefine]' => [''], //平台商户自定义参数，平台交易时传入的自定义参数
            'details[0][remark]' => [''], //备注
        ],
        'ASYNC_TRANSACTION' => [
            'name' => '批量交易',
            'batchNo' => ['', 1], //流水号
            'bizDetails[0][requestNo]' => ['',1], //交易明细订单号
            'bizDetails[0][tradeType]' => ['TENDER',1],//交易类型
            'bizDetails[0][projectNo]' => [''],//标的编号
            'bizDetails[0][saleRequestNo]' => [''], //债权出让请求流水号
            'bizDetails[0][details][0][bizType]' => ['TENDER',1], //业务类型
            'bizDetails[0][details][0][freezeRequestNo]' => [''],//预处理请求流水号
            'bizDetails[0][details][0][sourcePlatformUserNo]' => [''], //出款方用户编号
            'bizDetails[0][details][0][targetPlatformUserNo]' => [''], //收款方用户编号
            'bizDetails[0][details][0][amount]' => ['100',1], //交易金额（有利息时为本息和）
            'bizDetails[0][details][0][income]' => [''], //利息
            'bizDetails[0][details][0][share]' => [''], //债权份额（债权认购且需校验债权关系的必传）
            'bizDetails[0][details][0][customDefine]' => [''], //平台商户自定义参数，平台交易时传入的自定义参数
            'bizDetails[0][details][0][remark]' => [''], //备注
        ],
        'DEBENTURE_SALE' => [
            'name' => '单笔债权出让',
            'requestNo' => ['', 1, 1], //流水号
            'platformUserNo' => ['xinwang_personal_0001', 1], //债权出让平台用户编号
            'projectNo' => ['CY2017050001',1], //标的号
            'saleShare' => ['10',1], //出让份额
        ],
        'CANCEL_DEBENTURE_SALE' => [
            'name' => '取消债权出让',
            'requestNo' => ['', 1, 1], //流水号
            'creditsaleRequestNo' => ['', 1], //债权出让请求流水号
        ],
        'CANCEL_USER_AUTHORIZATION' => [
            'name' => '取消用户授权',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //流水号
            'authList' => ['TENDER',1], //用户授权列表
        ],
        'USER_AUTO_PRE_TRANSACTION' => [
            'name' => '授权预处理',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //流水号
            'originalRechargeNo' => [''], //关联充值请求流水号（原充值成功请求流水号）
            "bizType" => ['TENDER', 1], //预处理业务类型
            "amount" => ['100', 1], //冻结金额
            "preMarketingAmount" => [''], //预备使用的红包金额，只记录不冻结，仅限投标业务类型
            "remark" => [""], //备注
            'redirectUrl' => [env('XINWANG_REDIRECT_URL',''), 1], // 页面回调URL
            "projectNo" => ['', 1], //标的号
            "share" => [''], //购买债转份额，业务类型为债权认购时，需要传此参数
            "creditsaleRequestNo" => [''], // 债权出让请求流水号，只有债权认购业务需填此参数
        ],
        'FREEZE' => [
            'name' => '资金冻结',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //流水号
            'amount' => ['100',1], //冻结金额
        ],
        'UNFREEZE' => [
            'name' => '资金解冻',
            'requestNo' => ['', 1, 1], //流水号
            'originalFreezeRequestNo' => ['', 1], //原冻结的请求流水号
            'amount' => ['100',1], //解冻金额
        ],
        'UNFREEZE_TRADE_PASSWORD' => [
            'name' => '交易密码解冻',
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'requestNo' => ['', 1, 1], //流水号
        ],
        'CONFIRM_CHECKFILE' => [
            'name' => '对账文件确认',
            'requestNo' => ['', 1, 1], //流水号
            'fileDate' => ['20170509', 1], //对账文件日期
            'detail[0][fileType]' => ['RECHARGE', 1, 1], //
            'detail[1][fileType]' => ['WITHDRAW', 1, 1], //流水号
            'detail[2][fileType]' => ['COMMISSION', 1, 1], //流水号
            'detail[3][fileType]' => ['TRANSACTION', 1, 1], //流水号
            'detail[4][fileType]' => ['BACKROLL_RECHARGE', 1, 1], //流水号
        ],
        'QUERY_USER_INFORMATION' => [
            'name' => '用户信息查询',
            'platformUserNo' => ['', 1], //平台用户编号
        ],
        'QUERY_TRANSACTION' => [
            'name' => '单笔交易查询',
            'requestNo' => ['', 1], //流水号
            'transactionType' => ['RECHARGE', 1], //交易类型
        ],
        'QUERY_PROJECT_INFORMATION' => [
            'name' => '标的信息查询',
            'projectNo' => ['CY2017050001', 1], //标的号
        ],
        'AUTHORIZATION_ENTRUST_PAY' => [
            'name' => '委托支付授权',
            'borrowPlatformUserNo' => ['xinwang_enterprise_0001', 1], //标的号
            'requestNo' => ['', 1], //请求流水号
            'projectNo' => ['CY2017050001', 1], //标的号
            'checkType' => ['LIMIT', 1], //鉴权验证类型
            'entrustedType' => ['ENTERPRISE', 1], //受托方类型， 枚举值 PERSONAL（个人）， ENTERPRISE（企业）
            'entrustedPlatformUserNo' => ['xinwang_enterprise_0002', 1], //受托方平台用户编号
        ],
        'QUERY_AUTHORIZATION_ENTRUST_PAY_RECORD' => [
            'name' => '委托支付授权记录查询',
            'requestNo' => ['', 1], //请求流水号
        ],
    ],

    'download' => [ //数组中第一个值为请求的值，第二个值为是否必填，第三个值是否只读
        //对账文件下载
        'DOWNLOAD_CHECKFILE' => [
          'name' => '对账文件下载',
          'fileDate' => ['', 1],
        ],
    ],
    'recharge' => [ //数组中第一个值为请求的值，第二个值为是否必填，第三个值是否只读
        //账户接口
        'RECHARGE' => [
            'name' => '充提接口',
            'requestNo' => ['', 1], //请求流水号
            'platformUserNo' => ['xinwang_personal_0001', 1], //平台用户编号
            'amount' => ['',1], //充值金额
            'rechargeWay' => ['VIRTUAL_CARDS', 1], //充值方式
            'payCompany' => ['XW', 1], //支付公司
            'transactionTime' => ['', 1], //交易时间
            'rechargeStatus' => ['SUCCESS', 1], //交易状态
            'commission' => ['0', 1], //佣金
            'code' => ['0', 1], // 调用状态
            'status' => ['SUCCESS', 1], //业务处理状态
            
        ]
    ]
];
