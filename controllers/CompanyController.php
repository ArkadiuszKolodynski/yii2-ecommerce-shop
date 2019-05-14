<?php

namespace app\controllers;

use yii\web\Session;
use yii\web\Controller;
use app\models\Company;

class CompanyController extends Controller {
    public function init() {
        $session = new Session();
        $session->open();
        
        if (empty($session['account_id'])) {
            return $this->redirect(Url::toRoute('/backend/inedx'));
        }
        
        parent::init();
    }
    
    public function actionIndex() {
        $company = Company::find()->orderBy('id')->one();
        
        if (!empty($_POST)) {
            if (!empty($_FILES['Company'])) {
                // remove old logo
                if (!empty($company->logo)) {
                    $old_img = $company->logo;
                    unlink('../web/uploads/'.$old_img);
                }
                
                // upload new logo
                $img = $_FILES['Company']['name']['logo'];
                $temp = explode(".", $img);
                $ext = end($temp);
                $name = microtime();
                $name = str_replace(' ', '', $name);
                $name = str_replace( '.', '', $name);
                $name = $name.'.'.$ext;
                $tmp = $_FILES['Company']['tmp_name']['logo'];
                $company->logo = $name;
                move_uploaded_file($tmp, '../web/uploads/'.$name);
            }

            $company->name = $_POST['Company']['name'];
            $company->web_title = $_POST['Company']['web_title'];
            $company->tel = $_POST['Company']['tel'];
            $company->email = $_POST['Company']['email'];
            $company->fax = $_POST['Company']['fax'];
            $company->website = $_POST['Company']['website'];
            $company->facebook = $_POST['Company']['facebook'];
            $company->line_id = $_POST['Company']['line_id'];
            $company->address = $_POST['Company']['address'];
            $company->tax_code = $_POST['Company']['tax_code'];
            $company->payment = $_POST['Company']['payment'];
            $company->about = $_POST['Company']['about'];
            
            if ($company->save()) {
                $session = new Session ();
                $session->open();
                $session->setFlash('message', 'Data Saved.' );
                
                return $this->redirect(['index']);
            } 
        }
        
        return $this->render('//Company/Index', [
            'company' => $company
        ]);
    }
}
?>
