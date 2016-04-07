<?php

class ServiceController extends Controller {

    public $layout;
    public $layoutPath;

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
        if(!empty(Yii::app()->session['provider_id'])) {
        $criteria->condition = "provider_id = " . Yii::app()->session['provider_id'];
        }
        $count = ServiceMedlatec::model()->count($criteria);
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
            $itemArr['status'] = Util::getStatusLabel($item->status);
            $itemArr['created_at'] = Date('d-m-Y', $item->created_at);
            $itemArr['updated_at'] = Date('d-m-Y', $item->updated_at);
            if(empty(Yii::app()->session['provider_id']))
            {
                $itemArr['provider_name'] = Provider::model()->getProviderName($item->provider_id);
            }
            $edit_url = Yii::app()->createUrl('service/edit', array('service_id' => $item->id));
            $action = '<a data-toggle="modal" href="' . $edit_url . '" data-target="#edit-service-modal" onclick=loadInfoService(' . $item->id . ')><span class="label label-primary">Sửa</span></a>';

            $itemArr['action'] = $action;
            $returnArr[] = $itemArr;
        }
        // $all = ServiceMedlatec::model()->findAll();
        echo json_encode(array('data' => $returnArr, "recordsTotal" => $count,
            "recordsFiltered" => count($data)));
    }

    public function actionEdit() {
        $request = Yii::app()->request;
        $this->layoutPath = Yii::getPathOfAlias('webroot') . "/themes/classic/views/layouts";
        $this->layout = 'main_modal';
        $service_id = StringHelper::filterString($request->getQuery('service_id'));
        $data = ServiceMedlatec::model()->findByPk($service_id);
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
