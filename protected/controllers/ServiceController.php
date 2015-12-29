<?php

class ServiceController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionGetAllService() {
        $columns = array(
            0 => 'id',
            1 => 'service_name',
            2 => 'service_price',
            3 => 'favorable',
            4 => 'description',
            5 => 'status',
            6 => 'created_at',
            7 => 'updated_at',
            8 => 'action',
        );
        //  $request = Yii::app()->request;
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $column = $_REQUEST['order'][0]['column'];
        $order = $_REQUEST['order'][0]['dir'];
        $where = null;
        $criteria = new CDbCriteria;
        if (!empty($_REQUEST['search']['value'])) {
            $criteria->addSearchCondition("service_name", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("service_price", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("favorable", $_REQUEST['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("description", $_REQUEST['search']['value'], 'true', 'OR');
            $where = true;
        }
        $criteria->limit = $length;
        $criteria->offset = $start;
        $criteria->order = "$columns[$column] $order";
        $data = ServiceMedlatec::model()->findAll($criteria);
        $returnArr = array();
        foreach ($data as $item) {
            $itemArr = array();
            $itemArr['id'] = $item->id;
            $itemArr['service_name'] = $item->service_name;
            $itemArr['service_price'] = $item->service_price;
            $itemArr['favorable'] = $item->favorable;
            $itemArr['description'] = $item->description;
            $itemArr['status'] = $item->status;
            $itemArr['created_at'] = $item->created_at;
            $itemArr['updated_at'] = $item->updated_at;
            $itemArr['action'] = '';
            $returnArr[] = $itemArr;
        }

        echo json_encode(array('data' => $returnArr, "recordsTotal" => count($data),
            "recordsFiltered" => count($data)));
    }

    public function actionEdit() {
        $request = Yii::app()->request;
        $order_id = StringHelper::filterString($request->getQuery('order_id'));
        $data = ServiceMedlatec::model()->findByPk($order_id);
        $this->render('edit', array('data' => $data));
    }

    public function actionAdd() {
        $this->render('add');
    }

    public function actionAddProcess() {
        $attr = StringHelper::filterArrayString($_POST);
        $result = ServiceMedlatec::model()->addService($attr);
        if ($result) {
            ResponseHelper::JsonReturnSuccess('', 'Update success');
        } else {
            ResponseHelper::JsonReturnError('', 'Update failed');
        }
    }

    public function actionEditProcess() {
        $attr = StringHelper::filterArrayString($_POST);
        $result = ServiceMedlatec::model()->updateService($attr);
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
