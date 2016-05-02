<?php

class UserController extends Controller {

    public $layout;
    public $layoutPath;

    public function actionIndex() {
        $this->render('index');
    }

    public function actionLogin() {
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_no_header';
        $this->render('login');
    }

    public function actionProcessLogin() {
        $request = Yii::app()->request;
        if (isset($_POST)) {
            $email = StringHelper::filterString($request->getPost('email'));
            $password = StringHelper::filterString($request->getPost('password'));
            //  if(Provider::model()->findByAttributes())
            if ($email === 'meboo.admin@meboo.vn' && $password === '123456') {
                Yii::app()->session['meboo_admin'] = 'meboo_admin';
                Yii::app()->session['logged'] = 1;
                Yii::app()->session['type'] = 'meboo_admin';
                $this->redirect(Yii::app()->createUrl('order/index'));
            } else if ($email === 'meboo@meboo.vn' && $password === '123456') {
                Yii::app()->session['meboo_staff'] = 'meboo_staff';
                Yii::app()->session['logged'] = 1;
                Yii::app()->session['type'] = 'meboo_staff';
                $this->redirect(Yii::app()->createUrl('orderMed/index'));
            }
            $provider = Provider::model()->findByAttributes(array('email' => $email));
            if ($provider) {
                if ($provider->password == md5($password)) {
                    Yii::app()->session['provider_admin'] = 'provider_admin';
                    Yii::app()->session['logged'] = 1;
                    Yii::app()->session['type'] = 'provider_admin';
                    Yii::app()->session['provider_id'] = $provider->provider_id;
                    $this->redirect(Yii::app()->createUrl('orderMed/index'));
                }
            } else {
                Yii::app()->user->setFlash('error', 'Sai tên đăng nhập và mật khẩu');
                $this->redirect(Yii::app()->createUrl('user/login'));
            }
        }
    }

    public function actionLogout() {
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->createUrl('user/login'));
    }
    
    public function actionChangePassword() {
        $this->render('changePass');
    }

    public function actionListAllProviders() {
        $providers = Provider::model()->findAll();
        ResponseHelper::JsonReturnSuccess($providers, 'Success');
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}
