<?php

Yii::import('application.models._base.BaseResultMedlatec');

class ResultMedlatec extends BaseResultMedlatec {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function updateResult($attr, $urlArr) {
        $result = ResultMedlatec::model()->findByPk($attr['result_id']);
        if ($result) {
            $result->setAttributes($attr);
            //$result->file = $url;
            $result->updated_at = time();
            if (isset($urlArr)) {
                // ResultFile::model()->findAllByAttributes(array('result_id'=>$attr['result_id']))->delete();
            }
            if ($result->save(FALSE)) {
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }

    public function addResult($attr, $urlArr) {
        $model = new ResultMedlatec;
        $model->setAttributes($attr);
        $model->updated_at = time();
        $model->created_at = time();
        // $model->file = $url;
        if ($model->save(FALSE)) {
            return TRUE;
        }
        return FALSE;
    }

    public function updateResultByOrder($attr, $urls) {

        $check = ResultMedlatec::model()->findAllByAttributes(array('order_id' => $attr['order_id']));
        if ($check) {
            $check->setAttributes($attr);
            $check->updated_at = time();
            $check->save(FALSE);
            $files = ResultFile::model()->findAllByAttributes(array('result_id' => $check->id));
            foreach ($files as $file) {
                $file->delete();
            }
            if (!empty($urls) && is_array($urls)) {
                foreach ($urls as $url) {
                    $file = new ResultFile;
                    $file->url = $url;
                    $file->updated_at = time();
                    $file->created_at = time();
                    $file->result_id = $check->id;
                    $file->save(FALSE);
                }
            }
            return TRUE;
        } else {
            $model = new ResultMedlatec;
            $model->setAttributes($attr);
            $model->created_at = time();
            $model->updated_at = time();
            $model->save(FALSE);
            if (!empty($urls) && is_array($urls)) {
                foreach ($urls as $url) {
                    $file = new ResultFile;
                    $file->url = $url;
                    $file->updated_at = time();
                    $file->created_at = time();
                    $file->result_id = $model->id;
                    $file->save(FALSE);
                }
            }
            return TRUE;
        }
    }

}
