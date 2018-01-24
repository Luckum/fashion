<?php

class Quickbooks
{
    public $dataService;
    public $serviceContext;
    public $requestValidator;
    public $realmId;
    public $demo = false;

    public function __construct($demo = false)
    {
        $this->demo = $demo;
        require_once('QBApi/config.php');

        require_once(PATH_SDK_ROOT . 'Core/ServiceContext.php');
        require_once(PATH_SDK_ROOT . 'DataService/DataService.php');
        require_once(PATH_SDK_ROOT . 'PlatformService/PlatformService.php');
        require_once(PATH_SDK_ROOT . 'Utility/Configuration/ConfigurationManager.php');

        $qbAuth = QuickbooksAuth::model()->find();
        $this->realmId = $qbAuth->realm_id;
        //Specify QBO or QBD
        $serviceType = $qbAuth->service_type;

        $this->requestValidator = new OAuthRequestValidator($qbAuth->access_token,
                                                      $qbAuth->access_token_secret,
                                                      Yii::app()->params['quickBooks']['auth_key'],
                                                      Yii::app()->params['quickBooks']['auth_secret']);
        $this->serviceContext = new ServiceContext($qbAuth->realm_id, $serviceType, $this->requestValidator);

        if ($this->demo)
            $this->serviceContext->baseserviceURL = "https://sandbox-quickbooks.api.intuit.com/v3/";

        if (!$this->serviceContext)
            exit("Problem while initializing ServiceContext.\n");

        // Prep Data Services
        $this->dataService = new DataService($this->serviceContext);
        if (!$this->dataService)
            exit("Problem while initializing DataService.\n");
    }

    public function prepareData($order_id) {
        $order = Order::model()->findByPk($order_id);
        $orderItemsBySeller = $result = array();

        $result['shipping'] = ShippingRate::model()->getShippingRate($order->user->id, $order->id);
        $result['order_id'] = $order->id;
        $result['vendor_id'] = $order->user->qb_user_id;
        foreach ($order->orderItems as $item) {
            $orderItemsBySeller[$item->product->user->id][] = $item;
            $result[$item->product->user->id]['amount'] = 0;
            $result[$item->product->user->id]['tax'] = 0;
            $result[$item->product->user->id]['comission'] = 0;
            $result[$item->product->user->id]['description'] = "OrderId: {$order->id}, SellerId: {$item->product->user->id}";
        }

        foreach ($orderItemsBySeller as $seller_id => $items) {
            foreach ($items as $key => $value) {
                $result[$seller_id]['amount'] += $value->price;
                $result[$seller_id]['comission'] += $value->price * $item->comission_rate;
            }
        }

        return $result;
    }

    public function getCustomer($id = null)
    {
        if (!$id) {
            $query = "SELECT * FROM Vendor";
        } else {
            $query = "SELECT * FROM Vendor WHERE Id = '" . $id . "'";
        }

        $entities = $this->dataService->Query($query);

        return $entities;
    }
    public function addCustomer($username)
    {
        // Add a customer
        $customerObj = new IPPCustomer();
        $customerObj->DisplayName = $username;

        $resultingCustomerObj = $this->dataService->Add($customerObj);

        return $resultingCustomerObj;
    }
    public function getBills()
    {
        $entities = $this->dataService->Query("select * from bill");

        return $entities;
    }

    public function getAccounts()
    {
        $entities = $this->dataService->Query(
            "SELECT * FROM Account"
        );

        return $entities;
    }

    public function createAccount() {
        $entities = $this->dataService->Query(
            "SELECT * FROM Account WHERE AccountSubType='TaxesPaid' AND Name='Taxes Paid'"
        );
        if (!$entities) {
            $accountObj = new IPPAccount();
            $accountObj->Name = 'Taxes Paid';
            $accountObj->AccountSubType = 'TaxesPaid';

            $this->dataService->Add($accountObj);
        }

        $entities = $this->dataService->Query(
            "SELECT * FROM Account WHERE AccountSubType='SalesOfProductIncome' AND Name='Sales Of Product Income'"
        );
        if (!$entities) {
            $accountObj = new IPPAccount();
            $accountObj->Name = 'Sales Of Product Income';
            $accountObj->AccountSubType = 'SalesOfProductIncome';

            $this->dataService->Add($accountObj);
        }

        $entities = $this->dataService->Query(
            "SELECT * FROM Account WHERE AccountSubType='ShippingFreightDelivery' AND Name='Shipping Freight Delivery'"
        );
        if (!$entities) {
            $accountObj = new IPPAccount();
            $accountObj->Name = 'Shipping Freight Delivery';
            $accountObj->AccountSubType = 'ShippingFreightDelivery';

            $this->dataService->Add($accountObj);
        }
    }

