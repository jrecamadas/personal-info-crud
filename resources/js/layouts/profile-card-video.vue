<template>
    <div class="container-grid" id="portfolio">
        <div class="profile-column background-primary">
            <!--<div class="social-panel">
                <div class="social-panel-child">
                    <div class="icon-panel fb-panel">
                        <div class="rhombus"></div>
                        <a
                            title="Facebook Full Scale"
                            href="https://www.facebook.com/fullscalellc/"
                            target="_blank">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </div>
                </div>
                <div class="social-panel-child">
                    <div class="icon-panel linkedin-panel">
                        <div class="rhombus"></div>
                        <a
                            title="LinkedIn Full Scale"
                            href="https://www.linkedin.com/company/fullscale-io/"
                            target="_blank">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </div>
                </div>
                <div class="social-panel-child">
                    <div class="icon-panel youtube-panel">
                        <div class="rhombus"></div>
                        <a
                            title="Instagram Full Scale"
                            href="https://www.instagram.com/fullscalekc/"
                            target="_blank">
                            <i class="fa fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>-->
            <div class="profile-box">
                <div class="image-circle">
                    <img
                        v-if="photos"
                        class="profile-picture"
                        :src="photo(employee.data)"
                        :alt="employee.data.first_name + ' ' + getLastnameInitial(employee.data.last_name)">
                    <div v-if="assets.video_profile" class="overlay">
                        <span class="icon" title="Profile Video" @click="showProfileVideo">
                            <i class="fa fa-play"></i>
                        </span>
                    </div>
                </div>
                <!-- change to something dynamic! (from db) needs -->
                <img v-if="assets.video_profile" class="curve-image" src="../../../public/assets/img/video.png">
            </div>
            <div class="banner-info-extended">
                <h2 v-if="positions" class="banner-position">
                    {{ position(employee.data.positions.data) }}
                </h2>
                <h3 v-if="locations" class="banner-location">
                    {{ employee.data.location.data ? location(employee.data.location.data) : '' }}
                </h3>
                <div v-if="shift" class="section-child-shift">
                    <div class="shift-title">
                        <span class="rotate-shift">SHIFT</span>
                    </div>
                    <div class="shift-time">
                        <div>
                            {{ employee.data.shift.data.time.ph.start }} - {{ employee.data.shift.data.time.ph.end }}, PHT
                        </div>
                        <div>
                            {{ employee.data.shift.data.time.cst.start }} - {{ employee.data.shift.data.time.cst.end }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="employee-overview">
                <div v-if="employee.data.summary" class="employee-overview-child mt-0">
                    <span class="about-skill-sprited my-3"></span>
                    <div class="text-justify">{{ employee.data.summary }}</div>
                </div>
                <div v-if="skills" class="employee-overview-child">
                    <span class="employee-skillbar-sprited my-3"></span>
                    <div id="skills">
                        <div class="skill" v-for="(skill, index) in employee.data.skills.data" :key="index">
                            <h3>{{ skill.name }}</h3>
                            <div class="progress">
                                <div class="progress-bar" :style="{ width: calculateSkillPercentage(skill.proficiency) }"></div>
                                <span v-if="skill.proficiency < 10" class="rating">{{ skill.proficiency }}/10</span>
                                <span v-else class="rating-full">{{ skill.proficiency }}/10</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-section" :style="!assets.video_banner ? 'min-height:520px' : ''">
            <video v-if="assets.video_banner" id="video-background" autoplay muted loop plays-inline>
                <source :src="assets.video_banner" type="video/mp4">
            </video>
            <div class="banner-positioning">
                <div class="banner-section-child  banner-logo">
                    <!-- change to something dynamic needs -->
                    <img src="../../../public/assets/img/logos/full-scale-header-logo.png">
                </div>
                <div class="banner-section-child banner-info">
                    <h1 class="banner-name">
                        <span class="name-color-primary">{{ getFirstNameMaxofTwo(employee.data.first_name) | upperCase }}</span>
                        <span class="name-color-secondary">{{ getLastnameInitial(employee.data.last_name) | upperCase }}</span>
                    </h1>
                    <h2 v-if="positions" class="banner-position">
                        {{ position(employee.data.positions.data) }}
                    </h2>
                    <h3 v-if="locations" class="banner-location">
                        {{ employee.data.location.data ? location(employee.data.location.data) : '' }}
                    </h3>
                </div>
                <div v-if="shift" class="section-child-shift">
                    <div class="shift-title">
                        <span class="rotate-shift">SHIFT</span>
                    </div>
                    <div class="shift-time">
                        <div>
                            {{ employee.data.shift.data.time.ph.start }} - {{ employee.data.shift.data.time.ph.end }}, PHT
                        </div>
                        <div>
                            {{ employee.data.shift.data.time.cst.start }} - {{ employee.data.shift.data.time.cst.end }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-section">
            <div v-if="workExperiences" class="content-section-child work-experience">
                <div class="content-section-child-header">WORK EXPERIENCE</div>
                <div
                    v-for="(experience, index) in employee.data.sortedWorkExperiences"
                    :key="index"
                    class="content-section-child-data"
                    :class="{ 'first-child': index === 0, 'last-child': index === employee.data.workExperiences.data.length - 1 }">
                    <div class="content-section-child-data-duration">
                        {{ formatDate(experience.start_date, 'MMM YYYY')}} - {{ formatDate(experience.end_date, 'MMM YYYY') }}
                    </div>
                    <div class="content-section-child-data-description">
                        <h3>{{ experience.job_title }}</h3>
                        <h4>{{ experience.company_name }}</h4>
                        <p>{{ experience.description }}</p>
                    </div>
                </div>
            </div>
            <div v-if="educations" class="content-section-child education">
                <div class="content-section-child-header">EDUCATION</div>
                <div
                    v-for="(education, index) in getEducationData(employee.data)"
                    :key="index"
                    class="content-section-child-data"
                    :class="{'first-child': index === 0, 'last-child': index === employee.data.workExperiences.data.length - 1}">
                    <div class="content-section-child-data-duration">
                        {{ education.is_present == 1 ? 'Present' : 'Year '+education.year_completed }}
                    </div>
                    <div class="content-section-child-data-description">
                        <h3>{{ education.school_university }}</h3>
                        <h4>{{ education.course_degree }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-section">
            <div class="address">
                <i class="la la-map-marker"></i>
                <h3>8900 State Line Road, Suite 100, Leawood KS</h3>
            </div>
            <div class="email">
                <i class="la la-envelope"></i>
                <h3>sales@fullscale.io</h3>
            </div>
            <div class="telephone">
                <i class="la la-phone"></i>
                <h3>913 553 4510</h3>
            </div>
        </div>
        <div id="ks-izi-modal-video" class="ks-izi-modal" style="display: none;"></div>
    </div>
</template>

<style>
    div#app > div#portfolio {
        position: relative;
    }
    body.ks-navbar-fixed {
        padding-top: 0px;
    }
    div#app {
        overflow-x: hidden;
    }
</style>
<style scoped>
    /* default style, mobile devices */
    .background-primary {
        background: rgba(67, 139, 45, 1);
        background: -moz-linear-gradient(
            top,
            rgba(67, 139, 45, 1) 0%,
            rgba(67, 139, 45, 1) 16%,
            rgba(51, 128, 59, 1) 33%,
            rgba(28, 110, 69, 1) 100%
        );
        background: -webkit-gradient(
            left top,
            left bottom,
            color-stop(0%, rgba(67, 139, 45, 1)),
            color-stop(16%, rgba(67, 139, 45, 1)),
            color-stop(33%, rgba(51, 128, 59, 1)),
            color-stop(100%, rgba(28, 110, 69, 1))
        );
        background: -webkit-linear-gradient(
            top,
            rgba(67, 139, 45, 1) 0%,
            rgba(67, 139, 45, 1) 16%,
            rgba(51, 128, 59, 1) 33%,
            rgba(28, 110, 69, 1) 100%
        );
        background: -o-linear-gradient(
            top,
            rgba(67, 139, 45, 1) 0%,
            rgba(67, 139, 45, 1) 16%,
            rgba(51, 128, 59, 1) 33%,
            rgba(28, 110, 69, 1) 100%
        );
        background: -ms-linear-gradient(
            top,
            rgba(67, 139, 45, 1) 0%,
            rgba(67, 139, 45, 1) 16%,
            rgba(51, 128, 59, 1) 33%,
            rgba(28, 110, 69, 1) 100%
        );
        background: linear-gradient(
            to bottom,
            rgba(67, 139, 45, 1) 0%,
            rgba(67, 139, 45, 1) 16%,
            rgba(51, 128, 59, 1) 33%,
            rgba(28, 110, 69, 1) 100%
        );
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#438b2d', endColorstr='#1c6e45', GradientType=0 );
    }
    video#video-background {
        position: relative;
        overflow: hidden;
        min-width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        width: 100%;
        transform: scale(1.02);
        right: 3px;
    }
    .banner-positioning {
        position: absolute;
        width: 100%;
        padding-left: 2rem;
    }
    .container-grid {
        display: grid;
        min-width: 100%;
        min-height: 100%;
        grid-template-rows: auto;
        grid-template-columns: auto;
        grid-template-areas:
            "banner"
            "profile"
            "main"
            "footer";
    }
    .profile-column {
        grid-area: profile;
        display: flex;
        flex-flow: row wrap;
        align-content: flex-start;
        padding-top: 20%;
    }
    .social-panel {
        flex: 0 0 10%;
        /*display: flex;*/
        display: none;
        flex-flow: row wrap;
        height: 15%;
        max-height: 15%;
        position: absolute;
        align-content: flex-start;
    }
    .social-panel-child {
        flex: 0 0 100%;
        padding: 0;
    }
    .social-panel-child i {
        color: #fff;
        font-size: 2em;
        font-weight: 700;
    }
    .fb-panel i {
        position: absolute;
        top: 27px;
        left: 15px;
        z-index: 1;
    }
    .linkedin-panel i {
        position: absolute;
        top: 87px;
        left: 10px;
        z-index: 1;
    }
    .youtube-panel i {
        position: absolute;
        top: 147px;
        left: 10px;
        z-index: 1;
    }
    .icon-panel:hover .rhombus {
        -webkit-box-shadow: 5px -4px 19px -5px #000;
    }
    .rhombus {
        width: 45px;
        height: 60px;
        margin-top: 0;
        -webkit-transform: rotate(67.5deg) skewX(45deg) scaleY(0.70711);
        transform: rotate(90.5deg) skewX(24deg) scaleY(0.70711);
        position: relative;
        top: 10px;
        background: #5dac31;
    }
    .profile-box {
        flex: 0 0 80%;
        margin-left: 10%;
        height: auto!important;
    }
    .banner-info-extended {
        text-align: center;
        width:100%;
        display: none;
    }
    .banner-info-extended .banner-position,
    .banner-info-extended .banner-location {
        color: #fff!important;
    }
    .banner-info-extended .section-child-shift {
        display: grid;
        width: 82%;
        margin: 0 auto;
        grid-template-columns: 0fr 0.5fr 5.5fr 0fr;
    }
    .image-circle {
        overflow: hidden;
        height: 190px;
        width: 190px;
        border-radius: 100%;
        border: 4px solid #fff;
        margin: 0 auto;
        background-position: -5px -4px;
        position: relative;
        z-index: 1;
    }
    .profile-picture {
        background: #d1d1d1;
        display: block;
        height: auto;
        object-fit: cover;
        width: 100%;
    }
    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .3s ease;
        background: rgb(255,255,255,0.3);
    }
    .overlay .icon {
        color: #438b2d;
        font-size: 4.5rem;
        position: absolute;
        top: 53%;
        left: 53%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
        cursor: pointer;
    }
    span i.fa-play-circle:hover {
        color: #495057;
        cursor: pointer;
    }
    .image-circle:hover .overlay {
        opacity: 1;
    }
    .curve-image {
        position: relative;
        display: block;
        margin: 0 auto;
        text-align: center;
        top: -48px;
        left: 0px;
    }
    .employee-overview {
        flex: 0 0 80%;
        margin-left: 10%;
        display: flex;
        flex-flow: row wrap;
        color: #fff;
        padding-top: 20px!important;
    }
    .employee-overview-child {
        margin-top: 10%;
        flex: 0 0 100%;
    }
    span.about-skill-sprited {
        display: block;
        height: 50px;
        width: 50px;
        background: url("../../../public/assets/img/sprited-icons.png") no-repeat;
        background-position: -6px -1px;
        background-size: cover;
    }
    span.about-skill-sprited:before {
        content: 'ABOUT';
        color: #fff;
        font-size: 20px;
        vertical-align: -webkit-baseline-middle;
        position: relative;
        top: 10px;
        left: 50px;
    }
    span.employee-skillbar-sprited  {
        display: block;
        height: 50px;
        width: 50px;
        background: url("../../../public/assets/img/sprited-icons.png") no-repeat;
        background-position: -6px -57px;
        background-size: cover;
    }
    span.employee-skillbar-sprited:before {
        content: 'SKILLS';
        color: #fff;
        font-size: 20px;
        vertical-align: -webkit-baseline-middle;
        position: relative;
        top: 10px;
        left: 50px;
    }
    h3.employee-overview-child-header {
        text-align: center;
        color: #fff;
    }
    h4.child-label {
        color: #fff;
    }
    .bar {
        height: 12px;
        margin: 2px 2px;
        position: absolute;
    }
    #skills {
        width: 100%;
        margin: 0 auto;
        position: relative;
        line-height: 2em;
        padding: 1rem 0;
    }
    #skills .skill .progress {
        margin-bottom: 20%;
        background: #e9e5e2;
        background-image: -webkit-gradient(
            linear,
            left top,
            left bottom,
            from(#e1ddd9),
            to(#e9e5e2)
        );
        background-image: -webkit-linear-gradient(top, #e1ddd9, #e9e5e2);
        background-image: -moz-linear-gradient(top, #e1ddd9, #e9e5e2);
        background-image: -ms-linear-gradient(top, #e1ddd9, #e9e5e2);
        background-image: -o-linear-gradient(top, #e1ddd9, #e9e5e2);
        background-image: linear-gradient(top, #e1ddd9, #e9e5e2);
        height: 15px;
        -moz-box-shadow: 0 1px 0px #bebbb9 inset, 0 1px 0 #fcfcfc;
        -webkit-box-shadow: 0 1px 0px #bebbb9 inset, 0 1px 0 #fcfcfc;
        box-shadow: 0 1px 0px #bebbb9 inset, 0 1px 0 #fcfcfc;
    }
    #skills .skill .progress .rating {
        position: absolute;
        font-size: 11px; /* make responsive */
        font-weight: 500;
        color: #037a38;
        margin-top: -5px;
        right: 20px;
    }
    #skills .skill .progress .rating-full {
        position: absolute;
        font-size: 11px; /* make responsive */
        font-weight: 500;
        color: #ffffff;
        margin-top: -5px;
        right: 6px;
    }
    #skills .skill h3 {
        position: relative;
        font-size: 18px;
        color: #fff;
    }
    #skills .skill .progress-bar {
        animation-name: animateBar;
        animation-iteration-count: 1;
        animation-timing-function: ease-in;
        animation-duration: 1s;
        background-color: #2ca04a;
    }
    .banner-section {
        grid-area: banner;
        display: flex;
        flex-flow: row wrap;
        align-items: center;
        overflow: hidden;
        /* use gif passed from employee instead from this url */
        background: url("../../../public/assets/img/banner-cover.png") no-repeat;
        background-position: center center;
        background-size: cover;
        min-height: 40vh;
        position: relative;
    }
    .banner-section-child.banner-logo {
        margin: 0%;
    }
    .banner-section-child.banner-info {
        margin: 15% 20% 3% 0%;
    }
    .banner-section-child {
        flex: 0 0 55%;
    }
    .banner-section-child img {
        object-fit: contain;
        width:80%;
    }
    h1.banner-name {    
        font-size: 3em;
        font-weight: 700;
        letter-spacing: 2px;
    }
    h2.banner-position {
        font-size: 1.5em;
        font-weight: 600;
    }
    h3.banner-location {
        font-size: 1.25em;
        font-weight: 600;
    }
    span.name-color-secondary {
        color: #007840;
    }    
    span.name-color-light {
        color: #fff;
    }
    .section-child-shift {
        display: grid;
        grid-template-rows: 5fr 5fr;
        grid-template-columns: 0fr 0.5fr 7.5fr 1fr;
        align-items: center;
        grid-template-areas:
            "shiftTitle . shiftTime ."
            "shiftTitle . shiftTime .";
    }
    .shift-title {
        grid-area: shiftTitle;
        background: #000;
    }
    .shift-time {
        grid-area: shiftTime;
        background: rgba(228, 228, 228, 0.8);
        font-size: 1em;
        font-weight: 600;
        letter-spacing: 1px;
        vertical-align: -webkit-baseline-middle;
        padding: 5px;
        max-width: 300px;
        left: -15px;
        position: relative;
    }
    span.rotate-shift {
        -webkit-writing-mode: vertical-rl;
        -ms-writing-mode: tb-rl;
        writing-mode: vertical-rl;
        text-orientation: sideways;
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        font-size: 1em;
        font-weight: 500;
        letter-spacing: 1px; /* make responsive */
        color: #fff;
        background: #000;
        padding: 0px 3px 2px 0px;
        text-align: center;
    }
    .content-section {
        grid-area: main;
        display: flex;
        flex-flow: row wrap;
        overflow: hidden;
        align-self: start;
    }
    .content-section-child {
        flex: 0 0 100%;
        display: flex;
        flex-flow: row wrap;
    }
    .content-section-child-header {
        flex: 0 0 100%;
        background: #131111;
        color: #fff;
        vertical-align: middle;
        font-size: 1.5em;
        font-weight: 500;
        letter-spacing: 2px;
        padding: 2% 0 2% 2.5%;
        display: flex;
        align-items: center;
    }
    .content-section-child-data {
        flex: 0 0 98%;
        display: flex;
        flex-flow: row wrap;
        margin-left: 1%;
        margin-right: 1%;
        background: #eeedee;
    }
    .first-child {
        background: #dddcdd;
        margin-top: 1%;
        margin-bottom: 1%;
    }
    .last-child {
        margin-bottom: 1%;
    }
    .content-section-child-data-duration {
        flex: 100%;
        padding: 2%;
        font-size: 18px; /* make responsive */
        font-weight: 700;
        color:#fff;
        background: #007840;;
    }
    .content-section-child-data-description {
        flex:68%;
        padding: 3%;
    }
    .footer-section {
        grid-area: footer;
        display: flex;
        flex-flow: row wrap;
        margin: 0;
        vertical-align: bottom;
        margin: 1%;
        align-items: stretch;
    }
    .footer-section div {
        border-right: 2px solid #007840;
        padding: 1%;
    }
    .footer-section div i {
        color: #007840;
        font-size: 1em;
        vertical-align: -webkit-baseline-middle;
        margin-right: 1%;
        font-weight:700;
    }
    .footer-section div h3 {
        font-size: 0.8em;
        display: inline-block;
        vertical-align: bottom;
        margin: 0;
    }
    .footer-section div:last-child {
        border-right: none;
    }
    .address {
        flex: 0 0 31%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .email {
        flex: 0 0 31%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .telephone {
        flex: 0 0 31%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* for tablet devices */
    @media (max-width: 768px) {
        .banner-section > video {
            display: none!important;
        }
    }
    @media (min-width: 769px) {
        .container-grid {
            display: grid;
            grid-template-rows: max-content 1fr max-content;
            grid-template-columns: 0fr 33fr 56fr 0fr;
            grid-template-areas:
                ". profile banner ."
                ". profile main ."
                ". profile footer .";
        }
        .profile-box {
            margin-bottom: 0%;
        }
        .banner-section {
            min-height: 30vh;
        }
        .content-section-child-data{
            flex: 0 0 98%;
        }
        .content-section-child-data-duration {
            flex: 0 0 28%;
            color: #007840;
            background: none;
        }
        .content-section-child-data-description p {
            white-space: pre-line;
        }
        .content-section-child-data-description[data-v-faf6b022] {
            flex: 0 0 68%;
            padding: 2%;
        }
        .banner-positioning {
            width: 63%;
            padding-left: 1.5rem!important;
        }
    }
    /* small screen desktop */
    @media (min-width: 1080px) {
        .container-grid {
            display: grid;
            grid-template-columns: 10fr 30fr 50fr 10fr;
        }
        .profile-box {
            height: 14%;
        }
        .address {
            flex: 0 0 50%;
        }
        .email {
            flex: 0 0 25%;
        }
        .telephone {
            flex: 0 0 25%;
        }
    }
    /* medium screen desktop */
    @media (min-width: 1250px) {
        .footer-section div i {
            font-size: 1.2em;
        }
        .footer-section div h3 {
            font-size: 1em;
        }
    }
    /* for large desktop devices */
    @media (min-width: 1824px) {
        .container-grid {
            display: grid;
            grid-template-columns: 15fr 20fr 50fr 15fr;
        }
        .profile-column {
            padding-top: 25%;
        }
        .profile-box {
            margin-bottom: 0;
        }
        h1.banner-name {
            font-size: 4em;
        }
        h2.banner-position {
            font-size: 1.7em;
        }
        h3.banner-location {
            font-size: 1.25em;
        }
        .section-child-shift {
            grid-template-rows: 5fr 5fr;
            grid-template-columns: 0fr 0.5fr 16.5fr;
            grid-template-areas:
                "shiftTitle . shiftTime"
                "shiftTitle . shiftTime";
        }
        .shift-time {
            font-size: 1.5em;
        }
        span.rotate-shift {
            font-size: 1.5em; /* make responsive */
            letter-spacing: 1px; /* make responsive */
        }
        .content-section-child-header {
            font-size: 18px; /* make responsive */
            letter-spacing: 2px;
            padding: 1% 0 1% 2.5%;
        }
        .content-section-child-data-duration {
            font-size: 18px; /* make responsive */
        }
        .footer-section div i {
            font-size: 2em;
        }
        .footer-section div h3 {
            font-size: 1.3em;
        }
    }
    @media (max-width: 1191px) {
        .banner-section-child.banner-info {
            margin: 0;
        }          
    }
    @media(max-width: 768px) {
        video#video-background {
            transform: scale(1.15);
            right: 2.2rem;
        }
        .employee-overview-child {
            margin-top: 5%;
        }
        #skills .skill .progress {
            margin-bottom: 10%!important;
        }
        .banner-section-child img {
            width: 55%;
        }
        .banner-section-child.banner-info {
            margin-right: 12rem;
        }
    }
    @media(max-width:500px){
        video#video-background {
            transform: scale(1.5);
            right: 7rem;
        }
        .banner-section{
            min-height: 366px;
        }
    }
    @media(max-width:450px){
        video#video-background {
            transform: scale(1.55);
            right: 6.6rem;
        }
    }
    @media(max-width:425px) {
        .banner-positioning .banner-position,
        .banner-positioning .banner-location,
        .banner-positioning .section-child-shift {
            display: none;
        }
        .container-grid > .banner-section {
            min-height: 170px!important;
        }
        .banner-section-child.banner-logo,
        .banner-section-child.banner-info {
            margin: 0;
        }
        .banner-positioning {
            text-align: center;
            padding-left: 0;
            background: rgba(228, 228, 228, 0.39);
            bottom: 0;
            padding-bottom: 20px!important;
        }
        .banner-info-extended {
            display: block;
        }
        h1.banner-name {
            margin-bottom: 0;
        }
        .section-child-shift .shift-time {
            position: relative;
            z-index: 0;
        }
        .section-child-shift .shift-title {
            position: relative;
            z-index: 1;
            left: 12px;
        }
    }
    @media(max-width:400px){
        video#video-background {
            transform: scale(1.9);
            right: 9rem;
        }
    }
    @media(max-width:320px){
        video#video-background {
            transform: scale(1.91);
            right: 9rem;
        }
        div#portfolio {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            min-width: 319px;
            width: 100%;
        }
    }
    
    @keyframes animateBar {
        0% {transform: translateX(-100%);}
        100% {transform: translateX(0);}
    }
