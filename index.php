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
            <div class="col-xs-12 col-lg-6 col-md-6">
                <form method="post" action="apalah" onsubmit="return process()">
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

        <div class="row">
            <div class="col-xs-12 col-lg-6 col-md-6" id="the_answer">
            </div>
        </div>
        
    <hr />
    <footer>Source code : <a href="https://github.com/prabowomurti/themesh-solver">themesh-solver</a></footer>
    </div> <!-- /container -->

<script type="text/javascript">
function process(e)
{
    if (!e) e = window.event;
    e.preventDefault();

    var xhttp;
    var data;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == XMLHttpRequest.DONE && xhttp.status == 200) 
        {
            document.getElementById("the_answer").innerHTML = xhttp.responseText;
        }
    };

    xhttp.open("POST", "process.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    data = 
        'parameter=' + document.getElementById('parameter').value + 
        '&result=' + document.getElementById('result').value;
    xhttp.send(data);
}

</script>

</body>
</html>