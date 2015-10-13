<?php
class ChoiceResidenceController extends CController
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    public function accessRules()
    {
        return array(
            array('allow',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actionResidence(){
        if(!Yii::app()->request->isAjaxRequest){
            throw new CHttpException('403');
        }
	    if($_POST){
            $id=(int)$_POST['id'];
            $this_model=$_POST["who_this"];
            $who_model=$_POST['who_model'];
            $prefix=$_POST['prefix'];
            $model = !empty($_POST['model']) && class_exists($_POST['model']) ? new $_POST['model'] :'';
            $data = [];
            $empty = '';
            $js_param_two = 'region';

            if($who_model=='region'){
                $js_param_two='city';
                $regions=Regions::model()->findAllByAttributes(['id_'.$this_model=>$id]);
                $data = CHtml::listData($regions, 'id_region', 'region_name_ru');
                $empty = 'Select region';
            }elseif($who_model=='city'){
                $js_param_two='';
                $cities=City::model()->findAllByAttributes(['id_'.$this_model=>$id]);
                $data = CHtml::listData($cities, 'id_city', 'city_name_ru');
                $empty = 'Select city';
            }
            $url = $this->createUrl('/ChoiceResidence/ChoiceResidence/residence');

            $name = $who_model;
            if($model && $model instanceof CActiveRecord && isset($model->$who_model)){
                $name = CHtml::activeName($model, $who_model);
            }elseif($prefix){
                $name = $prefix."[$who_model]";
            }

            if($model && $model instanceof CActiveRecord && isset($model->$who_model)){
                $label =  $model->getAttributeLabel($who_model);
            }else{
                $label = Yii::t('choose-city', $who_model);
            }

            $this->renderPartial('ChoiceResidence.views.widget._select_block',[
                'attribute'=>$who_model,
                'label'=>$label,
                'name'=>$name,
                'data'=>$data,
                'onChange'=>"showCities$prefix($(this),'$js_param_two','$who_model','$url')",
                'empty'=>$empty,
            ]);
	    }
	}


    /**
     * @param string|null $cityName
     * @param string|null $countryName
     */
    public function actionGetInfoForByCityName($cityName=null,$countryName=null){
        $criteria = new CDbCriteria();
        if($cityName){
            $criteria->join='RIGHT JOIN '.Country::tableName().' country ON country.id_country=t.id_country';
            $criteria->condition = 't.city_name_ru = :city AND country.country_name_ru = :country';
            $criteria->params=array(':city'=>$cityName,':country'=>$countryName);
            $model=City::model()->find($criteria);
            echo json_encode(array(
                'id_country'=>$model->id_country,
                'id_region'=>$model->id_region,
                'id_city'=>$model->id_city
            ));
        }else if($countryName){
            $criteria->condition = 'country_name_ru = :country';
            $criteria->params=array(':country'=>$countryName);
            $model=Country::model()->find($criteria);
            echo json_encode(array(
                'id_country'=>$model->id_country,
                'id_region'=>0,
                'id_city'=>0
            ));
        }

    }
}