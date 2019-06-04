<template>
    <div>
        <page-header :title="title"></page-header>
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
                            <div class="dataTable_buttons">
                                <Can I="add" a="work_from_home_requests">
                                    <button type="button" @click="open = true" tag="button" class="btn btn-primary">File a Request</button>
                                </Can>
                            </div>
                            </div>
                            <div class="col-sm-12 col-md-5">
								<a
								href="#"
								title="Refresh Requests"
                      			@click.prevent="refreshList"
								>
									<span class="refresh">
										<i v-if="loading" class="fa fa-spinner fa-spin"></i>
										<i v-else class="la la-refresh"></i>
									</span>
								</a>
							</div>
                        </div>
                        <div id="noSearch">
                            <data-table
                                :columns="data.columns"
                                :pagination="config.pagination"
                                @sort="sortList($event)"
                                @select="updateList($event)"
                                @search="search($event)"
                                @prev="paginate('prev')"
                                @next="paginate('next')"
                                @page="paginate($event)"
                            >
                                <!-- BEGIN STATUS DATA -->
                                <tbody v-if="wfhRequests.length">
                                    <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(request, index) in wfhRequests"
                                    :key="request.id">
                                    <td>{{ [request.start_date, "YYYY-MM-DD"] | moment("MMM D, YYYY") }}</td>
                                    <td>{{ [request.end_date, "YYYY-MM-DD"] | moment("MMM D, YYYY") }}</td>
                                    <td>{{ request.reason }}</td>
                                    <td>{{ request.notified_at ? "Sent" : "Pending" }}</td>
                                    </tr>
                                </tbody>
                                <!-- END STATUS DATA -->
                            </data-table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BEGIN MODAL DIALOG -->
            <modal-dialog v-show="open" :options="option" :title="'File a Request'" @close="closeModal" oncontextmenu="return false;">
                <template slot="button">
                    <save-button :loading="loading" @action="save" :disabled="!valid">Create</save-button>
                </template>
                <template slot="body">
                    <div class="tab-pane active" id="basic" role="tabpanel" aria-expanded="false">
                        <div class="row content-row d-flex align-items-center">
                            <div class="col col-sm-12 text-center">
                                <div class="alert alert-danger ks-solid-light ks-active-border" role="alert" v-if="isConflictDate">
                                    <div v-if="isConflictDate">
                                        <label>You have already requested a work-from-home for the following dates:</label>
                                        <p><span class="error" v-html="splitDate"></span></p>
                                    </div>
                                </div>

                            </div>
                            <div class="col col-sm-6 mt-3">
                                <label>Start Date:<span class="error">*</span></label>
                                <flat-pickr
                                    name="start_date"
                                    placeholder="Start Date"
                                    v-model="formData.start_date"
                                    :config="getConfig(true, false, {
                                        maxDate: this.formData.end_date,
                                        disable: this.disableDates
                                    })"
                                    v-validate="'required'" />
                                <span v-show="hasDBError" class="error help-block form-error">{{ getDBError('start_date') }}</span>
                            </div>
                            <div class="col col-sm-6 mt-3">
                                <label>End Date:<span class="error">*</span></label>
                                <flat-pickr
                                    name="end_date"
                                    placeholder="End Date"
                                    v-model="formData.end_date"
                                    :config="getConfig(true, false, {
                                        minDate: this.formData.start_date,
                                        disable: this.disableDates
                                    })"
                                    v-validate="'required'"/>
                                <span v-show="hasDBError" class="error help-block form-error">{{ getDBError('end_date') }}</span>
                            </div>
                            <div class="col col-sm-12 mt-3">
                                <label>Reason</label><span class="error">*</span>
                                <textarea class="form-control" v-model="formData.reason" name="reason" rows="5" column="5" placeholder="Type here.." style="resize: none;"></textarea>
                                <span v-show="hasDBError" class="error help-block form-error">{{ getDBError('reason') }}</span>
                            </div>
                        </div>
                    </div>
                </template>
            </modal-dialog>
            <!-- END MODAL DIALOG -->
        </page-content>
    </div>
</template>
<style scope>
	.refresh {
		float: right;
		font-size: 25px;
		padding: 10px;
	}
</style>
<style>
    #noSearch #search-field, #noSearch .search-icon  {
        display:none
    }

</style>

