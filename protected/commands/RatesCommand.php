<?php

class RatesCommand extends CConsoleCommand
{
    protected $rates_file = "http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
    
    public function run($args)
    {
        $XMLContent = file($this->rates_file);
        
        foreach ($XMLContent as $line) {
            if (preg_match("/currency='([[:alpha:]]+)'/", $line, $currencyCode)) {
                $currency = Currency::model()->find('LOWER(name) = :name', [':name' => strtolower($currencyCode[1])]);
                if ($currency) {
                    if (preg_match("/rate='([[:graph:]]+)'/", $line, $rate)) {
                        if (isset($currency->currencyRate)) {
                            if (strtotime($currency->currencyRate->created_at) < time()) {
                                $currency->currencyRate->rate = $rate[1];
                                $currency->currencyRate->created_at = date('Y-m-d H:i:s');
                                $currency->currencyRate->save();
                            }
                        } else {
                            $model = new CurrencyRate();
                            $model->currency_id = $currency->id;
                            $model->rate = $rate[1];
                            $model->created_at = date('Y-m-d H:i:s');
                            $model->save();
                        }
                        
                    }
                }
                
            }
        } 
        
        return true;
    }
}