<!DOCTYPE html >
<html>
<head>
    <title>Themesh Game Solver -- v1.0</title>
</head>
<body>
<form method="post">
    Please input the parameter, separated by a space. Eg: "5413 5"
    <input type="text" name="parameter" autofocus />
    <input type="submit" />
</form>

<?php
if (isset($_POST['parameter'])):

    function new_line($multiplier = 1)
    {
        echo str_repeat("<br />", $multiplier);
    }

    $argv = explode(' ', $_POST['parameter']);

    if ( empty($argv[0]))
        die("Please input first argument\n");

    if ( ! isset($argv[1]))
        die("Please input second argument\n");

    // check valid result
    $result = (int) $argv[1];
    if (empty($result))
        die("Second argument is invalid\n");

    // sanitize argument
    $arguments = preg_replace('/[^0-9][^-]/', '', $argv[0]);

    // $additional_operators = substr_count('-', $arguments);
    $numbers = str_split(preg_replace('/-/', '', $arguments));

    $count_numbers = count($numbers);
    $combination = pow(2, $count_numbers);

    for ($i = 0; $i < $combination; $i ++)
        $operators[] = str_pad(decbin($i), $count_numbers, '0', STR_PAD_LEFT);

    // the loop
    $loop = 1;
    $the_answer = '';
    foreach($operators as $operator):
        $comparator = 0;
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

        $loop ++;
    endforeach;

    echo "Looping $loop times";
    new_line();
    echo $the_answer ? 'Answer : ' . $the_answer : 'No answer';
    new_line();
    die();

    
endif;
?>

</body>
</html>
