<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify Your Email Address</title>
    <style>
        /* Basic styles */
        body {
            font-family: raleway, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
        }

        p {
            color: #6b7280;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        td,
        th {
            padding: 10px;
            text-align: left;
        }

        /* Header */
        .header {
            text-align: left;
            padding: 20px;
        }

        .logo {
            max-width: 200px;
        }

        h3 {
            padding: 0 10px;
            margin: 0;
        }

        /* Content */
        .content {
            padding: 20px;
        }

        .welcome {
            margin: 0;
            padding-bottom: 10px;
            font-size: 16px;
            /* font-weight: bold; */
        }

        .paragraph {
            line-height: 1.5;
        }

        /* Button */
        .button-container {
            padding: 20px 0;
        }

        .button {
            background-color: #0a6ccd;
            color: #fff;
            padding: 16px 24px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 0;
        }

        .button:hover {
            background-color: #2980b9;
        }

        /* Footer */
        .footer {
            text-align: left;
            padding: 20px;
            border-top: 1px solid #ddd;
        }

        .footer-head {
            display: flex;
            margin-bottom: 16px;
        }

        .legal {
            width: fit-content;
            font-size: 14px;
            margin: 0;
        }

        .legal a {
            color: #0a6ccd;
            text-decoration: underline;
        }

        .legal span {
            padding: 0 6px;
        }

        .social-media {
            width: fit-content;
            margin-left: auto;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .social-media a {
            color: #121112;
        }

        .social-media a i {
            font-size: 20px;
        }

        /* Address */
        .address {
            font-size: 14px;
            line-height: 1.5;
            margin-top: 20px;
            margin: 0;
        }

        .address span {
            font-weight: 600;
        }

        .copyright {
            font-size: 14px;
            margin-top: 20px;
            color: #6b7280;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td class="header">
                <img src="https://dev--myhomeng.netlify.app/static/media/onboard-logo.fac3a57cba044a0033517dd88314fcbf.svg"
                    alt="MyHome.NG Logo" class="logo" />
            </td>
        </tr>

        <tr>
            <td>
                <h3>Verify Your Email Address</h3>
            </td>
        </tr>

        <tr>
            <td class="content">
                <p class="welcome">Hi, {{ $userName }}</p>
                <p class="paragraph">
                    We're thrilled to have you on board. To ensure the
                    security of your account and provide you with the best
                    possible experience, please take a moment to verify your
                    email address. Use the following verification code:
                </p>
                <div class="button-container">
                    <p>{{ $verificationCode }}</p>
                </div>
                <p class="paragraph">
                    Thank you for choosing MyHome.NG. We look
                    forward to assisting you.
                </p>
                <p class="best-regards">Best Regards,</p>
                <p class="team">MyHome.NG Team</p>
            </td>
        </tr>

        <tr>
            <td class="footer">
                <div class="footer-head">
                    <p class="legal">
                        <a href="https://dev--myhomeng.netlify.app/terms-and-condition">Terms & Conditions</a>
                        <span>|</span>
                        <a href="https://dev--myhomeng.netlify.app/privacy-policy">Privacy Policy</a>
                    </p>

                    <div class="social-media">
                        <a href="#"><img width="20" height="20"
                                src="https://img.icons8.com/ios/50/instagram-new--v1.png" alt="instagram-new--v1" /></a>
                        <a href="#"><img width="20" height="20"
                                src="https://img.icons8.com/ios-filled/20/facebook-f.png" alt="facebook-f" /></a>
                        <a href="#"><img width="20" height="20"
                                src="https://img.icons8.com/material/24/twitterx--v2.png" alt="twitterx--v2" /></a>
                    </div>
                </div>

                <p class="address">
                    <span>Lagos:</span> Lekki island, Lekki Phase 1 Lagos<br />
                </p>

                <p class="copyright">
                    © 2024 MyHome.NG. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>

</html>