<script>
    //Components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    import Select2 from '@components/select2.vue';
    import FlatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';
    import SaveButton from '@components/form/button.vue';

    //Models
    import { Employee } from '@common/model/Employee';

    //Modals
    import ModalDialog from '@components/modal-dialog.vue';

    //Mixins
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import EmployeeMixin from '@common/mixin/EmployeeMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import DatePickerMixin from '@common/mixin/DatePicker';

    import { mapGetters, mapActions } from 'vuex';
    import _ from 'lodash';

    export default {
        components: {
            PageHeader,
            PageContent,
            DataTable,
            ModalDialog,
            Select2,
            FlatPickr,
            SaveButton,
        },
        mixins: [
            DataTableMixin,
            EmployeeMixin,
            ModalDialogMixin,
            DatePickerMixin,
        ],
        data() {
            let sortKey = 'employee_no';
	        let columns = [
	            { label: 'Start Date', key: 'startdate', sortKey: 'startdate', width: '25%', sortable: false },
	            { label: 'End Date', key: 'enddate', sortKey: 'enddate', width: '25%', sortable: false },
                { label: 'Reason', key: 'reason', sortKey: 'reason', width: '40%', sortable: false },
                { label: 'Status', key: 'status', sortKey: 'status', width: '10%', sortable: false },
	        ];
            let sortOrder = {
                id: 'desc'
            };

            columns.forEach((col) => {
                sortOrder[col.sortKey] = 'desc';
            });

            return {
                pageClass: 'ks-content-nav',
                title: 'Work From Home Request',
                sortKey: 'id',
                sortOrder: sortOrder,
                open: false,
                pageLimit: 10,
                loading: false,
                data: {
                    columns: columns,
                    rows: []
                },
                option: {
                    height: 'auto',
                    width: '600px',
                    bottom: 'auto'
                },
                formData: {
                    employee_id: '',
                    start_date: '',
                    end_date: '',
                    reason: '',
                },
                validation: [
                    { path: 'start_date', name: 'start_date', rule: 'required', msg: {required: 'The start date field is required'} },
                    { path: 'end_date', name: 'end_date', rule: 'required', msg: {required: 'The end date field is required'} },
                    { path: 'reason', name: 'reason', rule: 'required', msg: {required: 'The reason field is required'} },
	            ],
                listedDates: [],
                isConflictDate: false,
                hasDBError: false,
                dbError: [],
            }
        },
        mounted() {
            this.createdBulkLoad();
        },
        computed: {
            ...mapGetters({
                loggedInUser: 'auth/data',
                loggedInEmployee: 'employees/logged_in_employee',
                wfhRequests: 'workFromHome/list',
                meta:'workFromHome/meta',
            }),
            valid: function() {
                let valid = true;

                // check validation form validation set rule
                _.each(this.validation, (form) => {
                    // break validation rule
                    let rules = form.rule.split('|');

                    // validate accordingly
                    _.each(rules, (rule) => {
                        if (rule == 'required') {
                            if (_.isEmpty(_.get(this.formData, form.path))) {
                                valid = false;
                                return;
                            }
                        }
                    });

                    if (!valid) {
                        return;
                    }
                });

                return valid;
            },
            disableDates() {
                let disabledDates = [];
                let results = [];

                _.each(this.wfhRequests, (req) => {
                    let dates = this.getDatesByDateRange(req.start_date, req.end_date);

                    disabledDates = dates.concat(disabledDates);
                });

                return disabledDates;
            },
            splitDate() {
                let dates = this.listedDates.toString().split(',');
                let vm = this;
                let dateFinal = [];

                dates.forEach(function(i) {
                    dateFinal.push(vm.$moment(i).format('MMM DD, YYYY'));
                });

                return dateFinal.join('<br>');
            }
        },
        methods: {
            ...mapActions({
                getLoggedInEmployee: 'employees/getLoggedInEmployee',
                saveWfhRequest: 'workFromHome/saveRequest',
                getWfhRequest: 'workFromHome/getWfhList',
            }),
            async createdBulkLoad() {
                let params = {
                    user_id: this.loggedInUser.data.id,
                    include: 'workFromHomeRequests',
                };
                await this.getLoggedInEmployee(params);
                await this.getWfhRequest(_.merge(this.getParams(),{employee_id: this.loggedInEmployee.id , orderBy: ['id|desc']}));
                this.setPagination(this.meta.pagination);
            },
            async reload() {
                await this.getWfhRequest(_.merge(this.getParams(),{employee_id: this.loggedInEmployee.id}));
		    	this.setPagination(this.meta.pagination);
		    	this.open = false;
            },
            async paginate(page) {
                this.gotoPage(page);
                await this.getWfhRequest(_.merge(this.getParams(),{employee_id: this.loggedInEmployee.id}));
	            this.setPagination(this.meta.pagination);
            },
            async updateList(pageLimit) {
                this.setPaginationLimit(pageLimit);
                await this.getWfhRequest(_.merge(this.getParams(),{employee_id: this.loggedInEmployee.id}));
                this.setPagination(this.meta.pagination);
            },
            async setPaginate(page) {
                this.gotoPage(page);
                await this.getWfhRequest(_.merge(this.getParams(),{employee_id: this.loggedInEmployee.id}));
                this.setPagination(this.meta.pagination);
            },
            async refreshList() {
				this.loading = true;
				await this.getWfhRequest(_.merge(this.getParams(),{employee_id: this.loggedInEmployee.id}));
				this.setPagination(this.meta.pagination);
				this.loading = false;
			},
            getDatesByDateRange(startDate, endDate, includeWeekend = true) {
                let a = moment(startDate);
                let b = moment(endDate);
                let m, dates = [];

                for (m = moment(a); m.diff(b, 'days') <= 0; m.add(1, 'days')) {
                    if (!includeWeekend && this.checkDateIfWeekend(m)) {
                        continue;
                    }

                    dates.push(m.format('YYYY-MM-DD'));
                }

                return dates;
            },
            dateRangeContain(rangeStart, rangeEnd, compareDate) {
                let a = moment(rangeStart);
                let b = moment(rangeEnd);
                let c = moment(compareDate);

                return !(c.isBefore(a) || c.isAfter(b))
            },
            isConflictDates(startDate, endDate) {
                let conflictDate = false;

                _.each(this.wfhRequests, (request) => {
                    // checking if date inputs is conflict with existing dates
                    let startInputCheck = this.dateRangeContain(request.start_date, request.end_date, startDate);
                    let endInputCheck = this.dateRangeContain(request.start_date, request.end_date, endDate);

                    // checking if existing dates is conflict with input dates
                    let startExistCheck = this.dateRangeContain(startDate, endDate, request.start_date);
                    let endExistCheck = this.dateRangeContain(startDate, endDate, request.end_date);

                    if (startInputCheck || endInputCheck || startExistCheck || endExistCheck) {
                        conflictDate = {
                            startDate: request.start_date,
                            endDate: request.end_date,
                        };// needed to return affected dates for error display
                        return false;// break loop
                    }
                });

                return conflictDate;
            },
            checkDateIfWeekend(date) {
                let d = moment(date).isoWeekday();

                /*saturday = 6 and sunday = 7*/
                return d === 6 || d === 7;
            },
            save() {
                this.hasDBError = false;
                this.dbError = [];
                this.formData.employee_id = this.loggedInEmployee.id;
                this.listedDates = [];
                let data = this.formData;
                let conflict = this.isConflictDates(data.start_date, data.end_date);

                if (conflict) {
                    this.listedDates = this.getDatesByDateRange(conflict.startDate, conflict.endDate, false);
                    this.isConflictDate = true;
                } else {
                    this.isConflictDate = false;
                    this.saveDb(data);
                }
            },
            saveDb(data) {
                this.loading = true;
                this.errors.clear();

                this.saveWfhRequest(data).then(() => {
                    this.$emit('success');
                    this.closeModal();

                    this.createdBulkLoad();
                })
                .catch((e) => {
                    this.loading = false;
                    this.hasDBError = true;
                    let counter = 0;
                    _.each(e.response.data.message, (errMsg) => {
                        this.dbError[Object.keys(e.response.data.message)[counter]] = errMsg[0];
                        counter++;
                    });
                });
            },
            getDBError(key) {
                if (Object.keys(this.dbError).length) {
                    return (this.dbError.hasOwnProperty(key)) ? this.dbError[key] : '';
                }
                return;
            },
            resetDbError() {
                this.hasDBError = false;
                this.dbError = [];
            },
            closeModal() {
                this.open = false;
                this.loading = false;
                this.formData = {};
                this.isConflictDate = false;
                this.resetDbError();
            },
        },
    }
</script>
