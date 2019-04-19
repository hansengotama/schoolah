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
            color: #71bc37;
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
            background: #71bc37;
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
                <p>
                </p>
                <table>
                    <tr>
                        <td style="text-align: center" class="head">
                            <h1>Schoolah</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="content">
                            <h2 style="color: black !important;">Hi, {{ $e_message['name'] }}</h2>
                            <p style="color: black !important;">
                                Thanks for trusting Schoolah, hope you enjoy using Schoolah.
                                Below is your username and password please keep it and don't tell it to other people.
                            </p>
                            <table>
                                <tr">
                                    <td style="text-align: left">
                                        <p style="color: black !important;">
                                            Username : <b style="color: black !important; text-decoration: none !important;">{{ $e_message['email'] }}</b> <br>
                                            Password : <b>{{ $e_message['password'] }}</b> <br>
                                            School : <b>{{ $e_message['school_name'] }}</b> <br>
                                            Role : <b>{{ $e_message['role'] }}</b>
                                        </p>
                                        <p style="color: black !important;">
                                            Please change your password after you login!
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: black !important;">“Work hard, be kind and amazing things will happen.” </p>

                            <p><em style="color: black !important;">– Conan O'Brien</em></p>

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