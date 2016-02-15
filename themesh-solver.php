<?php

if ( ! isset($argv[1]))
    die("Please input first argument\n");

if ( ! isset($argv[2]))
    die("Please input second argument\n");

// check valid result
$result = (int) $argv[2];
if (empty($result))
    die("Second argument is invalid\n");

// sanitize argument
$arguments = preg_replace('/[^0-9][^-]/', '', $argv[1]);

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
        echo 'Possible solution : ', $the_answer, "\n";
    
    $the_answer = '';

    $loop ++;
endforeach;

echo "Looping $loop times";new_line();
echo $the_answer ? 'Answer : ' . $the_answer : 'No answer';
new_line();
die();

function new_line($multiplier = 1)
{
    echo str_repeat("\n", $multiplier);
}