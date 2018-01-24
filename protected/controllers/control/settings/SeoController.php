<?php

class SeoController extends AdminController
{
    public function actionIndex()
    {
        $data = Yii::app()->params->seo;
        if (isset($_POST['save'])) {
            $params = array(
                'site_name' => $_POST['site_name'],
                'meta_keywords' => $_POST['meta_keywords'],
                'meta_description' => $_POST['meta_description'],
                'google_analytics_account' => $_POST['google_analytics_account']
            );

            UtilsHelper::addParams('seo', $params, null);
            foreach ($params as $k => $v) {
                $data[$k] = $v;
            }
        }
        $this->render('index', array(
            'data' => $data,
        ));
    }

    public function actionSiteMap()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $file = CUploadedFile::getInstanceByName('site_map');
            $response = array('type' => 'error', 'message' => '');

            if (!$file) {
                $response['message'] = Yii::t('base', 'choose file');
            } else {
                $type = $file->getType();

                if ($type != 'text/xml') {
                    $response['message'] = Yii::t('base', 'use only xml');
                } else {
                    if($this->saveSiteMap($file)){
                        $response['type'] = 'success';
                        $response['message'] = Yii::app()->getBaseUrl(true) . DIRECTORY_SEPARATOR . $file->getName();
                    }else{
                        $response['type'] = 'error';
                        $response['message'] = 'error in saving';
                    }
                }
            }

            $str = CJSON::encode($response);
            echo $str;
        }
    }

    private function saveSiteMap(CUploadedFile $file){
        $result = true;
        $sourceDir = Yii::getPathOfAlias('webroot.images.upload');
        $webroot = Yii::getPathOfAlias('webroot');
        $sourcePath = $sourceDir . DIRECTORY_SEPARATOR . $file->getName();
        $path = $webroot . DIRECTORY_SEPARATOR . $file->getName();

        try{
            if(file_exists($sourcePath)){
                unlink($sourcePath);
            }

            $file->saveAs($sourcePath);

            $siteMap = fopen($path, 'w');
            $content = file_get_contents($sourcePath);
            fwrite($siteMap, $content);
            fclose($siteMap);

        }catch(Exception $e){
            Yii::log($e->getMessage());
            $result = false;
        }

        return $result;
    }
}



















