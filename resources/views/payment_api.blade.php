<!DOCTYPE html>
<html>
<head>
    <title>Payment Api</title>
    <meta charset="utf-8"/>
</head>
<body>
<?php
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://foloosi.com/api/v1/api/initialize-setup",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "transaction_amount=" . $price . "&currency=AED&" . optional($user->city)->name . "=Address&customer_city=" . optional($user->city)->name. "&billing_country=" . optional($user->country)->name  . "&billing_state=" . optional($user->city)->name . "&billing_postal_code=000000&customer_name=" . $user->name . "&customer_email=" . $user->email . "&customer_mobile=" . $user->phone,
    CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "merchant_key: test_$2y$10$" . "pzoPoGLc5l6qRhcSUN4-ReP.DLFnxErxTBZOLEwBaSw5kuF0u-eye"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $responseData = json_decode($response, true);
    $reference_token = $responseData['data']['reference_token'];
}
?>
<script type="text/javascript" src="https://www.foloosi.com/js/foloosipay.v2.js"></script>
<script type="text/javascript">
    var reference_token = "<?= $reference_token; ?>";
    var options = {
        "reference_token": reference_token,
        "merchant_key": "test_$2y$10$pzoPoGLc5l6qRhcSUN4-ReP.DLFnxErxTBZOLEwBaSw5kuF0u-eye"

    }
    var fp1 = new Foloosipay(options);
    fp1.open();
    foloosiHandler(response, function (e) {
        if (e.data.status == 'success') {
            console.log(e.data)
            @php

                $blade_data = array(

                    'request' => $user,
                    'price' => $price,

                );

    \Illuminate\Support\Facades\Mail::send('emails.payment', $blade_data, function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('زوكيني - تم عملية الدفع بنجاح')
                        ->from('info@zoccini.com', 'زوكيني');

                });
            @endphp

                window.location.href = "{{url('/success')}}";
        }
        if (e.data.status == 'error') {
            console.log(e.data)
        }
        if (e.data.status == 'closed') {
            console.log(e.data)
        }
    });
</script>
</body>
</html>
