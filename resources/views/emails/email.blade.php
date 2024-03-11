<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style type="text/css">

        /*--- custom ----*/

        @media only screen and (max-width: 640px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff;
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }

            table[class=devicewidth] {
                width: 440px !important;
                text-align: center !important;
            }

            table[class=devicewidthinner] {
                width: 420px !important;
                text-align: center !important;
            }

            table[class="sthide"] {
                display: none !important;
            }

            img[class="bigimage"] {
                width: 420px !important;
                height: 219px !important;
            }

            img[class="col2img"] {
                width: 420px !important;
                height: 258px !important;
            }

            img[class="image-banner"] {
                width: 440px !important;
                height: 106px !important;
            }

            td[class="menu"] {
                text-align: center !important;
                padding: 0 0 10px 0 !important;
            }

            td[class="logo"] {
                padding: 10px 0 5px 0 !important;
                margin: 0 auto !important;
            }

            img[class="logo"] {
                padding: 0 !important;
                margin: 0 auto !important;
            }
        }

        @media only screen and (max-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff;

                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }

            table[class=devicewidth] {
                width: 280px !important;
                text-align: center !important;
            }

            table[class=devicewidthinner] {
                width: 260px !important;
                text-align: center !important;
            }

            table[class="sthide"] {
                display: none !important;
            }

            img[class="bigimage"] {
                width: 260px !important;
                height: 136px !important;
            }

            img[class="col2img"] {
                width: 260px !important;
                height: 160px !important;
            }

            img[class="image-banner"] {
                width: 280px !important;
                height: 68px !important;
            }
        }</style>
</head>
<body
    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; padding: 0; background: #f6f4f5; width: 100%;">

