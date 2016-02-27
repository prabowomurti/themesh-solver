<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>The Mesh Solver</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">

        <div class="page-header">
            <h2>The Mesh App Solver &#8212; v1.1</h2>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <form method="post" >
                    <div class="form-group">
                        <label for="parameter">Parameter</label>
                        <input type="number" name="parameter" min="1" id="parameter" class="form-control input-sm" required="required" autofocus placeholder="Eg : 1872" />
                    </div>
                    <div class="form-group">
                        <label for="result">Result</label>
                        <input type="number" name="result" min="1" id="result" class="form-control input-sm" required placeholder="Eg : 8" />
                    </div>
                    <button type="submit" class="btn btn-default btn-sm">Submit</button>
                </form>
            </div>
        </div>

        
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
        die("Please input parameter\n");

    if ( ! isset($_POST['result']))
        die("Please input the desired result\n");

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
?>
    <hr />
    <footer>Source code : <a href="https://github.com/prabowomurti/themesh-solver">themesh-solver</a></footer>
    </div> <!-- /container -->

</body>
</html>