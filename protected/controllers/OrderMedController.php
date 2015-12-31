<?php

class OrderMedController extends Controller {

    public $layoutPath;
    public $layout;

    protected function beforeAction($action) {
        if ($action !== 'login') {
            if (empty(Yii::app()->session['logged'])) {
                $this->redirect(Yii::app()->createUrl('user/login'));
            }
        }
        return true;
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionGetAllOrderMedlatec() {
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
        $criteria->condition = "status >= 1";
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
            $itemArr['status_name'] = Util::getStatusLabel($item->status);
            $edit_url = Yii::app()->createUrl('order/edit', array('oid' => $item->id));
            $result_url = Yii::app()->createUrl('order/result', array('oid' => $item->id));
            $action = '<a data-toggle="modal" href="' . $edit_url . '" data-target="#edit-order-modal" onclick=loadInfo(' . $item->id . ')><span class="label label-primary">Sửa</span></a>';
            $action.=' <a data-toggle="modal" href="' . $result_url . '" data-target="#edit-order-result-modal" onclick=loadInfoResult(' . $item->id . ')><span class="label label-info">Thêm kết quả</span></a>';
            $itemArr['action'] = $action;
            $returnArr[] = $itemArr;
        }
        // $all = OrderMedlatec::model()->findAll();
        echo json_encode(array('data' => $returnArr, "recordsTotal" => $count,
            "recordsFiltered" => $count));
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
