<?
/**
 * @var ChoiceResidence $this
 * @var string $prefix_name
 * @var string $title
 * @var CActiveRecord|array $model
 *
 * @var Country[] $country
 * @var Regions[] $city
 * @var City[] $region
 */
$updateUrl = Yii::app()->createUrl('/ChoiceResidence/ChoiceResidence/residence');
?>
    <div class="choose-city-widget">
        <?
        if($title){
            echo CHtml::label($title,'');
        }

        $attribute = 'country';
        $this->render('_select_block',[
            'attribute'=>$attribute,
            'label'=>$this->getLabel($attribute),
            'name'=>$this->getName($attribute),
            'data'=>CHtml::listData($country, 'id_country', 'country_name_ru'),
            'model'=>$model,
            'onChange'=>"showCities{$prefix_name}($(this),'region','$attribute','{$updateUrl}')",
            'empty'=>'Select country',
        ]);

        if(isset($model['country'])){
            $attribute = 'region';
            $this->render('_select_block',[
                'attribute'=>$attribute,
                'label'=>$this->getLabel($attribute),
                'name'=>$this->getName($attribute),
                'data'=>CHtml::listData($region, 'id_region', 'region_name_ru'),
                'model'=>$model,
                'onChange'=>"showCities{$prefix_name}($(this),'city','$attribute','{$updateUrl}')",
                'empty'=>'Select region',
            ]);
        }

        if(isset($model['region'])){
            $attribute = 'city';
            $this->render('_select_block',[
                'attribute'=>$attribute,
                'label'=>$this->getLabel($attribute),
                'name'=>$this->getName($attribute),
                'data'=>CHtml::listData($city, 'id_city', 'city_name_ru'),
                'model'=>$model,
                'onChange'=>"showCities{$prefix_name}($(this),'','$attribute','{$updateUrl}')",
                'empty'=>'Select city',
            ]);
        }
        ?>
    </div>
<?
$class_model = $model instanceof CActiveRecord ? get_class($model) : '';
/* @var $cs CClientScript*/
$cs = Yii::app()->clientScript;
$cs->registerScript('choose-city',"
	$(function(){
	showCities{$prefix_name} = function(element,who_model,who_this,url){
	    if(element.val()&&who_model){
			$.post(url,{
			    'id':element.val(),
			    'who_model':who_model,
			    'who_this':who_this,
			    'prefix':'{$prefix_name}',
			    'model':'{$class_model}'
            },function(data){
                var container = element.closest('.choose-city-widget');
                element.closest('.form-group').nextAll('.form-group').remove();
                container.append(data);
                $(document).trigger('showCities', who_model, element);
			});
	    }else{
	        element.closest('.form-group').nextAll('.form-group').remove();
	    }
	}
    })
");
?>