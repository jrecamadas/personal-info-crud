<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Full Scale {{ $employee->first_name }} {{ substr($employee->last_name, 0, 1).'.' }}</title>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"  />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <!--< link rel="icon" href="{{asset('/images/fs-icon-150x150.png')}}" size="32x32" media="all"/>
        <link rel="icon" href="{{asset('/images/fs-icon" size="192x192')}}" media="all"/> -->
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/line-awesome/css/line-awesome.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/montserrat/styles.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/kosmo/styles.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/weather/css/weather-icons.min.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bundle.min.css') }}"  />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/leave_report.css') }}"  />

    </head>
    <body> <!-- remove ks-page-header-fixed to unfix header -->
        <div class="container" id="portfolio">
            <div class="row mt-3">
                <div class="col-4 left p-0">
                    <div class="pdf-profile">
                        <div class="profiles-image-container">
                            <div class="profile-top-area">
                                <div class="profile-picture1">
                                    @if (isset($photo))
                                        <img src="{{ asset($photo->path) }}" class="img-fluid profile-image" alt="{{ $employee->first_name }} {{ substr($employee->last_name, 0, 1) . '.' }}">
                                    @else
                                        @if (strtolower($employee->gender) == "male" || $employee->gender == null)
                                            <img src="{{asset('/assets/img/avatars/male.png')}}" class="img-fluid profile-image" alt="{{ $employee->first_name }} {{ substr($employee->last_name, 0, 1) . '.' }}">
                                        @else
                                            <img src="{{asset('/assets/img/avatars/female.png')}}" class="img-fluid profile-image" alt="{{ $employee->first_name }} {{ substr($employee->last_name, 0, 1) . '.' }}">
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-inline-block w-100 profile-about-container pb-5 pt-3">
                            <div class="p-3">
                                 <div class="mt-4">
                                    <div class="id-num py-4">{{ $employee->employee_no }}</div>
                                </div>
                                <div class="text-center">
                                    <div class="test">
                                        <h5 class="primary-color">YEARLY PTO USAGE SUMMARY</h5>
                                    </div>
                                </div>
                                <div class="fs-pto">
                                    <div class="fs-pto-group">
                                        <div class="fs-pto-icon">
                                            <i class="fas fa-calendar-plus"></i>
                                        </div>
                                        <div class="fs-pto-text">
                                            <h3>{{ $yearlyPtoCredits['available'] }}</h3>
                                            <span>Available</span>
                                        </div>
                                    </div>
                                    <div class="fs-pto-group">
                                        <div class="fs-pto-icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div class="fs-pto-text">
                                            <h3>{{ $yearlyPtoCredits['total'] }}</h3>
                                            <span>Total Used</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8 right pr-0">
                    <div class="header-container text-center" style="background-size: 50%;">
                        <h3>{{ $employee->first_name . ' ' . $employee->last_name }}</h3>
                        <div class="fs-employee-position">
                            @if (isset($positions[0]))
                                <span>{{ $positions[0]->position->job_title }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="body-container">
                        <div class="card ks-card-widget ks-widget-table" style="border-right:none;">
                            <h5 class="card-header">Total Leave Types Used &nbsp;</h5>
                            <div class="card-block">
                                <table class="table ks-payment-table-invoicing">
                                    <tbody>
                                        <tr>
                                            <th>Leave Type</th>
                                            <th># of Days Used</th>
                                            <th># of Paid Leaves</th>
                                        </tr>
                                        {{-- $leaveTypeUsed and $leaveTypes was loaded in view composer app/Http/View/Composers --}}
                                        @foreach ($leaveTypes as $name)
                                            <tr>
                                                <td>{{ $name }}</td>
                                                <td>{{ !empty($leaveTypeUsed[$name]) ? $leaveTypeUsed[$name]['daysUsed'] : number_format(0, 2) }}</td>
                                                <td>{{ !empty($leaveTypeUsed[$name]) ? $leaveTypeUsed[$name]['paidLeaves'] : number_format(0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="ks-datatable_wrapper" class="card ks-card-widget ks-widget-table">
                    <h5 class="card-header">Leave Application History &nbsp;</h5>
                    <div id="fs-leave-history-table" class="card-block">
                        @foreach ($leaveRequestHistory as $batch => $requestData)
                            <div class="fs-leave-history-detail" style="page-break-inside: avoid;">
                                <table id="ks-datatable" class="table dataTable" role="grid" aria-describedby="ks-datatable_info" style="border-right:none;">
                                    <tbody>
                                    {{-- $leaveRequestHistory was loaded in view composer app/Http/View/Composers --}}
                                        <tr role="row" class="fs-parent-detail" style="background-color: #eff9ea;margin-top:2px!important;">
                                            <td style="border-left:2px solid #e5e5e5;">{{ $requestData['leaveType'] }} on {{ $requestData['datePeriod'] }}</td>
                                            <td style="border-right: 2px solid #e5e5e5;text-align:right;">Filed: {{ $requestData['dateFiled'] }}</td>
                                        </tr>
                                        <tr role="row" class="fs-main-details">
                                            <td style="border-left:2px solid #e5e5e5;">
                                                <p>
                                                    <span class="label">Leave Time:</span>
                                                    {{ $requestData['leaveTime'] }}
                                                </p>
                                                <p>
                                                    <span class="label">Duration:</span>
                                                    {{ $requestData['duration'] }}
                                                </p>
                                                <p>
                                                    <span class="label">Whole/Half Day:</span>
                                                    {{ $requestData['dayStatus'] }}
                                                </p>
                                                <p>
                                                    <span class="label">Paid/Unpaid:</span>
                                                    {{ $requestData['paidStatus'] }}
                                                </p>
                                            </td>
                                            <td style="border-right: 2px solid #e5e5e5;">
                                                <p>
                                                    <span class="label">Reason:</span>
                                                    <p>{{ $requestData['reason'] }}</p>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr role="row" class="fs-each-details">
                                            <td
                                                colspan="2"
                                                style="border-top: none;border-right: 2px solid #e5e5e5;border-left: 2px solid #e5e5e5;border-bottom: 2px solid #e5e5e5; margin-bottom:2rem;">
                                                <table class="inner-table w-100 table-bordered mb-2" style="border: solid 1px #dee0e1;">
                                                    <thead>
                                                        <tr>
                                                            <th>Date(s)</th>
                                                            <th>Status</th>
                                                            <th>Approver</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- this was loaded in view composer app/Http/View/Composers --}}
                                                        @foreach ($requestData['requestsData'] as $data)
                                                            <tr>
                                                                <td>{{ $data['date'] }}</td>
                                                                <td>{{ $data['status'] }}</td>
                                                                <td>{{ $data['approver'] }}</td>
                                                                <td>{{ $data['remarks'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                        <div class="fs-table-empty">
                            @if (empty($leaveRequestHistory))
                                <h5> No Leave History to Show </h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
