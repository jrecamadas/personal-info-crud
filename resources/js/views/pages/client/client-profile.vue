<template>
    <div class="fs-container">
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title">
            <!-- <div class="delete dataTable_buttons align-middle button-wrapper" style="padding:0">
                <a v-if="client" class="btn-sm btn-danger align-middle" href="#" @click.prevent="showClientConfirm(client)">
                    <span class="la la-trash ks-icon"></span>
                    <span class="ks-text">Delete Client</span>
                </a>
            </div> -->
        </page-header>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="row fs-page">
                        <div class="col-sm-12 col-md-4 col-lg-3 fs-page-left">
                            <div class="row mt-3 justify-content-md-center">
                                <div class="col-sm-12 mb-3 fs-back-link">
                                    <router-link :to="{ name: 'clients' }" >
                                        <i class="la la-long-arrow-left"></i> Back to client list
                                    </router-link>
                                </div>
                                <div class="col-sm-10 fs-profile-photo mb-3">
                                    <div class="fs-info-flex flex-row">
                                        <div class="profile-photo">
                                            <a href="javscript:;" @click="openModals({ key: 'client-photo', name: 'Profile Photo' })">
                                                <img :src="clientPhoto" class="avatar"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row fs-company-header">
                                        <div class="col-sm-10">
                                            <h4 class="fs-company-name">{{ clientInfo.company }}</h4>
                                            <p class="fs-company-location"><i class="la la-map-marker"></i> {{ clientInfo.location }}</p>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="javascript:;" class="btn btn-outline-primary ks-light ks-no-text" @click="showEditDialogue(clientInfo)">
                                                <span class="la la-edit ks-icon"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row fs-company-content">
                                        <div class="col-sm-12 p-0">
                                            <table id="fs-company-details">
                                                <tbody>
                                                    <tr>
                                                        <td class="fs-company-label">
                                                            <label>Status:</label>
                                                        </td>
                                                        <td>{{ clientStatus[clientInfo.status] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-company-label">
                                                            <label>High Growth Client:</label>
                                                        </td>
                                                        <td>
                                                            <span :title="status_instruction" v-if="clientInfo.is_high_growth_client">Yes</span>
                                                            <span :title="status_instruction" v-else>No</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-company-label">
                                                            <label>Start Date:</label>
                                                        </td>
                                                        <td>{{ clientInfo.start_date ? clientInfo.start_date : "TBD" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-company-label">
                                                            <label>No. of Projects:</label>
                                                        </td>
                                                        <td>{{ clientInfo.projects_count }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-company-label">
                                                            <label>No. of Resources:</label>
                                                        </td>
                                                        <td>{{ clientInfo.resources_count }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fs-company-label">
                                                            <label>Time Zone:</label>
                                                        </td>
                                                        <td>{{ clientInfo.timezone }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <client-contacts-tab :id="this.$route.params.id"></client-contacts-tab>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="fs-client-time">
                                        <label>Client Time</label>
                                        <span class="fs-time">{{ clientTime }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8 col-lg-9 fs-page-right">
                            <div class="row">
                                <div class="col col-sm-12">
                                    <OnBoardingChecklist></OnBoardingChecklist>
                                </div>
                                <div class="col col-sm-12">
                                    <CarouselResources
                                        :rows="resourceCarouselData"
                                        :headerTitle="'Current Assigned Resource'">
                                    </CarouselResources>
                                </div>
                                <div class="col col-sm-12">
                                    <h3>Suggested Resources</h3>
                                    <div class="fs-resources-content">
                                        <h5>Feature will be coming soon...</h5>
                                    </div>
                                    <!-- For Sprint 2 -->
                                    <!-- Follow Current Assigned Resource Carousel Format above -->
                                    <!-- <CarouselResources
                                        :rows="resourceCarouselData"
                                        :headerTitle="'Suggested Resource'"
                                        :onClick="carouselCallback"
                                        :showButton="true">
                                    </CarouselResources>  -->
                                </div>
                                <div class="col col-sm-12">
                                    <div class="content-section">
                                        <div class="content-section-child">
                                            <div class="content-section-child-header">
                                                <div class="col-sm-11 fs-content-section-child-title">Description</div>
                                                <div class="col-sm-1 fs-content-section-child-icon" v-if="descLoading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                                <div class="col-sm-1 fs-content-section-child-icon" v-else>
                                                    <a
                                                        href="javascript:;"
                                                        v-if="!elementFocusDesc"
                                                        @click="elementFocusDesc = !elementFocusDesc">
                                                        <i class="la la-pencil-square ks-icon"></i>
                                                    </a>
                                                    <div class="action-icons" v-else>
                                                        <a href="javascript:;" @click="undoChanges('desc')">
                                                            <i class="la la-close ks-icon"></i>
                                                        </a>
                                                        <a href="javascript:;" @click="updateClientDescription()">
                                                            <i class="la la-check ks-icon"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content-section-child-data">
                                                <textarea-editable
                                                    :text="clientData.description"
                                                    :showAsEditing="elementFocusDesc"
                                                    @focus="elementFocusDesc = $event"
                                                    @change="clientNewData.description = $event">
                                                </textarea-editable>
                                                <div class="content-section-child-data-loading" v-if="descLoading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content-section-child">
                                            <div class="content-section-child-header">
                                                <div class="col-sm-11 fs-content-section-child-title">Notes</div>
                                                <div class="col-sm-1 fs-content-section-child-icon" v-if="notesLoading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                                <div class="col-sm-1 fs-content-section-child-icon" v-else>
                                                    <a
                                                        href="javascript:;"
                                                        v-if="!elementFocusNotes"
                                                        @click="elementFocusNotes = !elementFocusNotes">
                                                        <i class="la la-pencil-square ks-icon"></i>
                                                    </a>
                                                    <div class="action-icons" v-else>
                                                        <a href="javascript:;" @click="undoChanges('notes')">
                                                            <i class="la la-close ks-icon"></i>
                                                        </a>
                                                        <a href="javascript:;" @click="updateClientNotes()">
                                                            <i class="la la-check ks-icon"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content-section-child-data">
                                                 <textarea-editable
                                                    :text="clientData.notes"
                                                    :showAsEditing="elementFocusNotes"
                                                    @focus="elementFocusNotes = $event"
                                                    @change="clientNewData.notes = $event">
                                                </textarea-editable>
                                                 <div class="content-section-child-data-loading" v-if="notesLoading">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-sm-12">
                                    <tab-nav :tabs="tabColumns" v-on:updatePagination="updatePagination">
                                        <template slot="Projects">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-7">
                                                    <br/>
                                                    <div class="dataTable_buttons">
                                                        <button
                                                            type="button"
                                                            tag="button"
                                                            class="btn btn-primary"
                                                            @click="openModals({ key: 'create-project', name: 'Add New Project', client_id: clientInfo.id })">
                                                            Add New Project
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <data-table
                                                    :columns="data.columns"
                                                    :sortKey="sortKey"
                                                    :sortOrder="sortOrder"
                                                    :pagination="config.pagination"
                                                    :searchPlaceholder="searchPlaceholder"
                                                    @sort="sortList($event)"
                                                    @select="updateList($event)"
                                                    @search="search($event)"
                                                    @prev="paginate('prev')"
                                                    @next="paginate('next')"
                                                    @page="paginate($event)">
                                                <!-- BEGIN EMPLOYEES DATA -->
                                                <tbody>
                                                <tr
                                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                                    v-for="(project, index) in client_projects"
                                                    :key="project.id">
                                                    <td>{{ project.id }}</td>
                                                    <td><span class="user-profile">{{ project.project_name }}</span></td>
                                                    <td><span class="user-profile">{{ project.project_description }}</span></td>
                                                    <td><span class="user-profile"><a @click="updateURL(project.project_url)" class='client-url'>{{ project.project_url }}</a></span></td>
                                                    <td>
                                                        <span class="user-profile" v-if="project.start_date">{{ formatDate(project.start_date,'MM/DD/YYYY') }}</span>
                                                        <span class="user-profile" v-else>TBD</span>
                                                    </td>
                                                    <td><span class="user-profile">{{ getStatus(project.status_id) }}</span></td>
                                                    <td><span class="user-profile"></span>{{ getResource(project.resources) }}</td>
                                                    <td align="center">
                                                        <a 
                                                            href="javascript:;"
                                                            class="action-button"
                                                            title="Resources"
                                                            @click="openModals({ key: 'add-resource', name: 'Add Resources', project_id: project.id })">
                                                            <i class="la la-group"></i>
                                                        </a>
                                                        <a
                                                            href="javascript:;"
                                                            class="action-button"
                                                            title="Edit Project"
                                                            @click="showEditDialogue({ key: 'create-project', name: 'Update Project', project_id: project.id, status_id: project.status_id })">
                                                            <i class="la la-pencil"></i>
                                                        </a>
                                                        <a
                                                            href="javascript:;"
                                                            class="action-button"
                                                            title="Delete Project"
                                                            @click="getResource(project.resources) > 0 ? showInfo() : showConfirm(project.id,project.project_name)">
                                                            <i class="la la-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <!-- END EMPLOYEES DATA -->
                                            </data-table>
                                        </template>
                                        <template slot="Surveys">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-7">
                                                    <br>
                                                    <div class="dataTable_buttons">
                                                        <router-link :to="{name: 'project-surveys', params: {id: this.$route.params.id}}" class="btn btn-primary">Add New Survey</router-link>
                                                    </div>
                                                </div>
                                            </div>
                                            <data-table
                                                :columns="data.surveyColumns"
                                                :sortKey="sortKey"
                                                :sortOrder="sortSurveyOrder"
                                                :pagination="config.pagination"
                                                :searchPlaceholder="searchSurveyPlaceholder"
                                                :showSearch="!showOptions"
                                                @sort="sortSurveyList($event)"
                                                @select="updateSurveyList($event)"
                                                @search="searchSurvey($event)"
                                                @prev="paginateSurvey('prev')"
                                                @next="paginateSurvey('next')"
                                                @page="paginateSurvey($event)">
                                                <div class="flex-row filter-position" slot="filter"><i v-show="loading" class="fa fa-spinner fa-spin"></i></div>
                                                <div class="filter-position" slot="specific">
                                                    <label>
                                                        <select2
                                                        :options="filterSelections"
                                                        :value="filterDefault"
                                                        :disabled="loading"
                                                        style="width: 100px;"
                                                        @select="chooseFilter($event)"
                                                        >
                                                        </select2>
                                                    </label>

                                                    <label v-if="showOptions" class="filter-by">
                                                        <select2
                                                        :options="filterOptions"
                                                        :value="optionsDefault"
                                                        :disabled="loading"
                                                        style="width: 178px;"
                                                        @select="doFilterBySelected($event)"
                                                        >
                                                        </select2>
                                                    </label>
                                                </div>
                                                <tbody>
                                                    <tr
                                                        :class="index % 2 == 0 ? 'even' : 'odd'"
                                                        style="cursor: pointer;"
                                                        v-for="(survey, index) in surveyData"
                                                        :key="survey.id">
                                                        <td>
                                                            {{ survey.projectSurveyName }} <br/>
                                                            <span v-if="survey.isResponded == false" style="color:blue; font-size: smaller">
                                                                Awaiting Response
                                                            </span>
                                                            <span v-else-if="survey.isResponded == true" style="color:green; font-size: smaller">
                                                                Responded
                                                            </span>
                                                            <span v-else style="color:red; font-size: smaller">
                                                                Not yet Sent
                                                            </span>
                                                        </td>
                                                        <td>{{ survey.project.data.project_name }}</td>
                                                        <td>{{ survey.etemplate.data.templateName }}</td>
                                                        <td>{{ survey.questionnaire.data.name }}</td>
                                                        <td>
                                                            {{ survey.recurringTypeName }} <br/>
                                                            <span v-if="survey.isConfirmationNeeded == 1 && survey.isConfirmed == 1" style="color: green; font-size: smaller">
                                                                Confirmed
                                                            </span>
                                                            <span v-else-if="survey.isConfirmationNeeded == 1 && survey.isConfirmed == 0" style="color: blue; font-size: smaller">
                                                                Awaiting Confirmation
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span v-if="survey.lastDateSent">
                                                                <date-display :value="survey.lastDateSent.date" displayType="datetime" />
                                                            </span>
                                                            <span> - </span>
                                                        </td>
                                                        <td>
                                                            <span v-if="survey.isResponded">
                                                                {{ survey.lastResponder }}
                                                            </span>
                                                            <span v-else> - </span>
                                                        </td>
                                                        <td>
                                                            <span v-if="survey.isResponded && survey.lastDateResponded">
                                                                <date-display :value="survey.lastDateResponded.date" displayType="datetime" />
                                                            </span>
                                                            <span v-else> - </span>
                                                        </td>
                                                        <td align="center">
                                                            <a
                                                                href="javascript:;"
                                                                class="action-button"
                                                                title="Edit"
                                                                @click="editSurvey(survey)"
                                                            >
                                                                <i class="la la-pencil"></i>
                                                            </a>
                                                            <a
                                                                href="javascript:;"
                                                                class="action-button"

                                                                title="View Responses"
                                                                @click="viewResponses({
                                                                    key: 'view-responses',
                                                                    surveyLink: survey.surveyLink,
                                                                    isResponded: survey.isResponded,
                                                                    projectSurveyName: survey.projectSurveyName,
                                                                    projectSurveyId: survey.id})"
                                                            >
                                                                <i class="la la-file-text"></i>
                                                            </a>
                                                            <a
                                                                href="javascript:;"
                                                                class="action-button"
                                                                :title="(survey.isConfirmationNeeded && !(survey.isConfirmed)) ? 'Confirm Survey' : 'Manual Send'"
                                                                @click="manualSend(survey)"
                                                            >
                                                                <i class="la la-send-o"></i>
                                                            </a>
                                                            <a
                                                                href="javascript:;"
                                                                class="action-button"
                                                                title="Delete"
                                                                @click="showDeleteConfirmation(survey.id, survey.projectSurveyName)"
                                                            >
                                                                <i class="la la-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </data-table>
                                        </template>
                                    </tab-nav>
                                </div>
                                <div class="col col-sm-12">
                                    <h3 class="mb-4">Client Onboarding Results</h3>
                                    <!--
                                        THESE ARE TEMPORARY DATA
                                        change to dynamic / DB generated data
                                     -->
                                    <span v-if="onboardResponses === undefined || onboardResponses.length === 0">No data found.</span>
                                    <table v-else class="fs-custom-table">
                                        <tr v-for="(result, i) of firstOnboardResponses" :key="i">
                                            <td><p>{{ result.label }}:</p></td>
                                            <td><p class="fs-highlighted-text">{{ result.value }}</p></td>
                                        </tr>
                                    </table>
                                    <hr/>
                                    <table class="fs-custom-table">
                                        <tr v-for="(result, i) of secondOnboardResponses" :key="i">
                                            <td><p>{{ result.label }}:</p></td>
                                            <td><p class="fs-highlighted-text">{{ result.value }}</p></td>
                                        </tr>
                                        <!-- FORM IS FOR CONFIRMATION -->
                                        <!-- <tr clas="remarks-form">
                                            <td colspan="2">
                                                <p>Remarks/Notes:</p>
                                                <textarea rows="5"></textarea>
                                                <button class="btn btn-primary float-right">Update</button>
                                            </td>
                                        </tr> COMMENT FOR NOW SINCE THIS FEATURE IS NOT PLANNED - Ralph -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->

        <!-- BEGIN WORK DETAIL DIALOG -->
        <profile-photo-modal v-if="form.key == 'client-photo' && client" :photo="photo(client)" :openModal="open" @success="reload()" @close="open = false"></profile-photo-modal>
        <create-client-modal v-if="open == true && form.key == 'update-client'" :openModal="open" @success="reload()" @close="reload()" :info="form"></create-client-modal>
        <create-project-modal v-if="open == true && form.key == 'create-project'" :openModal="open" @success="reload()" @close="open = false" :info="form"></create-project-modal>
        <add-resource v-if="open == true && form.key == 'add-resource'" :openModal="open" @success="reload()" @close="open = false" :info="form"></add-resource>
        <view-responses v-if="openViewResponse == true && surveyForm.key == 'view-responses'" :openModal="openViewResponse" @success="getSurveyData()" @close="closeModal" :survey="surveyForm"></view-responses>
        <!-- END WORK DETAIL DIALOG -->
        <create-user-modal v-if="form_user_modal.key == 'create-update-user' && open_user_modal" :openModal="open_user_modal" :info="form_user_modal" @close="open_user_modal = false"></create-user-modal>
    </div>
</template>

<style>
    body {
        position: relative;
        height: 100%;
    }
</style>

<style lang="scss" scoped>
    .fs-page-left, .fs-page-right {
        position: relative;
    }
    .fs-page-right {
        .row > .col {
            margin: 1em 0;
        }
    }
    .client-time {
        margin-top: 10px;
    }
    .filter-position {
        display: inline;
    }
    .editable {
        cursor: pointer;
        &:hover {
            text-decoration: underline;
        }
    }
    .fs-profile-photo {
        .fs-info-flex.flex-row {
            margin: 0 0 5px;
            padding: 0 1rem 0;
            a {
                width: 100%;
            }
        }
    }
    .fs-company-header {
        min-height: 70px;
        .fs-company-name {
            font-size: 25px;
            margin-bottom: 10px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .fs-company-location {
            margin: -10px 0 0;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    }
    .fs-company-content {
        margin: 10px 0 0;
    }
    .ks-nav-body {
        padding: 0 30px 0!important;
    }
    .client-url {
        color: #25628F!important;
        cursor: pointer;
    }
    .action-button {
        font-size: 20px;
    }
    .fs-back-link {
        padding-top: 15px;
         a {
            color: #333;
        }
    }
    .delete {
        color: #fff;
    }
    .tab-item {
        padding: 15px 43px 0px 15px;
        height: 110px;
        margin-bottom: 20px;
        overflow-y: auto;
    }
    .client-details {
        padding-top: 15px!important;
    }
    .card-header {
        position: relative;
        top: 6px!important;
    }
    .card-block {
        padding-bottom: 5px!important;
    }
    .fs-accord {
        padding-top: 15px!important;
    }
    .profile-photo {
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .avatar {
        width: 100%;
    }
    table#fs-company-details {
        tbody {
            tr td {
                padding: 0!important;
                &.fs-company-label {
                    color: #868583;
                    font-weight: bold;
                    padding: 0!important;
                    label {
                        width: 150px;
                        margin: 0!important;
                    }
                }
            }
        }
    }
    .nav-link {
        display: block;
        padding: 0.5rem 1rem 0.5rem 0rem;
        color: #868583;
        font-weight: bold;
    }
    .ks-nav-tabs {
        width: 147px;
    }
    .flex-row.filter-position {
        display: flex;
        align-items: center;
    }
    .clear_filters{
        color: #25628F!important;
        cursor: pointer;
        font-size: 10px;
    }
    .add_filter{
        color: #25628F!important;
        cursor: pointer;
    }
    .close_filter{
        color: white !important;
        border: 1px solid;
        border-radius: 50%;
        position: absolute;
        right: 0;
        bottom: 24px;
        z-index: 1;
        background: gray;
        padding: 1px 4px 1px 3px;
        font-size: 9px;
        cursor: pointer;
        display: none;
    }
    .filters-container{
        display: flex;
        align-items: center;
    }
    .filter-element{
        position: relative;
    }
    .filter-element:hover .close_filter{
        display: block;
    }
    .filter-by {
        padding-left: 8px;
    }
    .nav-tabs a {
        padding: 10px;
    }
    .fs-client-time {
        text-align: center;
        border: 1px solid #dee0e1;
        border-radius: 0.5rem;
        margin: 0.5em 0 0;
        padding: 1rem;
        font-size: 0.9rem;
        label {
            font-weight: 600;
            margin: 0;
        }
        span {
            display: block;
        }
    }
    .content-section {
        .content-section-child {
            flex: 0 0 100%;
            display: flex;
            flex-flow: row wrap;
            .content-section-child-header {
                flex: 0 0 100%;
                background: #949494;
                color: #fff !important;
                vertical-align: middle;
                padding: 0.4rem;
                display: flex;
                align-items: center;
                font-size: 0.9em;
                .fs-content-section-child-title {
                    letter-spacing: 1px;
                    font-weight: 500;
                    font-size: 1.5em!important;
                }
                .fs-content-section-child-icon {
                    text-align: right;
                    padding-right: 0;
                    font-size: 1.5em;
                    i.la, i.fa {
                        color: #fff;
                    }
                }
            }
            .content-section-child-data {
                background: #eeeeee;
                margin: 0.5em;
                padding: 1.5rem;
                flex: auto;
                position: relative;
                .content-section-child-data-loading {
                    top: 0;
                    left: 0;
                    min-width: 100%;
                    min-height: 100%;
                    position: absolute;
                    background: #5a59596e;
                    text-align: center;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    i {
                        font-size: 3rem;
                        color: #fff;
                    }
                }
            }
        }
    }
    .fs-resources-content {
        width: 100%;
        height: 50px;
        border: 1px solid #dee0e1;
        border-radius: 0.5rem;
        text-align: center;
        padding: 1rem;
    }
    .fs-custom-table {
        font-size: 15px;
        letter-spacing: 0.5px;
        width: 100%;
        tr {
            &.remarks-form {
                td {
                    padding: 5px 0!important;
                }
            }
            td {
                &:not(:first-child) {
                    padding-left: 20px;
                }
                p {
                    margin-bottom: 0.7rem!important;
                }
            }
        }
    }
    .fs-highlighted-text {
        font-weight: 600;
    }
    textarea {
        resize: none;
        width: 100%;
    }
    @media (max-width: 1530px) {
        .fs-container {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            min-width: 319px;
            width: 100%;
        }
    }
</style>

<script>
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import OnBoardingChecklist from '@components/onboarding-checklist.vue';
    import CarouselResources from '@components/carousel-resources.vue';
    import Select2 from "@components/select2.vue";
    import DateDisplay from "@components/date-display.vue";
    import TextareaEditable from "@components/form/textarea-editable.vue";
    import TabNav from "@components/tabs.vue";

    import { ClientProject } from '@common/model/ClientProject';
    import { ClientProjectStatus } from '@common/model/ClientProjectStatus';

    import DataTableMixin from '@common/mixin/DataTableMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    import DateMixin from '@common/mixin/DateMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import ApplicantMixin from '@common/mixin/ApplicantMixin';

    import CreateClientModal from '@views/pages/client/_modals/create-client.vue';
    import CreateProjectModal from '@views/pages/client/_modals/create-project.vue';
    import ProfilePhotoModal from '@views/pages/client/_modals/profile-photo.vue';
    import AddResource from '@views/pages/client/_modals/add-resource.vue';
    import ViewResponses from '@views/pages/client/_modals/view-responses.vue';
    import CreateUserModal from '@components/modal/user/create-user.vue'

    import { Client } from '@common/model/Client';

    // tab content component import
    import ClientContactsTab from '@views/pages/client/_tabs/client-contacts.vue';


    import { mapActions, mapGetters } from 'vuex'
    import ClientMixin from '@common/mixin/ClientMixin';
    import _ from 'lodash';
    import moment from 'moment-timezone';
    import 'simplebar';
    import 'simplebar/dist/simplebar.css';

    export default {
        components: {
            PageHeader,
            PageContent,
            DataTable,
            ModalDialog,
            CreateProjectModal,
            ProfilePhotoModal,
            CreateClientModal,
            ClientContactsTab,
            AddResource,
            OnBoardingChecklist,
            Select2,
            DateDisplay,
            ViewResponses,
            CreateUserModal,
            TextareaEditable,
            CarouselResources,
            TabNav
        },
        mixins: [
            DataTableMixin,
            ModalDialogMixin,
            AlertMixin,
            DateMixin,
            ClientMixin,
            ApplicantMixin
        ],
        data() {
            let sortKey = 'id';
            let sortOrder = {};
            let sortSurveyOrder = {};

            let columns = [
                { label: 'ID', key: 'id', sortKey: 'id', width: '1%', sortable: true },
                { label: 'Project Name', key: 'project_name', sortKey: 'project_name', width: '23%', sortable: true },
                { label: 'Description', key: 'project_description', width: '30%', sortable: false },
                { label: 'URL', key: 'project_url', width: '10%', sortable: false },
                { label: 'Start Date', key: 'start_date', sortKey: 'start_date', width: '10%', sortable: true },
                { label: 'Status', key: 'status_id', sortKey: 'status_id', width: '10%', sortable: true },
                { label: 'Resource', key: 'resource', sortKey: 'resource', width: '6%', sortable: false },
                { label: 'Action', key: 'action', width: '10%', sortable: false }
            ];

            let surveyColumns = [
                { label: 'Name',                    key: 'name',                 sortKey: 'project_survey_name',    width: '10%', sortable: true },
                { label: 'Project',                 key: 'project_name',         sortKey: 'project_id',             width: '10%', sortable: true },
                { label: 'Email Template',          key: 'etemplate',            sortKey: 'email_template_id',      width: '10%', sortable: true },
                { label: 'Survey Questionnaire',    key: 'questionnaires.name',  sortKey: 'questionnaire_id',       width: '10%', sortable: true },
                { label: 'Occurence',               key: 'recurringType',        sortKey: 'recurring_type',         width: '10%', sortable: true },
                { label: 'Last Date Sent',          key: 'lastDateSent',         sortKey: '',                       width: '10%', sortable: false },
                { label: 'Last Responder',          key: 'lastResponder',        sortKey: '',                       width: '10%', sortable: false },
                { label: 'Last Date Responded',       key: 'lastDateResponded',    sortKey: '',                     width: '10%', sortable: false },
                { label: 'Action',                  key: '',                     sortKey: '',                       width: '10%', sortable: false }
            ]
            surveyColumns.forEach((col) => {
                sortSurveyOrder[col.sortKey] = 'desc';
            });

            columns.forEach((col) => {
                sortOrder[col.sortKey] = 'asc';
            });

            return {
                pageClass: 'ks-content-nav',
                title: "Client's Profile",
                sortKey: 'id',
                sortOrder: sortOrder,
                sortSurveyOrder: sortSurveyOrder,
                searchPlaceholder: 'Enter Project Name',
                limit: 50,
                open: false,
                loading: false,
                openViewResponse: false,
                open_user_modal: false,
                data: {
                    columns: columns,
                    surveyColumns, surveyColumns
                },
                form: {
                    key: '',
                    name: '',
                    client_id: ''
                },
                surveyForm: {
                    key: '',
                    projectSurveyName: '',
                    projectSurveyId: ''
                },
                form_user_modal: {
                    key: '',
                    name: '',
                    client_id: '',
                    hideOtherFields: ''
                },
                modal: {
                    width: '800px',
                    height: '400px',
                    margin: '7rem 0 0',
                },
                client_projects: [],
                project_statuses: [],
                clientPhoto: `/assets/img/logos/default-corporate-image.png`,
                status_instruction: 'Click to change status',
                searchSurveyPlaceholder: 'Enter Survey Name',
                surveyData: [],
                showOptions: false,
                filterDefault: "1",
                optionsDefault: "1",
                filterOptionSelected: "0",
                filterKey: "",
                filterSelections: [
                    { id: 1, text: "Name" },
                    { id: 2, text: "Status" },
                    { id: 3, text: "Project" },
                    { id: 4, text: "Occurrence" }
                ],
                filterOptions: [],
                statusOptions: [
                    { id: 1, text: "Awaiting Confirmation" },
                    { id: 2, text: "Confirmed" },
                    { id: 3, text: "Awaiting Response" },
                    { id: 4, text: "Responded" },
                    { id: 5, text: "Not Yet Sent" },
                ],
                occurrenceOptions: [
                    { id: 1, text: "Monthly" },
                    { id: 2, text: "Quarterly" },
                    { id: 3, text: "Semi-Annually" },
                    { id: 4, text: "Annually" },
                    { id: 5, text: "Manually" },
                ],
                clientStatus: [
                    "Active",
                    "End Contract",
                    "Prospect"
                ],
                firstOnboardResponses: [],
                secondOnboardResponses: [],
                elementFocusDesc: false,
                elementFocusNotes: false,
                clientData: {},
                clientNewData: {
                    description: '',
                    notes: ''
                },
                notesLoading: true,
                descLoading: true,
                clientTime: '',
                resourceCarouselData: [],
                clientInfo: {},
                include: ['resources.employee', 'resources.employee.positions', 'resources.employee.photo', 'resources.employee.skills'],
                tabColumns: ['Projects', 'Surveys']
            }
        },
        async created() {
            try {
                this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
                await this.getClient(this.$route.params.id);
                await this.getCurrentProjects();
                await this.getOnboardingResults();

                this.clientInfo = this.client;
                this.setPagination(this.meta.pagination);
                ClientProjectStatus.get().then((res) => {
                    this.project_statuses = res.data;
                });

                if (this.clientInfo.photo.data.length) {
                  this.clientPhoto = _.last(this.clientInfo.photo.data).path;
                }
                this.clearSurveyData()
                await this.getSurveyData();
                this.updatePagination();

            } catch(e) {
                this.$router.push('/clients');
            }

            setInterval(() => { this.getClientTime() }, 1000);
            this.setNewData()
        },
        computed: {
            ...mapGetters({
                client:'clients/client',
                meta:'clientProjects/meta',
                surveys: 'surveys/data',
                surveyMeta:'surveys/surveyMeta',
                projectOptions: 'clientProjects/formatted',
                projects: 'clientProjects/data',
                onboardResponses: 'allQuestionResponses/data',
            })
        },
        methods: {
            ...mapActions({
                deleteClient: 'clients/deleteClient',
                deleteClientContact: 'clientContacts/deleteContact',
                getClient: 'clients/getClient',
                getClientProjects: 'clientProjects/getClientProjects',
                getSurveys: 'surveys/getSurveys',
                getProjects: 'clientProjects/getProjects',
                deleteSurvey: 'surveys/deleteSurvey',
                clearSurveyData: 'surveys/clearSurveyData',
                prepSurvey: 'surveys/editSurvey',
                saveClient: 'clients/saveClient',
                getOnboardResponses: 'allQuestionResponses/getAllQuestionResponses',
            }),
            async getCurrentProjects() {
                await this.getClientProjects({
                    query: _.merge(this.getParams(), {
                        client_id: this.$route.params.id,
                        include: this.include.join(',')
                    })
                });
                this.client_projects = this.projects;
                this.resourceCarousel(this.client_projects);
            },
            async getOnboardingResults() {
                await this.getOnboardResponses({
                    query: {
                        filterBy: 'category,client',
                        filterVar: 'client-onboarding,' + this.$route.params.id,
                        take: 100,
                    },
                });
                let responses = this.formatOnboardingResults(this.onboardResponses);
                this.firstOnboardResponses = responses.first || [];
                this.secondOnboardResponses = responses.second || [];
            },
            alert() {
                console.log("Hello");
            },
            resourceCarousel(projects) {
                let carouselArray = [];
                let data = {};

                if(projects.length > 0) {
                    for(let index in projects) {
                        let resourceData = projects[index].resources.data;
                        if(resourceData.length > 0) {
                            for(let subIndex in resourceData) {
                                let exists = !!data[resourceData[subIndex]['employee_id']]
                                if (!exists) {
                                    data[resourceData[subIndex]['employee_id']] = [resourceData[subIndex]['employee'].data]
                                    carouselArray.push(resourceData[subIndex]['employee'].data);
                                }
                            }
                        }
                    }
                }
                this.resourceCarouselData = _.orderBy(carouselArray, 'first_name');
            },
            carouselCallback(employee) {
                // The Carousel returns the employee object.
                // console.log(employee, employee.employee_no);
            },
            getClientTime() {
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                let clientTimezone = this.clientInfo.timezone
                let defaultTimeZone = 'UTC'
                let timezone = moment.tz.zone(clientTimezone) ? clientTimezone : defaultTimeZone
                let nativeTime = new Date(new Date().toLocaleString("en-US", {timeZone: timezone}))
                let date =  months[nativeTime.getMonth()] + ' ' + nativeTime.getDate() + ', ' + nativeTime.getFullYear()
                let timeSplits = nativeTime.toLocaleTimeString().split(':')
                this.clientTime = date + ' ' + timeSplits[0] + ':' + timeSplits[1] + ' ' + timeSplits[2].split(' ')[1]
            },
            updatePagination(tab){
                if(tab == "Surveys") {
                    this.setPagination(this.surveyMeta.pagination);
                }
                else {
                    this.setPagination(this.meta.pagination);
                }
            },
            manualSend(survey) {
                this.$router.push({name: 'project-surveys-manualsend', params: {id: survey.id.toString()}})
            },
            editSurvey(survey) {
                this.$router.push({ name: 'project-surveys', params: { surveyId: survey.id.toString() }})
            },
            async paginate(page){
                this.gotoPage(page);
                await this.getCurrentProjects();
                this.setPagination(this.meta.pagination);
            },
            async updateList(limit) {
                this.setPaginationLimit(limit);
                await this.getCurrentProjects();
                this.setPagination(this.meta.pagination);
            },
            async search(term) {
                this.setSearch(term);
                await this.getCurrentProjects();
                this.setPagination(this.meta.pagination);
            },
            async reload() {
                this.open = false;
                await this.getClient(this.$route.params.id);
                this.clientInfo = this.client;
                await this.getCurrentProjects();
                this.setPagination(this.meta.pagination);
                if (this.clientInfo.photo.data.length) {
                  this.clientPhoto = _.last(this.clientInfo.photo.data).path + '?' + (new Date().getTime());
                }
            },
            async sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
				this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                await this.getCurrentProjects();
                this.setPagination(this.meta.pagination);
            },
            async updateStatus(data){
                let thisClient = new Client({ id: data.id });
                thisClient.save(data).then((res) => {
                    this.getClient(this.$route.params.id);
                });
            },
            openModals(form){
                this.form = form;
                this.open = true;
            },
            closeModal(){
                this.openViewResponse = false;
                this.$router.go(-1);
            },
            openSuperAdminUserInvite(options) {
                this.form_user_modal = options;
                this.open_user_modal = true;
            },
            showEditDialogue(options) {
                if(options.key == undefined) {
                    this.$set(options,'key','update-client');
                    this.$set(options,'name','Update Client');
                }

                this.openModals(options);
            },
            showClientConfirm(client) {
                const title = 'Are you sure you want to delete this client?';
                const msg = `${client.company}`;
                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                    .then(({ ok }) => {
                        if(ok) {
                            this.deleteClient(client.id).then(() => {
                                client.contacts.data.forEach((contact) => {
                                    this.deleteClientContact(contact.id);
                                });

                                this.reload();
                                this.$router.push("/client-management");
                            });
                        }
                    });
            },
            showConfirm(id, projectname) {
                const title = 'Are you sure you want to delete this project?';
                const msg = `${projectname} `;
                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                    .then(({ ok }) => {
                        if(ok) {
                            new ClientProject({id:id}).delete().then((res) => {
                                this.updateList();
                                this.notifyDialog('error', 'Successfully deleted!');
                            });
                        }
                    });
            },
            showInfo() {
                const title = `Can't Delete Project`;
                const msg = `The project can't be deleted because there are assigned resources.`;
                this.confirmDialog(title, msg, 'Ok', '', 'sm');
            },
            updateURL(val) {
                let url = '';
                if (val.indexOf('http://') === -1 && val.indexOf('https://') === -1) {
                    url =  window.location.protocol + "//" + val;
                } else {
                    url = val;
                }

                window.open(url, '_blank').focus();
            },
            getStatus(val) {
                let stat = 'N/A';
                this.project_statuses.every((obj) => {
                    if(obj.id == val) {
                        stat = obj.name;
                        return false;
                    } else {
                        return true;
                    }
                });

                return stat;
            },
            getResource(val) {
                return val.data.length;
            },
            // SURVEY TERRITORY
            async getSurveyData(){
                this.surveyData = [];
                this.loading = true;
                await this.getSurveys({
                    query: _.merge(
                        this.getParams(),
                        {
                            clientId: this.$route.params.id
                        }
                    )
                }).then(() => {
                    this.surveyData = this.surveys
                    this.loading = false;
                    this.openViewResponses = false;
                });

                this.setPagination(this.surveyMeta.pagination);
            },
            paginateSurvey(page) {
                this.gotoPage(page);
                this.getSurveyData();
                this.setPagination(this.surveyMeta.pagination);
            },
            updateSurveyList(limit) {
                this.setPaginationLimit(limit);
                this.getSurveyData();
            },
            searchSurvey(term) {
                this.gotoPage();
                this.setSearch(term);
                this.getSurveyData();
            },
            sortSurveyList(key) {
                this.sortKey = key;
                this.sortSurveyOrder[key] = this.sortSurveyOrder[key] == 'asc' ? 'desc' : 'asc';
                this.setSorting(`${this.sortKey}|${this.sortSurveyOrder[key]}`);
                this.getSurveyData();
            },
            chooseFilter(filter) {
                this.filterOptions = [];
                this.optionsDefault = 1;
                this.filterKey = "";
                switch(filter) {
                    case '1':
                        //Name
                        this.showOptions = false;
                        this.setFilter();
                        this.getSurveyData();
                        break;
                    case '2':
                        //Status
                        this.filterOptions = this.statusOptions;
                        this.filterKey = "status";
                        break;
                    case '3': //Project
                        if (this.projectOptions.length > 0){
                            this.filterOptions = this.projectOptions;
                            this.filterKey = "project_id";
                            this.optionsDefault = this.projectOptions[0].id;
                        }
                        break;
                    case '4':
                        //Occurrence
                        this.filterOptions = this.occurrenceOptions;
                        this.filterKey = "recurring_type";
                        break;
                }
                if (filter != 1) {  
                    this.doFilterBySelected(this.optionsDefault);
                    this.showOptions = true;
                }
            },
            doFilterBySelected(selected) {
                this.filterOptionSelected = selected;
                if(this.filterOptionSelected == '') {
                    this.filterOptionSelected = 0;
                }

                this.setFilter(`${this.filterKey}|${this.filterOptionSelected}`);
                this.getSurveyData();
            },
            viewResponses(surveyInfo){
                if (surveyInfo.surveyLink != null && surveyInfo.isResponded) {
                    window.open('/survey/responses/'+ surveyInfo.surveyLink, '_blank');
                }
                else {
                    this.surveyForm = surveyInfo;
                    this.openViewResponse = true;
                }
            },
            showDeleteConfirmation(surveyId, surveyName) {
                const self = this;
                const title = 'Are you sure you want to delete this project survey?';
                const msg = `${surveyName} `;
                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                    .then(({ ok }) => {
                        self.loading = true;
                        if(ok) {
                            this.deleteSurvey(surveyId).then((res) => {
                                if(res == 0) {
                                    this.alertDialog('Survey cannot be deleted.', 'Some respondent(s) were not yet able to respond', 'Ok', 'sm');
                                }
                                this.getSurveyData();
                                self.loading = false;
                            });
                        }
                    });
            },
            setNewData() {
                this.clientData = this.client;
                this.notesLoading = false;
                this.descLoading = false;
            },
            async updateClientDescription() {
                this.descLoading = !this.descLoading;
                this.clientData.description = this.clientNewData.description;
                this.saveClient(this.clientData).then((res) => {
                    this.elementFocusDesc = !this.elementFocusDesc;
                    this.descLoading = !this.descLoading
                }, () => { this.undoChanges('desc'); });
            },
            async updateClientNotes() {
                this.notesLoading = !this.notesLoading;
                this.clientData.notes = this.clientNewData.notes;
                this.saveClient(this.clientData).then((res) => {
                    this.elementFocusNotes = !this.elementFocusNotes;
                    this.notesLoading = !this.notesLoading
                }, () => {  this.undoChanges('notess'); });
            },
            undoChanges(field) {
                if(field === "desc") {
                    this.clientNewData.description = this.client.description;
                    this.elementFocusDesc = !this.elementFocusDesc;
                } else {
                    this.clientNewData.notes = this.client.notes;
                    this.elementFocusNotes = !this.elementFocusNotes;
                }
            }
        }
    }
</script>
