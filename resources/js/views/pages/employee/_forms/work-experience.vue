<template>
    <div>
        <div class="row form-group">
            <div class="col-lg-6">
                <label>Company Name</label>
                <input type="text" name="company_id" class="form-control" v-model="formData.company" />
            </div>
            <div class="col-lg-6">
                <label>Job Title</label>
                <input type="text" name="job-title_id" class="form-control" v-model="formData.jobTitle" />
            </div>
            
        </div>

        <h4>Duration</h4>

        <div class="row form-group">
            <div class="col-lg-6">
                <label>Start Date</label>
                <flat-pickr
                    v-model="formData.dateStart"
                    :config="getConfig(true, false, {allowInput:true})"
                    placeholder="Select a date"
                    name="date_start"
                />
            </div>
            <div class="col-lg-6">
                <label>End Date</label>
                <flat-pickr
                    v-model="formData.dateEnd"
                    :config="getConfig(true, false, {allowInput:true})"
                    placeholder="Select a date"
                    name="date_end"
                />
            </div>
            
        </div>

         <h4>Reason of Leaving</h4>

        <div class="row form-group">
        	<div class="col-lg-12">
                <textarea class="form-control" name="reason Leaving"v-model="formData.reasonLeaving" rows="10" column="5" id="comment" placeholder="Type here.."></textarea>
            </div>
        </div>	
        <div class="row">
            <div class="col-lg-12">
                <footer class="dialog-footer">
                    <button type="button" class="btn btn-danger" @click="$emit('close')">Cancel</button>
                    <save-button :loading="loading" class="btb btn-primary" @action="save">Save</save-button>
                </footer>
            </div>
        </div>
    </div>
</template>

<style scoped>
.custom-shift {
    display: flex;
    flex-direction: row;
    margin-top: 10px;
}

.custom-shift .time-selection:first-child {
    margin-right: 10px;
}

.position-level {
    display: flex;
    flex-direction: column;
    width: 300px;
}

.position-el {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.current-position {
    display: flex;
    flex-direction: row;
}

.position {
    width: 380px;
}

</style>

<script>
import DateMixin from '@common/mixin/DateMixin';
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import DatePickerMixin from '@common/mixin/DatePicker';
import SaveButton from '@components/form/button.vue';
import VueTagsInput from '@johmun/vue-tags-input';
import Select2 from '@components/select2.vue';
import { WorkShift } from '@common/model/WorkShift';
import { JobPosition } from '@common/model/JobPosition';
import _ from 'lodash';
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

export default {
    props: {
        info: {
            type: Object,
            required: true
        },
        modal: {
            type: Object,
            default: function() {
                return {
                    width: '800px',
                    height: '650px'
                }
            }
        }
    },
    data() {
        return {
            loading: false,
            custom: false,
            shifts: {
                options: [],
                value: []

            },
            button: {
                class: 'btn btn-success',
                type: 'button'
            },
            formData: {
                jobTitle:'',
                company: '',
                starDate: '',
                endDate: '',
            } 
        }
    },
    
    components: {
        SaveButton,
        VueTagsInput,
        Select2,
        FlatPickr
    },
    mixins: [
        DateMixin,
        EmployeeMixin,
        DatePickerMixin
    ],
    methods: {
        save() {
           
        }
    }
}
</script>
