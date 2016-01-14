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
            if ($email === 'meboo.admin@gmail.com' && $password === '123456') {
                Yii::app()->session['meboo_admin'] = 'meboo_admin';
                Yii::app()->session['logged'] = 1;
                $this->redirect(Yii::app()->createUrl('order/index'));
            } else if ($email === 'medlatec@gmail.com' && $password === '123456') {
                Yii::app()->session['medlatec_staff'] = 'medlatec_staff';
                Yii::app()->session['logged'] = 1;
                $this->redirect(Yii::app()->createUrl('orderMed/index'));
            } else if ($email === 'medlactec.admin@gmail.com' && $password === '123456') {
                Yii::app()->session['medlatec_admin'] = 'medlatec_admin';
                Yii::app()->session['logged'] = 1;
                $this->redirect(Yii::app()->createUrl('orderMed/index'));
            } else if ($email === 'meboo@gmail.com' && $password === '123456') {
                Yii::app()->session['meboo_staff'] = 'meboo_staff';
                Yii::app()->session['logged'] = 1;
                $this->redirect(Yii::app()->createUrl('orderMed/index'));
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