</style>

<script>
    import { EmployeeProfile } from "@common/model/EmployeeProfile";
    import { Asset } from "@common/model/Asset";
    import ProfileInfo from "@components/profile-info.vue";
    import ProfileTitle from "@components/profile-title.vue";
    import ProgressBarNumber from "@components/progress-bar-number.vue";
    import SkillsAndProficiencyMixin from "@common/mixin/SkillsAndProficiencyMixin";
    import DateMixin from "@common/mixin/DateMixin";
    import EmployeeMixin from "@common/mixin/EmployeeMixin";
    import EmployeeEducationMixin from "@common/mixin/EmployeeEducationMixin";
    import LoaderMixin from "@common/mixin/LoaderMixin";
    import jQuery from 'jquery';
    import iziModal from 'izimodal/js/iziModal.min';
    import 'izimodal/css/iziModal.css';
    import _ from "lodash";

    export default {        
        components: {
            ProfileInfo,
            ProfileTitle,
            ProgressBarNumber,
            Asset
        },
        mixins: [
            SkillsAndProficiencyMixin,
            DateMixin,
            EmployeeMixin,
            EmployeeEducationMixin,
            LoaderMixin
        ],
        data() {
            return {
                employee: {
                    data: {
                        educations: [],
                        first_name: "",
                        last_name: "",
                        gender: "",
                        positions: [],
                        portfolios: [],
                        workExperiences: [],
                        sortedWorkExperiences: [],
                        skills: [],
                        languages: [],
                        photo: [],
                        summary: "",
                        shift: {
                            data: {
                                shift: "",
                                time: {
                                    cst: {
                                        end: "",
                                        start: ""
                                    },
                                    ph: {
                                        end: "",
                                        start: ""
                                    }
                                }
                            }
                        },
                        location: ""
                    }
                },
                assets: {
                    video_banner: '',
                    video_profile: '',
                    photo_banner: ''
                },
                include: [
                    "positions",
                    "photo",
                    "workExperiences",
                    "skills",
                    "languages",
                    "educations",
                    "portfolios",
                    "department",
                    "user",
                    "shift",
                    "location"
                ]
            };
        },
        async created() {
            const username = this.$route.params.username;

            await EmployeeProfile.get({
                username: username,
                include: this.include.join(",")
            }).then(res => {
                this.employee = res;
                if (this.employee.data.skills.data.length) {
                    this.employee.data.skills.data = this.employee.data.skills.data.splice(0, 10);
                }
                this.assets.video_profile = this.getAssetURL(res.data.photo, 6);
                this.assets.video_banner = this.getAssetURL(res.data.photo, 7);
                this.photo_banner = this.getAssetURL(res.data.photo, 8);

                this.employee.data.sortedWorkExperiences = _.orderBy(this.employee.data.workExperiences.data, ['end_date'], ['desc']);
            });
        },
        mounted() {
            this.hideLoader();
        },
        computed: {
            educations() {
                return this.employee.data.educations.data &&
                    this.employee.data.educations.data.length
                    ? true
                    : false;
            },
            photos() {
                return this.employee.data.photo.data ? true : false;
            },
            positions() {
                return this.employee.data.positions.data &&
                    this.employee.data.positions.data.length
                    ? true
                    : false;
            },
            portfolios() {
                return this.employee.data.portfolios.data &&
                    this.employee.data.portfolios.data.length
                    ? true
                    : false;
            },
            skills() {
                return this.employee.data.skills.data &&
                    this.employee.data.skills.data.length
                    ? true
                    : false;
            },
            languages() {
                return this.employee.data.languages.data &&
                    this.employee.data.languages.data.length
                    ? true
                    : false;
            },
            workExperiences() {
                return this.employee.data.workExperiences.data &&
                    this.employee.data.workExperiences.data.length
                    ? true
                    : false;
            },
            summary() {
                return this.employee.data.summary != "" ? true : false;
            },
            shift() {
                return this.employee.data.shift && this.employee.data.shift
                    ? true
                    : false;
            },
            locations() {
                return this.employee.data.location &&
                    this.employee.data.location.data
                    ? true
                    : false;
            }
        },
        methods: {
            getAssetURL(assets, type){
                let id = 0;
                let url = '';
                assets.data.forEach((data) => {
                    if(data.type == type){
                        if(data.id > id){
                            id = data.id;
                            url = data.path;
                        }
                    }
                });
                return url;
            },
            getFirstNameMaxofTwo(firstname) {
                var fName = firstname.split(" ");
                return (fName.length > 1) ? fName[0]+" "+fName[1] : firstname;
            },
            getLastnameInitial(fullname) {
                return typeof fullname[0] !== "undefined"
                    ? fullname[0] + "."
                    : fullname;
            },
            calculateSkillPercentage(proficiency) {
                var width = 0;
                width = (proficiency / 10) * 100 -1 ;
                return width + "%";
            },
            showProfileVideo() {
                let $ = jQuery;                                
                $.fn.iziModal = iziModal;
                $("#ks-izi-modal-video").iziModal({
                    headerColor: '#000',
                    title: this.getFirstNameMaxofTwo(this.employee.data.first_name) + "'s Video Profile",
                    icon: 'icon-settings_system_daydream',
                    overlayClose: true,
                    fullscreen: true,
                    openFullscreen: false,
                    autoOpen: false,
                    closeOnEscape: true,
                    iframe: true,
                    iframeHeight: 400,
                    iframeURL: this.assets.video_profile,
                    transitionIn: 'bounceInDown',
                    transitionOut: 'bounceOutUp'
                });
                $('#ks-izi-modal-video').iziModal('open');
            }
        },
        filters: {
            upperCase: function (value) {
                if (!value) return '';
                value = value.toString().trim();
                return value.toUpperCase();
            }
        }
    };
</script>
