<?php

class ResultController extends Controller {

    public $layoutPath;
    public $layout;

    public function actionIndex() {
        $this->render('index');
    }

    public function actionGetAllResult() {
        $columns = array(
            0 => 'id',
            1 => 'patient_name',
            2 => 'service',
            3 => 'time',
            4 => 'status',
            5 => 'created_at',
            6 => 'action',
        );
        $request = Yii::app()->request;
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $column = $_REQUEST['order'][0]['column'];
        $order = $_REQUEST['order'][0]['dir'];
        $where = null;
        $criteria = new CDbCriteria;
        if (!empty($_REQUEST['search']['value'])) {
            $criteria->addSearchCondition("patient_name", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("service", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("time", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("status", $_REQUEST['search']['value'], 'true', 'OR');
            $where = true;
        }
        $criteria->limit = $length;
        $criteria->offset = $start;
        $criteria->order = "$columns[$column] $order";
        $data = ResultMedlatec::model()->findAll($criteria);
        $returnArr = array();
        $service_name = null;
        $patient_name = null;
        foreach ($data as $item) {
            $order = OrderMedlatec::model()->findByPk($item->order_id);
            if ($order) {
                $service = ServiceMedlatec::model()->findByPk($order->service_id);
                if ($service) {
                    $service_name = $service->service_name;
                }
                $patient_name = $order->name;
            }
            $itemArr = array();
            $itemArr['id'] = $item->id;
            $itemArr['patient_name'] = $patient_name;
            $itemArr['service'] = $service_name;
            $itemArr['time'] = Date('d-m-Y', $item->time);
            $itemArr['status'] = Util::getStatusLabel($item->status);
            $itemArr['created_at'] = Date('d-m-Y', $item->created_at);
            $edit_url = Yii::app()->createUrl('result/edit', array('result_id' => $item->id));
            ;
            $order_url = Yii::app()->createUrl('result/order', array('oid' => $item->order_id));
            $action = '<a data-toggle="modal" href="' . $edit_url . '" data-target="#edit-order-modal" onclick="loadInfoResult(' . $item->id . ')"><span class="label label-primary">Sửa</span></a>';
            $action.= ' <a data-toggle="modal" href="' . $order_url . '" data-target="#edit-order-modal" onclick="loadInfo(' . $item->order_id . ')"><span class="label label-info">Xem order</span></a>';
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
        $result_id = StringHelper::filterString($request->getQuery('result_id'));
        $data = ResultMedlatec::model()->getDetailResult($result_id);
        $services = ServiceMedlatec::model()->findAll();
        $orders = OrderMedlatec::model()->findAll();
        $this->render('edit', array('data' => $data, 'services' => $services, 'orders'=>$orders));
    }

    public function actionAdd() {
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_modal';
        $orders = OrderMedlatec::model()->findAll();
        $this->render('add', array('orders' => $orders));
    }

    public function actionAddProcess() {
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
    }

    public function actionEditProcess() {
        $attr = StringHelper::filterArrayString($_POST);
        $result = ResultMedlatec::model()->updateResult($attr);
        if ($result) {
            ResponseHelper::JsonReturnSuccess('', 'Update success');
        } else {
            ResponseHelper::JsonReturnError('', 'Update failed');
        }
    }

    public function actionOrder() {
        $request = Yii::app()->request;
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_modal';
        $order_id = StringHelper::filterString($request->getQuery('oid'));
        $data = OrderMedlatec::model()->getOrderDetail($order_id);
        $this->render('order', array('data' => $data));
    }

    public function actionUpdateResultOrder() {
        $request - Yii::app()->request;
        $order_id = StringHelper::filterString($request->getQuery('oid'));
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
