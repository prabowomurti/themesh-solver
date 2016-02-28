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

    $count_numbers = count($numbers);
    $combination = pow(2, $count_numbers);

    for ($i = 0; $i < $combination; $i ++)
        $operators[] = str_pad(decbin($i), $count_numbers, '0', STR_PAD_LEFT);

    // there is no way all numbers is subtracted, so we pop out the last element of array
    array_pop($operators);

    // the loop
    $loop = 0;
    $the_answer = '';
    foreach($operators as $operator):
        $comparator = 0;
        $loop ++;
        $operator = str_split($operator);
        
        foreach ($numbers as $key => $number)
        {
            $op = pow(-1, $operator[$key]);
            $comparator = $comparator + ($op * $number);
            $the_answer .= ($op > 0 ? ' +' : ' -') . $number;
        }

        if ($comparator == $result)
            break; // answer found
        elseif ($comparator == 0)
            echo 'Possible solution : ', $the_answer, "<br />";
        
        $the_answer = '';

    endforeach;

    echo "Looping $loop time(s)";
    new_line();
    echo 'Numbers  : ', implode(',', $numbers);new_line();
    echo 'Result : ', $result;
    new_line();
    echo $the_answer ? '<strong>Answer : ' . $the_answer . '</strong>' : '<span style="color: red">No answer</span>';
    new_line();
    
endif;
