<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Full Scale Rocks!</title>
	</head>
	<body>
		<!--
			IMPORTANT!!!
			- remove all html and css comments upon implementation since some email clients will consider the content as spam
			- when adding styles, use inline styles (as much as possible) to support most email clients
			- replace image src paths with url of actual url of images
			- adding font-size: 0; to cell or table fixes extra spacing in outlook / useful for cells with images only
		-->
		<!-- Need to put inside body tag to work on some email clients -->
		<style>
			body {
				margin: 0;
				padding: 0;
			}

			/*** Outlook Fix ***/
			table {border-collapse:separate;}
			a, a:link, a:visited {text-decoration: none; color: #00788a;}
			a:hover {text-decoration: underline;}
			h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,h4,h5,h6,.t_cht {color:#000 !important;}
			.ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {line-height: 100%;}
			.ExternalClass {width: 100%;}
			/*** Outlook Fix ***/

			@media only screen and (max-width: 480px) {
				.wrapper {
					width: 100% !important;
				}
			}
			
		</style>

		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
			<tbody>
				<tr>
					<td valign="top">
						<table width="800" cellspacing="0" cellpadding="0" border="0" align="center" class="wrapper" style="font-family: Arial, Helvetica, sans-serif; color: #4e4c4c; background-color: #fff; line-height: 1.5; width: 100%; max-width: 800px;">
							<tbody>
								<!-- BEGIN HEADER -->
								<tr>
									<td height="16" valign="top" align="center" style="font-size: 0;">
										<img src="{{ url('/images/emails/img-bar.png') }}" width="100%" height="16" style="display: block; margin: 0; width: 100%; height: 16px;" alt="" />
									</td>
								</tr>
								<tr>
									<td height="22"></td>
								</tr>
								<tr>
									<td align="center" valign="top" height="33" style="height: 33px; font-size: 0;">
										<a href="http://www.fullscale.io" target="_blank" style="display: block; margin: 0 auto; width: 139px; height: 33px;">
											<img width="139" height="33" src="{{ url('/images/emails/logo.png') }}" style="width: 139px; height: 33px;" alt="Full Scale logo" />
										</a>
									</td>
								</tr>
								<!-- END HEADER -->

								<!-- BEGIN CONTENT -->
								<tr>
									<td align="left">
										<table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="background: #fff url({{ url('/images/emails/img-arrows.png') }}) right bottom no-repeat;">
											<tbody>
												<tr>
													<td colspan="4" height="60"></td>
													<td valign="top" height="100" rowspan="3" width="15" style="height: 100px; min-height: 100%;">

														<!-- float: none; is fix for thunderbird since it adds float: left; to the table also to make table get 100% of td -->
														<table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="height: 100%; float: none; font-size: 0;">
															<tbody>
																<tr>
																	<td height="13" width="15" valign="top" style="height: 13px;">
																		<img src="{{ url('/images/emails/img-diagonal-top-right-half.png') }}" width="15" height="13" style="display: block; margin: 0; width: 15px; height: 13px;" alt="" />
																	</td>
																</tr>
																<tr>
																	<td height="200" style="background-color: #56873b; height: 100%; min-height: 200px;"></td>
																</tr>
																<tr>
																	<td height="13" valign="top" style="height: 13px;">
																		<img src="{{ url('/images/emails/img-diagonal-bot-right-half.png') }}" width="15" height="13" style="display: block; margin: 0; width: 15px; height: 13px;" alt="" />
																	</td>
																</tr>
																<tr>
																	<td height="20" style="height: 20px;">&nbsp;</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
												<tr>
													<td width="29" height="25" style="font-size: 0;">
														<img src="{{ url('/images/emails/img-diagonal-top.png') }}" width="29" height="25" style="display: block; margin: 0; width: 29px; height: 25px;" alt="" />
													</td>
													<td width="41" rowspan="6"></td>
													<td valign="top" rowspan="4">
														<p style="font-size: 20px; color: #000; margin: 0 0 20px 0;">Hi,</p>

														<!-- float: none; is fix for thunderbird since it adds float: left; to the table -->
														<table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="float: none;">
															<tbody>
																<tr>
																	<td style="padding-bottom: 20px;">
															            <div style="margin: 25px 0 25px 0px; font-size: 16px; color: #000; display: block; font-weight: normal;">
                                                                            <span style="display: inline;">This is to inform that {{ $employee->first_name }} {{ $employee->last_name }} filed a <b>Work From Home</b> request starting {{ $requestinfo->start_date }} until {{ $requestinfo->end_date }}.</span>
																		</div>
																	</td>
																</tr>
																<tr>
																	<td style="padding-bottom: 20px;">
															            <div style="margin: 25px 0 25px 0px; font-size: 16px; color: #000; display: block; font-weight: normal;">
                                                                            <span style="display: inline;">Reason: </span>
																			<p>{{ $requestinfo->reason }}</p>
																		</div>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
													<td width="55" rowspan="6" valign="bottom"></td>													
												</tr>
												<tr>
													<td width="29" height="50" style="height: auto; min-height: 100%; background-color: #0e6938;">&nbsp;</td>
												</tr>
												<tr>
													<td width="29" height="220" style="min-height: 220px; background-color: #0e6938;">&nbsp;</td>
													<td height="479" rowspan="6">&nbsp;</td>
												</tr>
												<tr>
													<td height="47" align="center" valign="top" style="font-size: 0;">
														<img src="{{url('/images/emails/img-diagonal-mid.png')}}" width="29" height="47"style="display: block; margin: 0; width: 29px; height: 47px;" alt="" />
													</td>													
												</tr>
												<tr>
													<td height="200" style="background-color: #56873b; height: auto; min-height: 200px;">&nbsp;</td>
												</tr>
												<tr>
													<td height="25" width="29" valign="top" style="font-size: 0;">
														<img src="{{url('/images/emails/img-diagonal-bot.png')}}" width="29" height="25" style="display: block; margin: 0; width: 29px; height: 25px;" alt="" />
													</td>
												</tr>
												<tr>
													<td height="30" colspan="4">&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td height="45" style="padding: 2rem 4.5rem;color: #4b4b4b;font-style: italic;text-align: center;font-size: 1rem;font-weight: 600;">
										<p>
											This is a system generated message. Please do not respond directly to this email. If you have any questions or concerns regarding the request, send your reply to <a href="mailto:{{ $employee->user->email }}" style="color: #137c36!important;text-decoration: none;">{{ $employee->user->email }}</a>
										</p>    
									</td>
								</tr>
								<!-- END CONTENT -->

								<!-- BEGIN FOOTER -->
								<tr>
									<td height="8" style="background-color: #54863b; height: 8px; line-height: 8px; outline: 1px solid #54863b;"></td>
								</tr>
								<tr>
									<td height="18" style="background-color: #137c36; outline: 1px solid #137c36;"></td>
								</tr>
								<tr>
									<td align="center" style="background-color: #137c36; outline: 1px solid #137c36;">

										<table cellspacing="0" cellpadding="0" border="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; margin: 0;height: auto; line-height: 18px; color: #fff;">
											<tbody>
												<tr>
													<td valign="middle">
														<img src="{{url('/images/emails/icon-marker.png')}}" style="display: inline-block; margin: 0;" alt="" />
													</td>
													<td valign="middle" style="border-right: 1px solid #2f603e; padding: 0 20px 0 8px;">
														8900 State Line Road, Suite 100, Leawood, KS
													</td>
													<td valign="middle" style="padding: 0 8px 0 20px;">
														<img src="{{url('/images/emails/icon-phone.png')}}" style="display: inline-block; margin: 0;" alt="" />
													</td>
													<td valign="middle" style="border-right: 1px solid #2f603e; padding: 0 20px 0 0;">
														<a href="tel:+19135534510" style="color: #fff; text-decoration: none; display: inline;">+1 913-553-4510</a>
													</td>
													<td valign="middle" style="padding: 0 8px 0 20px;" rowspan="2">
														<img src="{{url('/images/emails/icon-email.png')}}" style="display: inline-block; margin: 0;" alt="" />
													</td>
													<td valign="middle" rowspan="2">
														<a href="mailto:info@fullscale.io" style="color: #fff; text-decoration: none; display: inline; margin: 0 20px 0 0;">info@fullscale.io</a>
													</td>
												</tr>
												<tr>
													<td valign="middle">
														<img src="{{url('/images/emails/icon-marker.png')}}" style="display: inline-block; margin: 0;" alt="" />
													</td>
													<td valign="middle" style="border-right: 1px solid #2f603e; padding: 0 20px 0 8px;">
														14th Floor, HM Tower, Geonzon Street, Cebu I.T. Park, Cebu City, PH
													</td>
													<td valign="middle" style="padding: 0 8px 0 20px;">
														<img src="{{url('/images/emails/icon-phone.png')}}" style="display: inline-block; margin: 0;" alt="" />
													</td>
													<td valign="middle" style="border-right: 1px solid #2f603e; padding: 0 20px 0 0;">
														<a href="tel:+63323286075" style="color: #fff; text-decoration: none; display: inline;">
															+63 32-328-6075
														</a>
													</td>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td style="background-color: #137c36; outline: 1px solid #137c36;" height="20"></td>
								</tr>
								<tr>
									<td style="background-color: #137c36; line-height: 22px; outline: 1px solid #137c36; font-size: 0;" align="center">
										<a href="http://www.fullscale.io" target="_blank" style="display: inline-block; margin: 0;">
											<img src="{{url('/images/emails/logo-footer.png')}}" width="90" height="22" style="display: block; margin: 0;" alt="Full Scale logo footer" />
										</a>
									</td>
								</tr>
								<tr>
									<td style="background-color: #137c36; outline: 1px solid #137c36;" height="12"></td>
								</tr>
								<!-- END FOOTER -->
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>
