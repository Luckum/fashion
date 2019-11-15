<?php

class LeadController extends Controller
{
    public function actionIndex($id)
    {
        $model = Product::model()->findByPk($id);
        
        if ($model) {
            $url = $model->direct_url;
            $partner = Product::getExternalSiteName($url);
            $partner_site_name = $partner['name'];
        }
        return $this->renderPartial('index', [
            'partner_site_name' => $partner_site_name,
            'url' => $url,
        ]);
    }
}