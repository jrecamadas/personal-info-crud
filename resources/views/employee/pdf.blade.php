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
        <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css') }}"  />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    </head>
    <body> <!-- remove ks-page-header-fixed to unfix header -->
        <div class="container" id="portfolio">
            <div class="row">
                <div class="col-4 left">
                    <div class="profiles-image-container">
                        @if(isset($photo))
                            <img src="{{ \App\Services\AssetService::getFinalAssetPath($photo->path) }}" class="img-fluid profile-image" alt="{{ $employee->first_name }} {{ substr($employee->last_name, 0, 1).'.' }}">
                        @else
                            @if(strtolower($employee->gender) == "male" || $employee->gender == null)
                                <img src="{{ asset('/assets/img/avatars/male.png') }}" class="img-fluid profile-image" alt="{{ $employee->first_name }} {{ substr($employee->last_name, 0, 1).'.' }}">
                            @else
                                <img src="{{ asset('/assets/img/avatars/female.png') }}" class="img-fluid profile-image" alt="{{ $employee->first_name }} {{ substr($employee->last_name, 0, 1).'.' }}">
                            @endif
                        @endif
                    </div>
                    <div class="profile-about-container">
                        @if($employee->summary)
                        <div>
                            <p class="header">
                                <img src="{{ asset('/images/profile-icons/about-me.png') }}" class="img-fluid" alt="About me"> ABOUT ME
                            </p>
                            <p class="summary">{{ $employee->summary }}</p>
                        </div>
                        @endif
                        @if($languages)
                            @foreach($languages as $language)
                                <div>
                                    <p class="header">
                                        <img src="{{ asset('/images/profile-icons/languages.png') }}" class="img-fluid" alt="Languages">
                                        {{ strtoupper($language->language->language) }}
                                    </p>
                                    <label>Written</label>
                                    <div class="progress" style="background-color: white;page-break-inside: avoid;">
                                        <div class="progress-bar progress-bar-profile-color"
                                            role="progressbar"
                                            style="width:{{  ($language->spoken/10)*100  }}%"
                                            aria-valuenow="{{ $language->written }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div style="margin-bottom:40px;">
                                        <?php for($x = 1; $x <= 10; $x++) { ?>
                                            <div style="width:{{ 100/10 }}%; color:white" class="p-bar-num">{{ $x }}</div>
                                        <?php } ?>
                                    </div>
                                    <label>Spoken</label>
                                    <div class="progress" style="background-color: white;page-break-inside: avoid;">
                                        <div class="progress-bar progress-bar-profile-color"
                                            role="progressbar"
                                            style="width:{{ ($language->spoken/10)*100 }}%"
                                            aria-valuenow="{{ $language->spoken }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div style="margin-bottom:15pxx;">
                                        <?php for($x = 1; $x <= 10; $x++) { ?>
                                            <div style="width:{{ 100/10 }}%; color:white" class="p-bar-num">{{ $x }}</div>
                                        <?php } ?>
                                    </div>
                                </div>
                            @endforeach
                            <p>&nbsp</p>
                        @endif
                        @if($skills)
                            <div>
                                <p class="header">
                                    <img src="{{ asset('/images/profile-icons/skills.png') }}" class="img-fluid" alt="skills"> SKILLS
                                </p>
                                    @foreach($skills as $skill)
                                        <div style="page-break-inside: avoid;">
                                            <label>{{ $skill->skill->name }}</label>
                                            <div class="progress" style="background-color: white">
                                                <div class="progress-bar progress-bar-profile-color"
                                                    role="progressbar"
                                                    style="width:{{ ($skill->proficiency/10)*100 }}%"
                                                    aria-valuenow="{{ $skill->proficiency }}"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div style="padding-bottom:35px;">
                                                <?php for($x = 1; $x <= 10; $x++) { ?>
                                                    <div style="width: {{ 100/10 }}%;" class="p-bar-num">{{$x}}</div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                            <p>&nbsp</p>
                        @endif
                        <div>
                            @if($shift)
                                @php 
                                    if (isset($shift->shift)) {
                                        $shiftStart = $shift->shift->start_time_timestamp;
                                        $shiftEnd = $shift->shift->end_time_timestamp;
                                    } else {
                                        $shiftStart = $shift->start_time_timestamp;
                                        $shiftEnd = $shift->end_time_timestamp;
                                    }
                                @endphp
                                <div style="page-break-inside: avoid;">
                                    <p class="header">
                                        <img src="{{ asset('/images/shift.png') }}" class="img-fluid" alt="Shift">  SHIFT
                                    </p>
                                    <p>
                                        {{ \Carbon\Carbon::createFromTimestamp($shiftStart, 'Asia/Manila')->format('g:i A') }} - {{ 
                                        \Carbon\Carbon::createFromTimestamp($shiftEnd, 'Asia/Manila')->format('g:i A') }}, PHT
                                    </p>
                                    <p>
                                        {{ \Carbon\Carbon::createFromTimestamp(strtotime(date('Y-m-d') . ' ' . date('H:i:s', $shiftStart)), 'America/Chicago')->format('g:i A') }} - {{
                                        \Carbon\Carbon::createFromTimestamp(strtotime(date('Y-m-d') . ' ' . date('H:i:s', $shiftEnd)), 'America/Chicago')->format('g:i A, T') }}</p>
                                </div>
                            @endif
                        </div>
                         <p>&nbsp</p>
                    </div>
                </div>
                <div class="col-8 right">
                    <div class="header-container">
                        <h1>{{ $employee->first_name }} {{ substr($employee->last_name, 0, 1).'.' }}</h1>
                        @if(isset($positions[0]))
                            <h3>{{ $positions[0]->position->job_title }}</h3>
                        @endif
                        @if(isset($location->city) && isset($location->country))
                            <h5>{{ $location->city }}, {{ $location->country }}</h5>
                        @elseif(isset($location->city))
                            <h5>{{ $location->city }}</h5>
                        @elseif(isset($location->country))
                            <h5>{{ $location->country }}</h5>
                        @endif
                    </div>
                    <!-- <div class="body-container">
                        <p class="header">PORTFOLIO</p>
                        <ul class="{{ $portfolios->count() ? '':'description' }}">
                            @if($portfolios)
                                @foreach($portfolios as $portfolio)
                                    <li>
                                        <div class="portfolio-container">
                                            <p class="head">
                                                <span class="title">{{ $portfolio->name }}</span>
                                                <span class="date">
                                                {{ \Carbon\Carbon::parse($portfolio->start_date)->format('M d, Y') }}
                                                @if($portfolio->start_date != '' && $portfolio->end_date)
                                                    -
                                                @endif
                                                {{ \Carbon\Carbon::parse($portfolio->end_date)->format('M d, Y') }}
                                                </span>
                                            </p>
                                            <p class="description">{{ $portfolio->description }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div> -->
                    <div class="body-container">
                        <p class="header">EXPERIENCE</p>
                        <ul class="{{ $experiences->count() ? '':'description' }}">
                            @if($experiences)
                                @foreach($experiences as $experience)
                                    <li>
                                        <div class="portfolio-container">
                                            <p class="head">
                                                <span class="title">{{ $experience->job_title }}</span>
                                                <span class="date">
                                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }}
                                                @if($experience->start_date != '' && $experience->end_date)
                                                    -
                                                @endif
                                                {{ \Carbon\Carbon::parse($experience->end_date)->format('M Y') }}
                                                </span>
                                            </p>
                                            <p>{{ $experience->company_name }}</p>
                                            <p class="description">{{ $experience->description }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="body-container">
                        <p class="header">EDUCATION</p>
                        <ul class="{{ $educations->count() ? '':'description' }}">
                           @if($educations)
                                @foreach($educations as $education)
                                    <li>
                                        <div class="portfolio-container">
                                            <p class="head">
                                                <span class="title">{{ $education->course_degree }}</span>
                                                <span class="date">
                                                    @if($education->is_present)
                                                        Present
                                                    @else
                                                        Year {{ $education->year_completed }}
                                                    @endif
                                                </span>
                                            </p>
                                            <p class="education-description">
                                                {{ $education->school_university }}
                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
