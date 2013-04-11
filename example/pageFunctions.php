<?php


function pageStart(){
//party like it's 1995
    echo <<< END
<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

 <style type="text/css">
.bordered{
    border: 2px solid #000000;
}

form {
	margin-bottom: 0;
}

</style>

</head>
<body>

END;

}


function pageEnd(){

    echo <<< END
</body>
</html>
END;

}


?>