    public function createBill($payments)
    {
        // Query to find an expense account to attribute this expense to
        $AccountArray=array();
        $AccountArray['Revenue'] = $this->dataService->Query("SELECT * FROM Account WHERE AccountSubType='SalesOfProductIncome'");
        $AccountArray['Expense']['ShippingFreightDelivery'] = $this->dataService->Query("SELECT * FROM Account WHERE AccountSubType='ShippingFreightDelivery'");
        $AccountArray['Expense']['TaxesPaid'] = $this->dataService->Query("SELECT * FROM Account WHERE AccountSubType='TaxesPaid'");
        if (!$AccountArray['Expense']['ShippingFreightDelivery']
            || !$AccountArray['Expense']['TaxesPaid'] 
            || !$AccountArray['Revenue']
            )
            return NULL;
        $taxesAccountId = $AccountArray['Expense']['TaxesPaid'][0]->Id;
        $shippingAccountId = $AccountArray['Expense']['ShippingFreightDelivery'][0]->Id;
        $revenueAccountId = $AccountArray['Revenue'][0]->Id;

        // Query to find an Vendor to attribute this bill to
        $VendorArray = $this->dataService->Query("SELECT * FROM Vendor WHERE Id = '" . $payments['vendor_id'] . "'");
        if (!$VendorArray)
            return NULL;
        $vendorId = $VendorArray[0]->Id;

        $lines = array();
        foreach ($payments as $payment) {
            if (is_array($payment)) {
                // Create lines                 
                $RevenueLine = new IPPLine(
                    array('Description'=>'Sales Of Product Income. '.$payment['description'],
                          'Amount'     =>$payment['amount'],
                          'DetailType' =>'AccountBasedExpenseLineDetail',
                          'AccountBasedExpenseLineDetail'=>
                            new IPPAccountBasedExpenseLineDetail(
                                array('AccountRef'=>
                                    new IPPReferenceType(array('value'=>$revenueAccountId))
                                )
                            ),
                    )
                );

                $TaxesLine = new IPPLine(
                    array('Description'=>'Taxes Paid. '.$payment['description'],
                          'Amount'     =>$payment['comission'],
                          'DetailType' =>'AccountBasedExpenseLineDetail',
                          'AccountBasedExpenseLineDetail'=>
                            new IPPAccountBasedExpenseLineDetail(
                                array('AccountRef'=>
                                    new IPPReferenceType(array('value'=>$taxesAccountId))
                                )
                            ),
                    )
                );
                $lines[] = $RevenueLine;
                $lines[] = $TaxesLine;
            }
        }

        $ShippingLine = new IPPLine(
            array('Description'=>'Shipping Paid. OrderId'.$payments['order_id'],
                  'Amount'     =>$payments['shipping'],
                  'DetailType' =>'AccountBasedExpenseLineDetail',
                  'AccountBasedExpenseLineDetail'=>
                    new IPPAccountBasedExpenseLineDetail(
                        array('AccountRef'=>
                            new IPPReferenceType(array('value'=>$shippingAccountId))
                        )
                    ),
            )
        ); 
        $lines[] = $ShippingLine;

        // Create Bill Obj
        $billObj = new IPPBill();
        $billObj->Name = "Bill For OrderId " . $payments['order_id'];
        $billObj->VendorRef = new IPPReferenceType(array('value'=>$vendorId));
        $billObj->Line = $lines;
                                
        return $this->dataService->Add($billObj);
    }
    public function getReport()
    {
        // die('sa');
        $oauth = new OAuth($this->requestValidator->ConsumerKey, $this->requestValidator->ConsumerSecret);
        $oauth->setToken($this->requestValidator->AccessToken, $this->requestValidator->AccessTokenSecret);
        $oauth->enableDebug();
        $oauth->setAuthType(OAUTH_AUTH_TYPE_AUTHORIZATION);
        $oauth->disableSSLChecks();

        try
        {
            $requestUri = $this->serviceContext->baseserviceURL . "company/". $this->realmId ."/reports/ProfitAndLoss?start_date=2015-10-01&end_date=2015-11-01";
//            echo "\n$requestUri\n";
//            var_dump($httpHeaders);
//            echo "$OauthMethod\n";
//            echo "$requestBody\n";
            $oauth->fetch($requestUri);
        }
        catch ( OAuthException $e )
        {
            //echo "ERROR:\n";
            //print_r($e->getMessage()) . "\n";
            
            
            //echo "Response: {$response_code} - {$response_xml} \n";
            //var_dump($oauth->debugInfo);
            //echo "\n";
            //echo "ERROR MESSAGE: " . $oauth->debugInfo['body_recv'] . "\n"; // Useful info from Intuit
            //echo "\n";
            return FALSE;
        }

        $response = $oauth->getLastResponse();

        echo "<pre>";
        print_r(json_decode($response));
        die();
        return array($response_code,$response_xml);  
    }
}
