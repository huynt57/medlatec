<?php

class OrderController extends Controller {

    public $layoutPath;
    public $layout;

//    protected function beforeAction($action) {
//        if ($action !== 'login') {
//            if (empty(Yii::app()->session['logged'])) {
//                $this->redirect(Yii::app()->createUrl('user/login'));
//            }
//        }
//        return true;
//    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionGetOrderMedlatec() {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'phone',
            3 => 'email',
            4 => 'requirement',
            5 => 'created_at',
            6 => 'status',
            7 => 'action',
        );
        //  $request = Yii::app()->request;
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $column = $_REQUEST['order'][0]['column'];
        $order = $_REQUEST['order'][0]['dir'];
        $where = null;
        $criteria = new CDbCriteria;
        if (!empty($_REQUEST['search']['value'])) {
            $criteria->addSearchCondition("name", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("phone", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("email", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("requirement", $_REQUEST['search']['value'], 'true', 'OR');
            $where = true;
        }
        //echo $order;
        $criteria->limit = $length;
        $criteria->offset = $start;
        $criteria->order = "$columns[$column] $order";
        $criteria->condition = 'status = 1 AND provider_id = ' . Yii::app()->session['provider_id'];
        // var_dump($start); die;
        $data = OrderMedlatec::model()->findAll($criteria);
        $returnArr = array();
        foreach ($data as $item) {
            $itemArr = array();
            $itemArr['id'] = $item->id;
            $itemArr['name'] = $item->name;
            $itemArr['phone'] = $item->phone;
            $itemArr['email'] = $item->email;
            $itemArr['requirement'] = $item->requirement;
            $itemArr['created_at'] = $item->created_at;
            $itemArr['status'] = $item->status;
            if (empty(Yii::app()->session['provider_id'])) {
                $itemArr['provider_name'] = Provider::model()->getProviderName($item->provider_id);
            }
            //   $edit_url = Yii::app()->createUrl('order/edit', array('oid' => $item->id));
            $action = '<a data-toggle="modal" data-target="#edit-order-modal"><span class="label label-primary">Sửa</span></a>';
            $action.='';
            $itemArr['action'] = $action;
            $returnArr[] = $itemArr;
        }

        echo json_encode(array('data' => $returnArr, "recordsTotal" => $count,
            "recordsFiltered" => $count));
    }

    public function actionGetAllOrder() {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'phone',
            3 => 'email',
            4 => 'requirement',
            5 => 'created_at',
            6 => 'status',
            7 => 'action',
        );
        //  $request = Yii::app()->request;
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $column = $_REQUEST['order'][0]['column'];
        $order = $_REQUEST['order'][0]['dir'];
        $where = null;
        $criteria = new CDbCriteria;
        if (!empty($_REQUEST['search']['value'])) {
            $criteria->addSearchCondition("name", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("phone", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("email", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("requirement", $_REQUEST['search']['value'], 'true', 'OR');
            $where = true;
        }
        //echo $order;

        $count = OrderMedlatec::model()->count($criteria);
        $criteria->limit = $length;
        $criteria->offset = $start;
        $criteria->order = "$columns[$column] $order";

        // var_dump($start); die;
        $data = OrderMedlatec::model()->findAll($criteria);
        $returnArr = array();
        foreach ($data as $item) {
            $itemArr = array();
            $itemArr['id'] = $item->id;
            $itemArr['name'] = $item->name;
            //  $itemArr['service_id'] = $item->service_id;
            $itemArr['phone'] = $item->phone;
            $itemArr['email'] = $item->email;
            $itemArr['requirement'] = $item->requirement;
            $itemArr['created_at'] = Date('d-m-Y', $item->created_at);
            $itemArr['status'] = $item->status;
            if (empty(Yii::app()->session['provider_id'])) {
                $itemArr['provider_name'] = Provider::model()->getProviderName($item->provider_id);
            }
            $itemArr['status_name'] = Util::getStatusLabel($item->status);
            // $edit_url = Yii::app()->createUrl('order/edit', array('oid' => $item->id));
            // $result_url = Yii::app()->createUrl('order/result', array('oid' => $item->id));
            $action = '<a data-toggle="modal" data-target="#edit-order-modal" onclick=loadInfo(' . $item->id . ')><span class="label label-primary">Sửa</span></a>';
            $action .= ' <a data-toggle="modal" data-target="#delete-order-modal" onclick=loadInfoDelete(' . $item->id . ')><span class="label label-danger">Xóa</span></a>';
            $action.=' <a data-toggle="modal" data-target="#edit-order-result-modal" onclick=loadInfoResult(' . $item->id . ')><span class="label label-info">Thêm kết quả</span></a>';
            $itemArr['action'] = $action;
            $returnArr[] = $itemArr;
        }
        // $all = OrderMedlatec::model()->findAll();
        echo json_encode(array('data' => $returnArr, "recordsTotal" => $count,
            "recordsFiltered" => $count));
    }

    public function actionDeleteProcess() {
        $order_id = StringHelper::filterString(Yii::app()->request->getPost('order_id'));
        $result = OrderMedlatec::model()->deleteOrder($order_id);
        if ($result) {
            ResponseHelper::JsonReturnSuccess('', 'Delete success');
        } else {
            ResponseHelper::JsonReturnError('', 'Delete failed');
        }
    }

    public function actionEdit() {
        $request = Yii::app()->request;
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_modal';
        $order_id = StringHelper::filterString($request->getQuery('oid'));
        $data = OrderMedlatec::model()->getOrderDetail($order_id);
        $services = ServiceMedlatec::model()->findAll();

        $this->render('edit', array('data' => $data, 'services' => $services));
    }

    public function actionEditProcess() {
        $attr = StringHelper::filterArrayString($_POST);
        $result = OrderMedlatec::model()->updateOrder($attr);
        if ($result) {
            ResponseHelper::JsonReturnSuccess('', 'Update success');
        } else {
            ResponseHelper::JsonReturnError('', 'Update failed');
        }
    }

    public function actionResult() {
        $request = Yii::app()->request;
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_modal';
        $order_id = StringHelper::filterString($request->getQuery('oid'));
        $data = OrderMedlatec::model()->getOrderDetail($order_id);
        $result = ResultMedlatec::model()->findByAttributes(array('order_id' => $order_id));
        if ($result) {
            $files = ResultFile::model()->findAllByAttributes(array('result_id' => $result->id));
        }
        if (isset($result) && isset($files)) {
            $this->render('result', array('data' => $data, 'result' => $result, 'files' => $files));
        } else {
            $this->render('result', array('data' => $data));
        }
    }

    public function actionUpdateResult() {
        try {
            $urls = NULL;

            $doctor = StringHelper::filterString($_POST['doctor']);
            $diagnose = StringHelper::filterString($_POST['diagnose']);
            $status = StringHelper::filterString($_POST['status']);
            $order_id = StringHelper::filterString($_POST['order_id']);
            $attr = array('doctor' => $doctor, 'diagnose' => $diagnose, 'status' => $status, 'order_id' => $order_id);
            //  var_dump($_FILES); die;
            if (isset($_FILES['file'])) {
                $urls = UploadHelper::getUrlUploadMultiImages($_FILES['file'], 'result');
            }
            if (ResultMedlatec::model()->updateResultByOrder($attr, $urls)) {
                ResponseHelper::JsonReturnSuccess('', 'Success');
            } else {
                ResponseHelper::JsonReturnError('', 'Error');
            }
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
        }
        // ResultMedlatec::model()->up
    }

    public function actionDeleteOrder() {
        $request = Yii::app()->request;
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_modal';
        $order_id = StringHelper::filterString($request->getQuery('order_id'));

        $this->render('deleteOrder', array('data' => $order_id));
    }

//    public function actionTestPushIos() {
//        $device_token = '7fde7c0e0cca5367d4dc777f555b6ee077ffe17ea74afebea4f1c54ae304abc0';
//        IosPushHelper::sendNotification($device_token, 'test');
//    }
//
//    public function actionTestPushAndroid() {
//        $device_token = 'cJQqrODAQsQ:APA91bEb7OtfQsdsPSHHXDfgKb5l3ETj_eO7bjTXPd-n_-LzkMsSFULoM4RfOrNzbxYJ9u61ANGK497zeczv3X4BsJlPuT6mAKbScursqTDeGYqBX-sTdWFE2JiPIysrLTc-LOb9x2W-';
//        var_dump(GcmHelper::sendNotification($device_token, array('medlatec_order' =>
//                    array(
//                        'order_id' => '1',
//                    ),)));
//    }
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
