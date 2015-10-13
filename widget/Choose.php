<?php
Yii::import('application.modules.ChoiceResidence.models.*');

/**
 * Class ChooseWidget
 * @property $model CActiveRecord|array
 * @property $title string
 * @property $prefix string
 */
class Choose extends CWidget
{
    public $model=[];
    public $title='';
    public $prefix='';

    public function getViewPath($checkTheme=false){
        return Yii::getPathOfAlias('ChoiceResidence.views.widget');
    }

    public function run() {
        $country=Country::model()->findAll(['order'=>'country_order']);
        $region=Regions::model()->findAllByAttributes(['id_country'=>$this->model['countries']]);
        $city=City::model()->findAllByAttributes(['id_region'=>$this->model['region']]);

        $this->render('main',[
            'model'=>$this->model,
            'title'=>$this->title,
            'prefix_name'=>$this->prefixName,
            'country'=>$country,
            'region'=>$region,
            'city'=>$city
        ]);
    }

    /**
     * @param $attribute
     * @return string
     */
    public function getName($attribute){
        $name = $attribute;
        if($this->model instanceof CActiveRecord && isset($this->model->$attribute)){
            $name = CHtml::activeName($this->model, $attribute);
        }elseif($this->prefixName){
            $name = $this->prefixName."[$attribute]";
        }
        return $name;
    }

    /**
     * @param $attribute
     * @return string
     */
    public function getLabel($attribute){
        if($this->model instanceof CActiveRecord && isset($this->model->$attribute)){
            $label =  $this->model->getAttributeLabel($attribute);
        }else{
            $label = Yii::t('choose-city', $attribute);
        }
        return $label;
    }

    public function getPrefixName(){
        if($this->prefix)
            return $this->prefix;
        elseif($this->model instanceof CActiveRecord){
            return get_class($this->model);
        }else{
            return '';
        }
    }
}