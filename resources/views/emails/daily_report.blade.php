<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="format-detection" content="telephone=no"> 
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
        <style>
            @import url(http://fonts.googleapis.com/css?family=Roboto:300); /*Calling our web font*/
            /* Some resets and issue fixes */
            #outlook a { padding:0; }
            body{ width:100% !important; -webkit-text; size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; }     
            .ReadMsgBody { width: 100%; }
            .ExternalClass {width:100%;} 
            .backgroundTable {margin:0 auto; padding:0; width:100%;!important;} 
            table td {border-collapse: collapse;}
            .ExternalClass * {line-height: 115%;}           
            /* End reset */
            /* These are our tablet/medium screen media queries */
            @media screen and (max-width: 630px){
                /* Display block allows us to stack elements */                      
                *[class="mobile-column"] {display: block;} 

                /* Some more stacking elements */
                *[class="mob-column"] {float: none !important;width: 100% !important;}     

                /* Hide stuff */
                *[class="hide"] {display:none !important;}          

                /* This sets elements to 100% width and fixes the height issues too, a god send */
                *[class="100p"] {width:100% !important; height:auto !important;}                    

                /* For the 2x2 stack */         
                *[class="condensed"] {padding-top:20px !important; display: block;}

                /* Centers content on mobile */
                *[class="center"] {text-align:center !important; width:100% !important; height:auto !important;}            

                /* 100percent width section with 20px padding */
                *[class="100pad"] {width:100% !important; padding:20px;} 

                /* 100percent width section with 20px padding left & right */
                *[class="100padleftright"] {width:100% !important; padding:0 20px 0 20px;} 

                /* 100percent width section with 20px padding top & bottom */
                *[class="100padtopbottom"] {width:100% !important; padding:20px 0px 20px 0px;}

                /* updated inline style padding */
                *[class="100pad0"] {width:100% !important; padding:0 1rem 1rem 1rem!important;}
            }
       </style>
    </head>
    <body>
        <div width="640" cellspacing="0" cellpadding="0" class="100p" style="background:#ffffff;font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
            <table width="640" cellspacing="0" cellpadding="0" class="100p" style="margin:auto;background:#ffffff url({{ url('/images/emails/img-arrows.png') }}) right bottom no-repeat;min-height:500px;border-left: 1px solid #157d36;border-right: 1px solid #157d36;">
                <tr>
                    <td colspan="2" height="25" style="background:#157D36;"></td>
                </tr>
                <tr>
                    <td colspan="2" height="33" align="center" valign="top" style="height:33px;padding:40px 0 60px;">
                        <img width="139" height="33" src="{{ url('/images/emails/logo.png') }}" style="width:180px;height:40px;" alt="Full Scale logo"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="100pad0" style="padding: 0 20px;">
                        <p style="font-size:20px; color: #000; margin: 0 0 20px 0;font-weight:500;">Hi,</p>
                    </td>
                </tr>
                <tr height="150">
                    <td class="hide" style="padding-left:20px;width:80px;text-align:right;padding-right:5px;" valign="top">
                        <img src="{{ url('/images/emails/icon-check.png') }}" width="25" height="25" alt="icon-check"/>
                    </td>
                    <td class="100pad0" style="padding:0 60px 20px 0;text-align:justify;" valign="top">
                        <h3 style="margin:5px 0;">What I did today:</h3>
                        <p style="margin:0;">
                            {!! $employeeReport->content !!}
                        </p>
                    </td>
                </tr>
                <tr height="150">
                    <td class="hide" style="padding-left:20px;width:80px;text-align:right;padding-right:5px;" valign="top">
                        <img src="{{ url('/images/emails/icon-notes.png') }}" width="25" height="25" alt="icon-notes"/>
                    </td>
                    <td class="100pad0" style="padding:0 60px 20px 0;text-align:justify;" valign="top">
                        <h3 style="margin:5px 0;">What I will be doing the next working day:</h3>
                        <p style="margin:0;">
                            {!! $employeeReport->todo !!}
                        </p>
                    </td>
                </tr>
                <tr height="150">
                    <td class="hide" style="padding-left:20px;width:80px;text-align:right;padding-right:5px;" valign="top">
                        <img src="{{ url('/images/emails/icon-roadblocks.png') }}" width="25" height="25" alt="icon-roadblocks"/>
                    </td>
                    <td class="100pad0" style="padding:0 60px 20px 0;text-align:justify;" valign="top">
                        <h3 style="margin:5px 0;">My Roadblocks/Impediments:</h3>
                        <p style="margin:0;">
                            @if ($employeeReport->roadblocks)
                                {!! $employeeReport->roadblocks !!}
                            @else
                                None
                            @endif
                        </p>
                    </td>
                </tr>
                @if($employeeReport->remarks != null) 
                <tr height="150">
                    <td class="hide" style="padding-left:20px;width:80px;text-align:right;padding:10px 5px 0 0;" valign="top">
                        <img src="{{ url('/images/emails/icon-remarks.png') }}" width="25" height="25" alt="icon-remarks"/>
                    </td>
                    <td class="100pad0" style="padding:0 60px 20px 0;text-align:justify;" valign="top">
                        <h3 style="margin:5px 0;">Other Remarks:</h3>
                        <p style="margin:0;">
                            {!! $employeeReport->remarks !!}
                        </p>
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="2" style="padding:0 20px;">
                        <p style="font-size:20px; color:#000; margin:0 0 30px 0;font-weight:500;">Thank you.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding:0 20px;">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:11px;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
                            <tbody>
                                <tr>
                                    <td>
                                        <h3 style="margin:0;font-size:15px;margin:0;color:#000;mso-line-height-rule:exactly;">{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                                        @if($position != null)
                                            <span>{{ $position }}</span><br />
                                        @endif
                                        <a href="mailto:{{ $employee->user->email }}" style="color: #4b813a; line-height: 1.5; text-decoration: underline; ">{{ $employee->user->email }}</a><br />
                                        <a href="http://www.fullscale.io" target="_blank" style="color: #4b813a; line-height: 1.5; text-decoration: none;">www.fullscale.io</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" height="45" style="padding:0 40px; color:#4b4b4b;font-style:italic;text-align:center;font-size:13px;font-weight:600;">
                        <p style="margin:50px 0 25px;">
                            This is a system generated message. Please do not respond directly to this email. If you have any questions or concerns regarding the report, send your reply to <a href="mailto:{{ $employee->user->email }}" style="color: #137c36!important;text-decoration: none;">{{ $employee->user->email }}</a>
                        </p>    
                    </td>
                </tr>            
                <tr>
                    <td align="center" class="100pad0" colspan="2" style="margin:0 auto;background:#137c36;text-align:center;padding: 20px;">
                        <table border="0" cellpadding="0" cellspacing="0" class="100padtopbottom" width="600">
                            <tr>
                                <td align="left" class="condensed" valign="middle">
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="mob-column" width="420">
                                        <tr>
                                            <td valign="top" align="center">
                                                <table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
                                                    <tr>
                                                        <td valign="top" align="center" class="100padleftright">
                                                            <table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
                                                                <tr>
                                                                    <td width="135" style="font-size:14px;text-align:center;">
                                                                        <p style="margin:0;color: #fff;">
                                                                            8900 State Line Road, Suite 100, Leawood, KS
                                                                        </p>
                                                                        <p style="margin:0;">
                                                                            <a href="tel:+19135534510" style="color:#fff;text-decoration:none;display:inline;font-weight:600;">+1 913-553-4510</a>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" class="100padleftright" align="center">
                                                            <table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
                                                                <tr>
                                                                    <td width="135" style="font-size:14px;text-align:center;">
                                                                        <p style="margin:0;color: #fff;">
                                                                            14th Floor, HM Tower, Geonzon Street, Cebu I.T. Park, Cebu City, PH
                                                                        </p>
                                                                        <p style="margin:0;">
                                                                            <a href="tel:+63323286075" style="color:#fff;text-decoration:none;display:inline;font-weight:600;">+63 32-328-6075</a>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="20" class="hide"></td>
                                <td align="left" class="condensed" valign="middle">
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" class="mob-column" width="180">
                                        <tr>
                                            <td valign="top" align="center">
                                                <table border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td valign="top" align="center" class="100padleftright">
                                                            <a href="http://www.fullscale.io" target="_blank" style="display: inline-block;margin:0 auto 5px;">
                                                                <img src="{{ url('/images/emails/logo-footer.png') }}" width="90" height="22" style="display:block;margin:0;" alt="Full Scale logo footer"/>
                                                            </a>
                                                            <br />
                                                            <span style="color:#fff;display:block;font-size:10px;">
                                                                © 2018 • <a href="http://www.fullscale.io" target="_blank" style="display:inline-block;font-decoration:none;color:#fff;">FULLSCALE IO</a>
                                                            </span>
                                                            <br />
                                                            <a href="https://www.facebook.com/fullscalekc/" target="_blank" style="display: inline-block; margin-top: 5px;">
                                                                <img src="{{ url('/images/emails/icon-fb.png') }}" alt="icon-fb"/>
                                                            </a>
                                                            <a href="https://www.linkedin.com/company/fullscale-io/" target="_blank" style="display: inline-block; margin-top: 5px;">
                                                                <img src="{{ url('/images/emails/icon-linkedin.png') }}" alt="icon-linkedin"/>
                                                            </a>
                                                            <a href="https://fullscale.io/podcast/" target="_blank" style="display: inline-block; margin-top: 5px;">
                                                                <img src="{{ url('/images/emails/icon-hustle.png') }}" alt="icon-hustle"/>
                                                            </a> 
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
