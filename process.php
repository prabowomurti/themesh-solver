<?php
if (isset($_POST['parameter'])):


    /**
     * Echo some <br />
     * @param  integer $multiplier
     */
    function new_line($multiplier = 1)
    {
        echo str_repeat("<br />", $multiplier);
    }

    /**
     * Echoing array of answer or possible solutions
     * @param  array   $answer the array containing answer
     * @param  boolean $flag   if true, show answer in a fancier way
     */
    function display_answer($answer = array(), $flag = false)
    {
        $string = '';
        foreach($answer as $value)
            $string .= $value > 0 ? ' +' . $value : ' ' . $value;

        echo $flag ? '<strong>Answer : ' . $string . '</strong>' : $string;
    }

    /**
     * Create combination from array
     * 
     * @param  array   $arrays 
     * @param  integer $i      
     * @return array all combination created          
     */
    function create_possible_solutions($arrays = array(), $i = 0)
    {
        if ( ! isset($arrays[$i])) {
            return array();
        }

        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = create_possible_solutions($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ? 
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }

    /**
     * Create all combination from possible solutions
     * 
     * @param  array  $a
     * @return array    
     */
    function create_combination($a = array())
    {
        
        $len  = count($a);
        $list = array();

        for($i = 1; $i < (1 << $len); $i++) {
            $c = [];
            for($j = 0; $j < $len; $j++)
                if($i & (1 << $j))
                    $c[]= $a[$j];
                $list[] = $c;
            }

        return $list;
    }

    $parameter = (int) $_POST['parameter'];

    if ( empty($parameter))
        die("Please input parameter");

    if ( ! isset($_POST['result']))
        die("Please input the desired result");

    // check valid result
    $result = (int) $_POST['result'];
    if (empty($result))
        die("Result is invalid\n");

    $numbers = str_split($parameter);

// using do - while so we can break peacefully instead of using die();
do {

    // sanitizing input and create the negative number as a pair
    foreach ($numbers as $key => $value)
        $paired_numbers[$key] = array($value, -$value);

    $numbers = create_possible_solutions($paired_numbers);
    array_pop($numbers); // pop up last element, since it's impossible to have negative numbers

    //=========================================
    // METHOD #0, no additional operator
    //=========================================
    foreach ($numbers as $combination) 
    {
        if ( ! is_array($combination))
            $combination = array($combination);

        if (array_sum($combination) == $result)
        {
            display_answer($combination, true);
            break 2;
        }
        elseif (array_sum($combination) == 0)
        {
            echo 'Possible answer : ';
            display_answer($combination);
            new_line();
        }
    }

    //=========================================
    // METHOD #1, using only 1 operator
    //=========================================
    foreach ($numbers as $combination)
    {
        if ( ! is_array($combination))
            $combination = array($combination);

        $list = create_combination($combination); // 1, 2, -3 will produce 1, 2, -3, (1 2), (1, -3), (2, -3), (1, 2, -3)

        foreach ($list as $part)
        {
            $sum_part = array_sum($part);
            
            $temp_part = $part;
            $rest = array_filter($combination, 
                function ($val) use (&$temp_part) { 
                    $key = array_search($val, $temp_part);
                    if ( $key === false ) return true;
                    unset($temp_part[$key]);
                    return false;
                }
            );

            $sum_rest = array_sum($rest);
            if ($sum_part % 2 == 0)
            {
                $temp = $sum_part / 2 + $sum_rest;
                if ($temp == $result) // got the winner
                {
                    echo '<strong>Answer : (', implode(',', $part), ')', '/2 ';
                    display_answer($rest);
                    echo '</strong>';
                    break 3;
                }
                elseif ($temp == 0)
                {
                    echo 'Possible answer : (', implode(',', $part), ')', '/2 ';
                    display_answer($rest);
                    new_line();
                }
            }

            $temp = $sum_part * 2 + $sum_rest;
            if ($temp == $result) // the winner
            {
                echo '<strong>Answer : (', implode(',', $part), ')', 'x2 ';
                display_answer($rest);
                break 3;
            }
            elseif ($temp == 0)
            {
                echo 'Possible answer : (', implode(',', $part), ')', 'x2 ';
                display_answer($rest);
                new_line();
            }
        }
        
    } // end of METHOD #1

    echo '<span style="color: red">No answer</span>';


} while (0);

endif;
