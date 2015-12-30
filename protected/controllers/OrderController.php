<?php

class OrderController extends Controller {

    public $layoutPath;
    public $layout;

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
        $criteria->condition = 'status = 1';
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
            $edit_url = Yii::app()->createUrl('order/edit', array('oid' => $item->id));
            $action = '<a data-toggle="modal" href="' . $edit_url . '" data-target="#edit-order-modal"><span class="label label-primary">Sửa</span></a>';
            $action.='';
            $itemArr['action'] = $action;
            $returnArr[] = $itemArr;
        }

        echo json_encode(array('data' => $returnArr, "recordsTotal" => count($data),
            "recordsFiltered" => count($data)));
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
            $itemArr['phone'] = $item->phone;
            $itemArr['email'] = $item->email;
            $itemArr['requirement'] = $item->requirement;
            $itemArr['created_at'] = Date('d-m-Y', $item->created_at);
            $itemArr['status'] = $item->status;
            $itemArr['status_name'] = Util::getStatusLabel($item->status);
            $edit_url = Yii::app()->createUrl('order/edit', array('oid' => $item->id));
            $result_url = Yii::app()->createUrl('order/result', array('oid' => $item->id));
            $action = '<a data-toggle="modal" href="' . $edit_url . '" data-target="#edit-order-modal" onclick=loadInfo(' . $item->id . ')><span class="label label-primary">Sửa</span></a>';
            $action.=' <a data-toggle="modal" href="' . $result_url . '" data-target="#edit-order-result-modal" onclick=loadInfoResult(' . $item->id . ')><span class="label label-info">Thêm kết quả</span></a>';
            $itemArr['action'] = $action;
            $returnArr[] = $itemArr;
        }

        echo json_encode(array('data' => $returnArr, "recordsTotal" => count($data),
            "recordsFiltered" => count($data)));
    }

    public function actionEdit() {
        $request = Yii::app()->request;
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_modal';
        $order_id = StringHelper::filterString($request->getQuery('oid'));
        $data = OrderMedlatec::model()->getOrderDetail($order_id);
        $this->render('edit', array('data' => $data));
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
        $this->render('result', array('data' => $data));
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
