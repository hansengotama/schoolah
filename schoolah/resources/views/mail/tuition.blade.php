<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Email</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-size: 100%;
            font-family: 'Avenir Next', "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            line-height: 1.65;
        }
        img {
            max-width: 100%;
            margin: 0 auto;
            display: block;
        }
        body, .body-wrap {
            width: 100% !important;
            height: 100%;
            background: #f8f8f8;
        }
        a {
            color: #99cada;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-bottom: 20px;
            line-height: 1.25;
        }
        h1 {
            font-size: 32px;
        }
        h2 {
            font-size: 28px;
        }
        h3 {
            font-size: 24px;
        }
        h4 {
            font-size: 20px;
        }
        h5 {
            font-size: 16px;
        }
        p, ul, ol {
            font-size: 16px;
            font-weight: normal;
            margin-bottom: 20px;
        }
        .container {
            display: block !important;
            clear: both !important;
            margin: 0 auto !important;
            max-width: 580px !important;
        }
        .container table {
            width: 100% !important;
            border-collapse: collapse;
        }
        .container .head {
            padding: 80px 0;
            background: #99cada;
            color: white;
        }
        .container .head h1 {
            margin: 0 auto !important;
            max-width: 90%;
            text-transform: uppercase;
        }
        .container .content {
            background: white;
            padding: 30px 35px;
        }
        .container .content.footer {
            background: none;
        }
        .container .content.footer p {
            margin-bottom: 0;
            color: #888;
            text-align: center;
            font-size: 14px;
        }
        .container .content.footer a {
            color: #888;
            text-decoration: none;
            font-weight: bold; }
        .container .content.footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <table class="body-wrap">
        <tr>
            <td class="container">
                <table>
                    <tr>
                        <td style="text-align: center" class="head">
                            <h1>Schoolah</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="content">
                            <h3 style="color: black !important;text-align: center">Payment Reminder </h3>
                            <p style="color: black !important;">Dear, <b>Mr/Mrs {{ $e_message['name'] }}</b></p>
                            <p style="color: black !important;">
                                Your outstanding bill is <b>Rp {{ $e_message['price'] }},-</b> for the following :
                            </p>
                            <table>
                                <tr>
                                    <td style="text-align: left">
                                        <p style="color: black !important;">
                                            Student Name : <b>{{ $e_message['name'] }}</b> <br>
                                            Description : <b>{{ $e_message['description'] }}</b> <br>
                                        </p>
                                        <p style="color: black !important;">
                                            This is a gentle reminder to make the payment by <b>{{ $e_message['dueDate'] }}</b>.
                                        </p>
                                        <p style="color: red;">
                                            Please upload the proof of transaction to Schoolah once payment has been made.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: black !important;">Thank you for your attention and please reach me if you have any questions. </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="container">
                <table>
                    <tr>
                        <td class="content footer" style="text-align: center">
                            <p>Sent by <a href="#">Schoolah Indonesia</a></p>
                            <p><a href="mailto:">schoolahhh@gmail.com</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>