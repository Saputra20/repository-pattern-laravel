<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Email</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700|Poppins:300,400,500,600,700&display=swap');

        *,
        ::after,
        ::before {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            color: #7F7F7F;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            letter-spacing: 0.3px;
            color: #000;
            margin-top: 0;
        }

        p {
            margin-top: 0;
            font-size: 14px;
            line-height: 1.5;
        }

        small {
            margin-bottom: 8px;
            display: block;
        }

        .wrapper {
            background: #f9f9f9;
            position: relative;
            width: 100%;
            /* height: 100%; */
            padding: 0;
            margin: 0;
        }

        .box-email {
            background: #ffffff;
            max-width: 90%;
            border: 1px solid #eee;
            margin: 0 auto;
            height: 100%;
        }

        .content {
            padding: 1.5rem;
        }

        .footer {
            background: #eee;
            padding: 1.5rem;
        }

        .footer p {
            font-size: 13px;
            margin-bottom: 5px;
        }

        .footer a {
            text-decoration: none;
            color: #48c335;
            font-weight: 500;
        }

        .footer .top {
            text-align: center;
        }

        .footer .bottom {
            margin-top: 2rem;
        }

        .logo img {
            max-height: 100%;
            width: 60px;
        }

        .illustrasi {
            width: 100%;
            display: flex;
            margin: 2rem 0;
        }

        .illustrasi img {
            margin: 0 auto;
            width: 250px;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
            margin-bottom: 1rem;
        }

        .text-primary {
            color: #48C335 !important;
        }

        .text-default {
            color: #000 !important;
        }

        .col-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col-12 {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
            position: relative;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
        }

        .btn {
            text-decoration: none;
            padding: 15px 16px;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
            display: block;
            text-align: center;
        }

        .btn-primary {
            background: #48C335;
            border: 1px solid #48C335;
            color: #fff;
        }

        .btn-outline-primary {
            background: transparent;
            color: #48C335;
            border: 1px solid #48C335;
        }

        .pull-right {
            float: right;
        }

        hr {
            height: 0;
            border: 0;
            border-top: 1px solid #eee;
            margin: 15px 0;
        }

        .title-pembayaran {
            margin-bottom: 15px;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .font-100 {
            font-weight: 100 !important;
        }

        .font-200 {
            font-weight: 200 !important;
        }

        .font-300 {
            font-weight: 300 !important;
        }

        .font-400 {
            font-weight: 400 !important;
        }

        .font-500 {
            font-weight: 500 !important;
        }

        .font-600 {
            font-weight: 600 !important;
        }

        .font-700 {
            font-weight: 700 !important;
        }

        .font-800 {
            font-weight: 800 !important;
        }

        .font-900 {
            font-weight: 900 !important;
        }

        .alert {
            background: rgba(247, 183, 49, 0.3);
            padding: 1rem;
            text-align: center;
            color: #666;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid rgba(247, 183, 49, 0.8);
            border-radius: 6px;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="wrapper row">
        <div class="box-email">
            <div class="content">
                <div class="logo">
                </div>
                <br>
                <h3>SELAMAT DATANG DI .</h3>
                <p>Jangan berikan otp kepada siapapun </p><br>

                <p>{{ $otp }}</p><br>
                <hr>

                <p>Email dibuat secara otomatis. Mohon tidak mengirimkan balasan ke email ini.</p>

            </div>

            <div class="footer">
                <div class="bottom">
                    <p>Sample</p>
                    <p>© PT .. - All Right Reserved 2021.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>