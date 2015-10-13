<?php
/**
 * @var string $attribute
 * @var array $data
 * @var CActiveRecord|array $model
 * @var string $empty
 * @var string $onChange
 */
?>
<div class="form-group">
    <?=CHtml::label($label, '');?>
    <?=CHtml::dropDownList($name, $model[$attribute], $data,[
        'class'=>'form-control',
        'onChange'=>$onChange,
        'empty'=>$empty,
        'encode'=>false
    ])?>
</div>