<div class="block">
    <!-- Start of preheader -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
           st-sortable="preheader"
           style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin: 0; padding: 0; width: 100%; line-height: 100%;">
        <tbody>
        <tr>
            <td width="100%" style="border-collapse: collapse;">
                <table width="580" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth"
                       style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                    <tbody>
                    <!-- Spacing -->
                    <tr>
                        <td width="100%" height="50" style="border-collapse: collapse;"></td>
                    </tr>
                    <!-- Spacing -->
                    <tr>
                        <td align="right" valign="center" st-content="preheader"
                            style="border-collapse: collapse; font-family: Helvetica, arial, sans-serif; font-size: 10px; color: #999999;">
                            <!--							If you cannot read this email, please  <a class="hlite" href="#" style="text-decoration: none; color: #ffffff">click here</a>-->
                        </td>
                    </tr>
                    <!-- Spacing -->
                    <tr>
                        <td width="100%" height="5" style="border-collapse: collapse;"></td>
                    </tr>
                    <!-- Spacing -->
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- End of preheader -->
</div>
<div class="block">
    <!-- start of header -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
           st-sortable="header"
           style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin: 0; padding: 0; width: 100%; line-height: 100%;">
        <tbody>
        <tr>
            <td style="border-collapse: collapse;">
                <table width="580" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" align="center"
                       class="devicewidth" hlitebg="edit" shadow="edit"
                       style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                    <tbody>
                    <tr>
                        <td style="border-collapse: collapse;">
                            <!-- logo -->
                            <table cellpadding="0" cellspacing="0" border="0" align="center"
                                   class="devicewidth"
                                   style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                <tbody>
                                <tr>
                                    <td valign="middle" align="center" class="logo"
                                        style="border-collapse: collapse; padding: 10px; background: {{ $email['color'] }}">
                                        <div class="imgpop" style="width: 270px;">
                                            <a href="{{ $email['app_url'] }}"><img src="{{ $email['logo'] }}" alt="logo"
                                                                                border="0"
                                                                                st-image="edit" class="logo"
                                                                                style="-ms-interpolation-mode: bicubic; display: block; border: none; outline: none; text-decoration: none; width: 270px;"></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="center" class="logo"
                                        style="border-collapse: collapse; text-transform: uppercase; font-weight: 700; padding-top: 10px; color:{{ $email['color'] }}">
                                        {{ $email['subject'] }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <!-- end of header -->
</div>


<div class="block">
    <!-- Full + text -->
    <table width="100%" bgcolor="#f6f4f5" cellpadding="0" cellspacing="0" border="0" id="backgroundTable"
           st-sortable="fullimage"
           style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin: 0; padding: 0; width: 100%; line-height: 100%;">
        <tbody>
        <tr>
            <td style="border-collapse: collapse;">
                <table bgcolor="#ffffff" width="580" align="center" cellspacing="0" cellpadding="0" border="0"
                       class="devicewidth" modulebg="edit"
                       style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                    <tbody>
                    <tr>
                        <td width="100%" height="20" style="border-collapse: collapse;"></td>
                    </tr>
                    <tr>
                        <td style="border-collapse: collapse;">
                            <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0"
                                   class="devicewidthinner"
                                   style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-bottom: 30px;">
                                <tbody>
                                @if(isset($email['name']))
                                    <tr>
                                        <td class="paragraph"
                                            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; color: #666666; text-align: left; line-height: 22px; padding-left: 20px;">
                                            Vārds: {{ $email['name'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="paragraph"
                                            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; color: #666666; text-align: left; line-height: 22px; padding-left: 20px;">
                                            Epasts: {{ $email['email'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="paragraph"
                                            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; color: #666666; text-align: left; line-height: 22px; padding-left: 20px;">
                                            Ziņa: {{ $email['message'] }}
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($user['name']))
                                    <tr>
                                        <td class="greet"
                                            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 16px; font-weight: 700; color: #333333; text-align: left; line-height: 20px; padding-left: 20px;">
                                            {{ 'Hi, ' . $user['name'] }},
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($email['message']))
                                    <tr>
                                        <td class="paragraph"
                                            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; color: #666666; text-align: left; line-height: 22px; padding-left: 20px;">
                                            {{ $email['message'] }}
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($email['body']))
                                    <tr>
                                        <td class="paragraph"
                                            style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; color: #666666; text-align: left; line-height: 22px; padding-left: 20px;">
                                            {{ $email['body'] }}
                                            @if(isset($email['body_2']))
                                                <br>{{ $email['body_2'] }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @if(isset($email['link']) || isset($email['confirm_code']))
                                    <tr>
                                        <td style="border-collapse: collapse;">
                                            <table height="36" align="center" valign="middle" border="0" cellpadding="0"
                                                   cellspacing="0" class="tablet-button" st-button="edit"
                                                   style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
                                                <tbody>
                                                <tr>
                                                    @if(isset($email['link']))
                                                        <td width="auto" align="center" valign="middle" height="36"
                                                            style="border-collapse: collapse; background-color: {{ $email['color'] }}; border-radius: 4px;background-clip: padding-box; font-size: 13px; font-family: Helvetica, arial, sans-serif; text-align: center; color: #ffffff; font-weight: 300;">
                                                        <span style="color: #ffffff; font-weight: 300;">
                                                            <a href="{{ $email['link'] }}"
                                                               style="color: #ffffff; text-align: center; text-decoration: none; display: block; padding-left: 25px; padding-right: 25px; background-clip: padding-box; height: 36px; line-height: 36px;">{{ $email['button_name'] }}</a>
	                                                    </span>
                                                        </td>
                                                    @endif
                                                    @if(isset($email['confirm_code']))
                                                        <td width="auto" align="center" valign="middle" height="36"
                                                            style="font-size: 13px; font-family: Helvetica, arial, sans-serif; text-align: center; color: #000000; font-weight: 300; line-height: 36px;">
                                                            <h2>{{ $email['confirm_code'] }}</h2>
                                                        </td>
                                                    @endif
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endif
{{--                                <tr>--}}
{{--                                    <td style="padding-top:10px;"></td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td class="paragraph"--}}
{{--                                        style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; color: #666666; text-align: left; line-height: 22px; padding-top:10px; border-top: 1px solid #f6f6f6; padding-left: 20px;">--}}
{{--                                        {{ $email['footer']['contact_us_text_1'] }} <a--}}
{{--                                            href="{{ env('APP_URL') }}/customer-service"--}}
{{--                                            target="_blank">{{ $email['footer']['contact_us'] }}</a>, {{ $email['footer']['contact_us_text_2'] }}--}}
{{--                                        <br>--}}
{{--                                        {{ $email['footer']['cheers'] }}<br>--}}
{{--                                        {{ env('APP_NAME') }}--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
                                </tbody>
                            </table>

{{--                            <table bgcolor="#f6f6f6" width="580" align="center" cellspacing="0" cellpadding="0"--}}
{{--                                   border="0"--}}
{{--                                   class="devicewidthinner"--}}
{{--                                   style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">--}}
{{--                                <tbody>--}}
{{--                                <tr>--}}
{{--                                    <td style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; text-align: center; line-height: 22px; padding-top: 30px;">--}}
{{--                                        <a style="color: #000; font-weight: 600; text-decoration: none; padding-right: 10px; border-right: 1px solid #666666"--}}
{{--                                           href="{{ env('APP_URL') }}/customer-service/privacy">{{ $email['footer']['privacy_policy'] }}</a>--}}
{{--                                        <a style="color: #000; font-weight: 600; text-decoration: none; padding-right: 10px; border-right: 1px solid #666666"--}}
{{--                                           href="{{ env('APP_URL') }}/customer-service">{{ $email['footer']['contact_us'] }}</a>--}}
{{--                                        <a style="color: #000; font-weight: 600; text-decoration: none;"--}}
{{--                                           href="{{ env('APP_URL') }}/education/daily-market-analysis">{{ $email['footer']['read_our_blog'] }}</a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; text-align: center; line-height: 22px; padding-top: 10px;">--}}
{{--                                        <a href="#">--}}
{{--                                            <img style="width: 30px; padding-right: 10px" alt="Facebook"--}}
{{--                                                 src="{{ env('APP_URL') }}/images/logos/email-facebook.png"--}}
{{--                                                 title="Facebook">--}}
{{--                                        </a>--}}
{{--                                        <a href="#">--}}
{{--                                            <img style="width: 30px; padding-right: 10px" alt="Instagram"--}}
{{--                                                 src="{{ env('APP_URL') }}/images/logos/email-instagram.png"--}}
{{--                                                 title="Instagram">--}}
{{--                                        </a>--}}
{{--                                        <a href="#">--}}
{{--                                            <img style="width: 30px;" alt="Twitter"--}}
{{--                                                 src="{{ env('APP_URL') }}/images/logos/email-twitter.png"--}}
{{--                                                 title="Twitter">--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; color: #666; text-align: center; line-height: 22px;">--}}
{{--                                        {{ $email['footer']['copyright'] }} {{ now()->year }} <span--}}
{{--                                            style="font-weight: 600; color:{{ $email['color'] }}">{{ env('APP_NAME') }}</span>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td valign="middle" align="center" class="logo"--}}
{{--                                        style="border-collapse: collapse; padding: 10px">--}}
{{--                                        <a href="{{ env('APP_URL') }}"><img src="{{ $email['logo'] }}" alt="logo"--}}
{{--                                                                            border="0"--}}
{{--                                                                            st-image="edit" class="logo"--}}
{{--                                                                            style="-ms-interpolation-mode: bicubic; display: block; border: none; outline: none; text-decoration: none; width: 100px;"></a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>

</body>
</html>
