<?php

class ResultController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function getAllResult() {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'phone',
            3 => 'email',
            4 => 'requirement',
            4 => 'created_at',
            5 => 'action',
        );
        $request = Yii::app()->request;
        $start = $request->getPost('start');
        $length = $request->getPost('length');
        $column = $request->getParam['order'][0]['column'];
        $order = $request->getParam['order'][0]['dir'];
        $where = null;
        $criteria = new CDbCriteria;
        if (!empty($request->getParam['search']['value'])) {
            $criteria->addSearchCondition("name", $request->getParam['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("phone", $request->getParam['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("email", $request->getParam['search']['value'], 'true', 'OR');
            $criteria->addSearchCondition("requirement", $request->getParam['search']['value'], 'true', 'OR');
            $where = true;
        }
        $criteria->limit = $length;
        $criteria->offset = $start;
        $criteria->order = "$columns[$column] $order";
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
            $itemArr['action'] = '';
            $returnArr[] = $itemArr;
        }

        echo json_encode(array('data' => $returnArr, "recordsTotal" => count($data),
            "recordsFiltered" => count($data)));
    }

    public function actionEdit() {
        $request = Yii::app()->request;
        $order_id = StringHelper::filterString($request->getQuery('order_id'));
        $data = OrderMedlatec::model()->findByPk($order_id);
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
