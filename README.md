Yii module for choose country, region and city

###Uses###

1) Extract the contents of the archive into a `modules/residence` folder.

2) Import to your database three dumps from the `dump_table` folder

3) Add into config:

```
...
'modules'=>[
    'residence'
]
```

4) Add to the page:

```
$this->widget('residence.widget.Choose',array(
    'model'=>$userModel, //Model with country, region and city properties or array with same keys
    'title'=>'Choose your location', //Label before block,
    'prefix'=>'User' // if you use array in the model parameter, you can add prefix into select name
                     // if I am setting User I will get User[country], User[region], User[city] into $_POST
));
```

Getters and Setters for model (not necessarily, but easier to work)

```
/**
 * @return mixed
 */
public function getCountry()
{
    $country='';
    if($this->_country)
        $country = $this->_country;
    else if($this->city)
        $country = $this->savedCity->id_country;
    return $this->_country=$country;
}


/**
 * @param mixed $countries
 */
public function setCountry($country)
{
    $this->_country = $country;
}


/**
 * @return mixed
 */
public function getRegion()
{
    $region='';
    if($this->_region)
        $region = $this->_region;
    else if($this->cities)
        $region = $this->savedCity->id_region;
    return $this->_region=$region;
}

/**
 * @param mixed $region
 */
public function setRegion($region)
{
    $this->_region = $region;
}

/**
 * @return mixed
 */
public function getCity()
{
    $city='';
    if($this->_city)
        $city = $this->_city;
    else if($this->cities)
        $city = $this->savedCity->id_city;

    return $this->_city=$city;
}

/**
 * @param mixed $city
 */
public function setCity($city)
{
    $this->_city = $city;
}

/**
 * @return mixed
 */
public function getSavedCity()
{
    $cities = '';
    if($this->_savedCity)
        $cities = $this->_savedCity;
    else if($this->city_id)
        $cities = Cities::model()->findByPk($this->city_id);
    return $this->_savedCity=$cities;
}

/**
 * @param mixed $cities
 */
public function setSavedCity($city)
{
    $this->_cities = $city;
}
```

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/bookin/yii-choose-location/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

