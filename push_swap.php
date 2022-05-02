<?php

$actionList = [];

function push_swap(&$argv, &$actionList){
    array_shift($argv);
    $la = $argv;
    $lb = [];
    if (testIfSorted($la) == true){
        return;
    };
    $copy = $la;
    sort($copy);
    $chunked = array_chunk($copy, 150);
    while(isset($la[0])){
        if (in_array($la[0],$chunked[0])){
            $index = array_search($la[0],$chunked[0]);
            unset($chunked[0][$index]);
            pb($la,$lb,$actionList);
        }else{
            ra($la,$lb,$actionList);
        }
        if(empty($chunked[0])){
            array_shift($chunked);
        }
    } 
    
    sort_numbers($la,$lb,$actionList);
    $stringList = implode(' ',$actionList);
    echo($stringList.PHP_EOL);
}


/***************basics functions****************/
function sa(Array &$list1, Array &$list2, &$actionList){
    [$list1[0],$list1[1]] = [$list1[1],$list1[0]];
    array_push($actionList, __FUNCTION__);
}
function sb(Array &$list1, Array &$list2, &$actionList){
    [$list2[0],$list2[1]] = [$list2[1],$list2[0]];
    array_push($actionList, __FUNCTION__);
}
function sc(Array &$list1, Array &$list2, &$actionList){
    sa($list1, $list2, $actionList);
    sb($list1, $list2, $actionList);
    array_push($actionList, __FUNCTION__);
}
function pa(Array &$array1, Array &$array2, &$actionList){
    if(isset($array2[0])){
        $var = array_shift($array2);
        array_unshift($array1, $var);
        array_push($actionList, __FUNCTION__);
    }
}
function pb(Array &$array1, Array &$array2, &$actionList){
    if(isset($array1[0])){
        $var = array_shift($array1);
        array_unshift($array2, $var);
        array_push($actionList, __FUNCTION__);
    }
}
function ra(Array &$array1, Array &$array2, &$actionList){
    $var = array_shift($array1);
    array_push($array1, $var);
    array_push($actionList, __FUNCTION__);
}
function rb(Array &$array1, Array &$array2, &$actionList){
    $var = array_shift($array2);
    array_push($array2, $var);
    array_push($actionList, __FUNCTION__);
}
function rr(Array &$array1, Array &$array2, &$actionList){
    ra($array1,$array2, $actionList);
    rb($array1,$array2, $actionList);
    array_push($actionList, __FUNCTION__);
}
function rra(Array &$array1, Array &$array2, &$actionList){
    $var = array_pop($array1);
    array_unshift($array1, $var);
    array_push($actionList, __FUNCTION__);
}
function rrb(Array &$array1, Array &$array2, &$actionList){
    $var = array_pop($array2);
    array_unshift($array2, $var);
    array_push($actionList, __FUNCTION__);
}
function rrr(Array &$array1, Array &$array2, &$actionList){
    rra($array1, $array2, $actionList);
    rrb($array1, $array2, $actionList);
    array_push($actionList, __FUNCTION__);
}

/****************Custom functions***************/
function testIfSorted($arr1){
    $j = 0;
    $len = count($arr1)-1;
    for ($i=0; $i < $len ; $i++) { 
        if ($arr1[$i] <= $arr1[$i + 1]) {
            $j++;
        }else{
            return false;
        }
        if($j == $len){
            return true;
        }
    }
    return true;
}

function sort_numbers(Array &$la, Array &$lb, &$actionList){
    if(!isset($la[0])&& isset($lb)){
        $sortedArray = $lb;
        sort($sortedArray);
        $len = count($lb);
        while(isset($lb[0])){
            $indexOfMax = array_search(array_pop($sortedArray), $lb);
            
            if($indexOfMax < ($len/2 - 1)){
                for ($i=0; $i < $indexOfMax; $i++) { 
                    rb($la,$lb,$actionList);
                }
                pa($la,$lb,$actionList);
            }else{
                for ($indexOfMax ; $indexOfMax < $len; $indexOfMax++) { 
                    rrb($la,$lb,$actionList);
                }
                pa($la,$lb,$actionList);
            }
            $len--;
        }
    }
}

// $arr1 = (range(-3000,1000));
// $arr2 = (range(-2000,4000));
// shuffle($arr1);
// shuffle($arr2);
// $arr = array_merge($arr1,$arr2);

push_swap($argv, $actionList);