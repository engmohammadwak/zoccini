<!DOCTYPE html>
<html>
<head>
    <title>تطبيق زوكيني</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <style type="text/css">
        @media screen and (max-width: 640px), screen and (max-device-width: 640px) {

            table[class="table-responsive"] {
                width: 100%;
            }

            table[class="table-responsive"] td {
                display: block;
                width: 48%;
                float: right;
            }

            table[class="table-responsive"] tr {
                display: block;
                /*width: 50%;*/
            }

            table[class="table-responsive"] td img[class="img_"] {
                width: 100%;
            }
        }

        @media screen and (max-width: 550px), screen and (max-device-width: 550px) {
            table[class="table-responsive"] td {
                /*display: block;*/
                width: 100%;
            }

            table[class="table-responsive-2"] tr {
                display: block;
                /*width: 50%;*/
            }

            table[class="offer-table"] {
                margin-top: 20px;
                margin-bottom: 20px;
            }

            table[class="offer-table"] td {
                width: 100%;
                display: block;
                text-align: center;
            }

            table[class="offer-table"] td span {
                margin-top: 5px !important;
                margin-bottom: 5px !important;
            }

            table[class="table-responsive-2"] td {
                display: block;
                width: 100%;
            }

            .td_half {
                padding: 0 !important;
            }

            .content_profile {
                padding: 40px 15px 30px 15px;
            }

            .tf_bg {
                height: 300px;
            }

            .p_left, .p_right {
                float: none !important;
                text-align: center;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 20px; background-color: #f6f9fa; direction:rtl">


<div class="container" style="width:100%; max-width:650px; margin:auto;">

    <div>

        <h2>مرحبا بكم في تطبيق زوكيني</h2>
        <h3>السيد/ة {{$request->name}} ;</h3>

        <h3>تمت عملية الدفع بنجاح</h3>
        <h3>المبلغ : $blade_data->price</h3>


    </div>

</div>


</body>
</html>
