<?php

namespace Helper {


    use Exception;
    use Faker\Factory;
    use SplFixedArray;

    function cors()
    {
        header('content-type: application/json');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }



    class Helper
    {
        public static function randomId(){

            $Faker  = Factory::create();
               $number =  $Faker->randomNumber();
               $letter = [];
                    for($i =0; $i< 5;$i++ ){
                         $letter[] = $Faker->randomLetter;
                    }
                    $letter = implode('',$letter);
            return  "$letter$number";
        }


        public static function searchValue($searchedItem,array $array){
            function search($searchedItem,$array,$low,$high,$map = array()){
                if($low<$high ){
                    $pivot = ($low + $high) /2;
                    $map[] = $array[$pivot];
                    if($array[$pivot] == $searchedItem){
                        return $map;
                    }elseif(is_array($array[$pivot]))
                        search($searchedItem,$array[$pivot],$low,count($array[$pivot]),$map);
                    //search($searchedItem,$array,$low,$pivot-1,$map);
                    //search($searchedItem,$array,$pivot+1,$high,$map);
                }else
                    return $array;

            }
            return search($searchedItem,$array,0,count($array));


        }

        //Add element to Spl Fixed Array
        //array will increase size by 1
        //and last element will be new item
        public static function addElementToArray(SplFixedArray $array, $element){
            $length = $array->getSize();
            $array->setSize($length);
            $array[$length -1] = $element;

        }
        //!NOTE!
        //need configure composer included path or set include paths
        public static function getIniConfiguration($name,$obj = false)
        {
            $iniData = parse_ini_file(stream_resolve_include_path($name . '.ini'));
            return ($obj) ? (object)$iniData : $iniData;

        }
        //get easier way allowed property
        //Example allowProperties ["name" => value]
        public static function getterConfig(array $allowsProperty,$name, $class )
        {
            return (property_exists($class,$name)) ? $class->{$name}: new Exception(`Value of ${class} not exisit or isn't accesable`);
        }
        //set easier way allowed property
        public static function setterConfig(array $allowsProperty,$name,$value,string $class )
        {
            $allowsProperty[$name] =  (property_exists($class,$name)) ? $value : new Exception(`Value of ${class} not exisit or isn't accesable`);
        }
        public static function dataOutputCreator( $data,array &$array){

            $array[] = $data;
            return $data;
        }
        public static function deleteIntersect(array $mainArr, array $subArra){
            $noIntersectedArray = array();

            foreach ($subArra as $index ){
                if(!in_array($index,$mainArr))
                    $noIntersectedArray[] = $index;
            }
            return $noIntersectedArray;
        }

    }
}