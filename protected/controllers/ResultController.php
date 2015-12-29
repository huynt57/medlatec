<?php

class ResultController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function getAllResult() {
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
        $start = $request->getPost('start');
        $length = $request->getPost('length');
        $column = $request->getParam['order'][0]['column'];
        $order = $request->getParam['order'][0]['dir'];
        $where = null;
        $criteria = new CDbCriteria;
        if (!empty($request->getParam['search']['value'])) {
            $criteria->addSearchCondition("patient_name", $request->getParam['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("service", $request->getParam['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("time", $request->getParam['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("status", $request->getParam['search']['value'], 'true', 'OR');
            $where = true;
        }
        $criteria->limit = $length;
        $criteria->offset = $start;
        $criteria->order = "$columns[$column] $order";
        $data = ResultMedlatec::model()->findAll($criteria);
        $returnArr = array();
        foreach ($data as $item) {
            $itemArr = array();
            $itemArr['id'] = $item->id;
            $itemArr['patient_name'] = $item->patient_name;
            $itemArr['service'] = $item->service;
            $itemArr['time'] = $item->time;
            $itemArr['status'] = $item->status;
            $itemArr['created_at'] = Date('d-m-Y', $item->created_at);
            $itemArr['action'] = '';
            $returnArr[] = $itemArr;
        }

        echo json_encode(array('data' => $returnArr, "recordsTotal" => count($data),
            "recordsFiltered" => count($data)));
    }

    public function actionEdit() {
        $request = Yii::app()->request;
        $order_id = StringHelper::filterString($request->getQuery('order_id'));
        $data = ResultMedlatec::model()->findByPk($order_id);
        $this->render('edit', array('data' => $data));
    }

    public function actionAdd() {
        $this->render('add');
    }

    public function actionAddProcess() {
        $attr = StringHelper::filterArrayString($_POST);
        $result = ResultMedlatec::model()->addResult($attr);
        if ($result) {
            ResponseHelper::JsonReturnSuccess('', 'Update success');
        } else {
            ResponseHelper::JsonReturnError('', 'Update failed');
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

    public function actionDeleteOrder() {
        
    }
    
    public function actionUpdateResultOrder()
    {
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
