<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Contact Mail</title>
    <style scoped>
        body{ background-color: #ccc; }
        .container{
            width: 80%;
            height: auto;
            margin: 0 auto;
            background-color: #fff;
        }
        .no-top-margin {margin-top: 0!important;}
        .container h1 {text-align: center; margin-bottom: 0;}
        .container p {text-align: center; margin-top: 30px;}
        .container .title img{ float:left; }
        .container .title{
            color: #fff;
            font-size: 36px;
            text-align: center;
            padding: 15px;
            background-color: #367588;
            filter: alpha(opacity=90);
            background-image: -webkit-linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1));
            background-image: linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1));
            border-radius: 4px 4px 0 0;
        }
        .button-verify {
            color: white;
            border-radius: 4px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
            background-color: #367588; /* this is a green */
            padding: 10px 25px;
            text-decoration: none;
        }
        .button-verify:hover {
            filter: alpha(opacity=90);
            background-image: -webkit-linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1));
            background-image: linear-gradient(transparent,rgba(0,0,0,.05) 40%,rgba(0,0,0,.1));
        }
        .margin-top-20 { margin-top: 20px;}
        .but{
            margin-top: 40px;
            text-align: center;
            height: 40px;
        }
        .mar-but-30 {margin-bottom: 30px;}
        .mar-but-20 {margin-bottom: 20px;}
        .mar-but-10 {margin-bottom: 10px;}
        .alg-rht { text-align: right;}
        .cntr {text-align: center;}
        .serial {width: 40px;}
        .orderid {width: 120px;}
        .quantity {width: 60px;}
        .cost{width: 120px;}
        .order-table {width: 100%; height: auto; display: block;}
        .cntr-wdth{margin: 0 auto;}
        td {padding: 10px 5px;border-bottom: 1px solid #ccc;}
        th {padding: 5px 15px;}
    </style>
</head>
<body>
<div class="container">
    <div class="title">Nepal Auto</div>
    <p>Received a new enquiry from the contact page, enquiry is as below: </p>
    <p>Name: {{$fullname}}</p>
    <p>Email: {{$emailid}}</p>
    <p>Message: {!! $bodyMessage !!}</p>

    <p class="mar-but-20">&nbsp;</p>

    <p>Thanks, <br>
        Nepal Auto</p>
    <p class="mar-but-20">&nbsp;</p>
</div>
</body>
</html>
