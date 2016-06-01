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
                } else {
                    Yii::app()->user->setFlash('error', 'Sai tên đăng nhập và mật khẩu');
                    $this->redirect(Yii::app()->createUrl('user/login'));
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

    public function actionChangePass() {
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_no_header';
        $this->render('changePass');
    }

    public function actionProcessChangePass() {
        $request = Yii::app()->request;
        if (isset($_POST)) {
            $email = StringHelper::filterString($request->getPost('email'));
            $password = StringHelper::filterString($request->getPost('password'));
            $new_password = StringHelper::filterString($request->getPost('new_password'));
            if ($new_password == '') {
                Yii::app()->user->setFlash('success', 'Mật khẩu mới không được để rỗng');
                $this->redirect(Yii::app()->createUrl('user/login'));
            }
            //  if(Provider::model()->findByAttributes())
            $check = Provider::model()->findByAttributes(array('email' => $email));
            if ($check) {
                if (md5($password) == $check->password) {
                    $check->password = md5($new_password);
                    $check->save(FALSE);
                    Yii::app()->user->setFlash('success', 'Đổi mật khẩu thành công, bạn vui lòng đăng nhập lại');
                    $this->redirect(Yii::app()->createUrl('user/login'));
                } else {
                    Yii::app()->user->setFlash('error', 'Sai mật khẩu');
                    $this->redirect(Yii::app()->createUrl('user/changePass'));
                }
            } else {
                Yii::app()->user->setFlash('error', 'Tài khoản không tồn tại');
                $this->redirect(Yii::app()->createUrl('user/changePass'));
            }
        }
    }

    public function actionListAllProviders() {
        $providers = Provider::model()->findAll();
        ResponseHelper::JsonReturnSuccess($providers, 'Success');
    }

    public function actionRegisterProvider() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        $request = Yii::app()->request;
        try {
            $name = $request->getPost('name');
            $email = $request->getPost('email');
            $phone = $request->getPost('phone');
            $address = $request->getPost('address');
            $provider = new Provider;
            $provider->email = $email;
            $provider->phone = $phone;
            $provider->provider_name = $name;
            $provider->provider_address = $address;
            $token = StringHelper::generateToken(5, 25);
            $provider->token = $token;
            if ($provider->save(FALSE)) {
                $subject = 'Kích hoạt tài khoản provider Meboo của bạn';
                $to_email = $email;
                $from_email = 'hotro@meboo.vn';
                $from_name = 'Hỗ trợ Meboo';
                $message = 'Bấm vào đây để kích hoạt tài khoản Provider Meboo của bạn: http://doitac.meboo.vn/user/activate?token=' . $token;
                MailQueue::model()->addMailQueue($message, $from_email, $from_name, $to_email, $subject);
                ResponseHelper::JsonReturnSuccess('', 'Success');
            } else {
                ResponseHelper::JsonReturnError('', 'Error');
            }
        } catch (Exception $ex) {
            ResponseHelper::JsonReturnError($ex->getMessage(), 'Error');
        }
    }

    public function actionActivate() {
        $request = Yii::app()->request;
        try {
            $token = StringHelper::filterString($request->getQuery('token'));
            if ($token != '') {
                $check = User::model()->findByAttributes(array('token' => $token));
                if ($check) {
                    $password = StringHelper::generateRandomString(5);
                    $check->token = '';
                    $check->password = md5($password);
                    $check->save('FALSE');
                    $subject = 'Mật khẩu tài khoản provider Meboo của bạn';
                    $to_email = $check->email;
                    $from_email = 'hotro@meboo.vn';
                    $from_name = 'Hỗ trợ Meboo';
                    $message = 'Mật khẩu tài khoản Meboo Provider của bạn: ' . $password;
                    MailQueue::model()->addMailQueue($message, $from_email, $from_name, $to_email, $subject);
                    Yii::app()->user->setFlash('success', 'Vui lòng kiểm tra email để lấy mật khẩu đăng nhập');
                    $this->redirect(Yii::app()->createUrl('user/login'));
                } else {
                    Yii::app()->user->setFlash('error', 'Token đã hết hạn !');
                    $this->redirect(Yii::app()->createUrl('user/login'));
                }
            } else {
                Yii::app()->user->setFlash('error', 'Token không tồn tại');
                $this->redirect(Yii::app()->createUrl('user/login'));
            }
        } catch (Exception $ex) {
            ResponseHelper::JsonReturnError($ex->getMessage(), 'Error');
        }
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
