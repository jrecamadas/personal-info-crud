<template>
  <div>
    <page-header v-bind:title="title"></page-header>
    <page-content :pageClass="pageClass">
      <div class="ks-nav-body">
        <div class="ks-nav-body-wrapper">
          <div class="container-fluid">
            <div class="row">
              <div class="input-wrapper" :class="{'disable-click': isLoading}">
                <label class="btn btn-success ks-btn-file">
                  <span class="la la-cloud-upload ks-icon font-white"></span>
                  <span class="ks-text font-white" v-if="fileUpload.name">New file selected</span>
                  <span class="ks-text font-white" v-else>Choose file</span>
                  <input
                    type="file"
                    name="uploadFile"
                    accept=".csv"
                    @change="handleFileUpload"
                    ref="csvFileInput"
                  >
                </label>
                <div class="week-wrapper">
                  <flat-pickr
                    class="form-control upload-input week"
                    v-model="date"
                    name="week"
                    placeholder="Select week span"
                    :config="getConfig(true, false, {maxDate: 'today'})"
                  />
                </div>
                <span v-if="weekDisplay">Week: {{ weekDisplay }}</span>
                <input
                  class="form-check-input upload-input payroll"
                  type="checkbox"
                  name="isParseAndDownload"
                  id="isParseAndDownload"
                  v-model="parseDetails.isParseAndDownload"
                >
                <label for="isParseAndDownload" class="payroll-label">Parse &amp; Download only</label>
                <i
                  @click="confirmDialog('Tips', tooltipHints, 'Close', false)"
                  class="fa ks-color-primary fa-info-circle tooltip-indicator"
                  :title="tooltipHints"
                ></i>
                <button class="btn btn-success confirm" :disabled="disableSubmit" @click="submit">
                  <span v-if="isLoading" class="fa fa-spinner fa-spin"></span>
                  <span v-else-if="isUploadSuccess" class="la la-check ks-icon"></span>
                  <span v-else class="font-white">Confirm</span>
                </button>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <span
                  class="help-block file-fail"
                  v-if="!isValidFileFormat"
                >Unsupported file. Please use a CSV file.</span>
              </div>
            </div>
            <div class="row">
              <table
                class="table table table-striped table-bordered table-hover"
                cellpadding="10"
                width="100%"
              >
                <thead>
                  <tr>
                    <td class="width-5">Status</td>
                    <td class="width-5">Version</td>
                    <td class="width-20">Week</td>
                    <td class="width-20">Uploaded by</td>
                    <td class="width-20">Upload date</td>
                    <td class="width-20">Remarks</td>
                    <td class="width-10">Action</td>
                  </tr>
                </thead>
                <tbody v-if="typeof parseHistory == 'object' && Object.keys(parseHistory).length">
                  <tr v-for="index in parseHistoryKeys">
                    <td>
                      <div
                        v-if="parseHistory[index][currentWeekIndex(index)].status == 'success'"
                        class="status-icon-container status-success"
                      >
                        <span class="la la-check ks-icon"></span>
                      </div>
                      <div v-else class="status-icon-container status-fail">
                        <span class="la la-close ks-icon"></span>
                      </div>
                    </td>

                    <td v-if="parseHistory[index].length > 1">
                      <select @change="updateBatchIndex(index, $event.target.value)">
                        <option
                          v-for="(item, subIndex) in parseHistory[index]"
                          :value="subIndex"
                        >{{ item.batch }}</option>
                      </select>
                    </td>
                    <td v-else>{{ parseHistory[index][currentWeekIndex(index)].batch }}</td>
                    <td>
                      <a
                        :href="parseHistory[index][currentWeekIndex(index)].filename"
                        target="_blank"
                      >{{ formatWeekRangeToReadableFormat(parseHistory[index][currentWeekIndex(index)]) }}</a>
                    </td>
                    <td>{{ parseHistory[index][currentWeekIndex(index)].uploaded_by }}</td>
                    <td>{{ formatUploadDate(parseHistory[index][currentWeekIndex(index)].upload_date.date) }}</td>
                    <td>{{ parseHistory[index][currentWeekIndex(index)].remarks }}</td>
                    <td>
                      <a
                        :href="parseHistory[index][currentWeekIndex(index)].report_link"
                        target="_blank"
                      >
                        <button
                          v-show="parseHistory[index][currentWeekIndex(index)].report_link"
                          class="btn btn-default"
                        >
                          <span class="la la-cloud-download ks-icon"></span>
                          <span class="ks-text">Download</span>
                        </button>
                      </a>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td v-if="retrieveError" colspan="10">
                      <p>{{ retrieveError }}</p>
                    </td>
                    <td v-else colspan="10">No data to show.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </page-content>
  </div>
</template>

<style scoped>
select {
  border: 0;
}
td {
  text-align: center;
  vertical-align: middle;
}
thead {
  font-weight: bold;
  background: #ebeef5;
}
.btn {
  color: black;
}
.confirm {
  margin-left: 30px;
}
.disable-click {
  pointer-events: none;
  background-color: #d0d2d0;
}
.fa-info-circle {
  font-size: 16px;
}
.file {
  width: 250px;
}
.input-wrapper {
  position: relative;
}
.ks-btn-file {
  margin-top: 6px;
}
.la-cloud-download {
  font-size: 16px;
}
.payroll {
  margin-left: 10px;
  margin-top: 19px;
}
.payroll-label {
  margin-left: 25px;
}
.status-icon-container {
  color: white;
  background: #81c159;
  border-radius: 50%;
  display: inline-block;
  width: 21px;
}
.status-icon-container span {
  font-weight: bolder;
}
.status-success {
  background-color: #81c159;
}
.status-fail {
  background-color: #f14343;
}
.upload-input {
  display: inline-block;
}
.upload-success-container {
  display: inline-block;
  position: relative;
}
.upload-success {
  font-size: 35px;
  font-weight: bolder;
  color: green;
}
.week {
  width: 200px;
  display: inline-block;
  position: relative;
}
.week-wrapper {
  display: inline-block;
}
.file-fail {
  color: #ef5350;
}
.tooltip-indicator {
  cursor: pointer;
}
.font-white {
  color: #ffffff;
}
.width-5 {
  width: 5%;
}
.width-10 {
  width: 10%;
}
.width-20 {
  width: 20%;
}
</style>

<script>
import PageHeader from "@components/page-header.vue";
import PageContent from "@components/page-content.vue";
import FlatPickr from "vue-flatpickr-component";
import DataTable from "@components/datatable.vue";

import { Asset } from "@common/model/Asset";
import { WorkLog } from "@common/model/WorkLog";
import AlertMixin from "@common/mixin/AlertMixin";
import DownloadMixin from "@common/mixin/DownloadMixin";
import DatePickerMixin from "@common/mixin/DatePicker";

import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      title: "Tsheet Parser",
      pageClass: "ks-content-nav",
      fileUpload: {
        folder: "tsheets",
        assetable_id: "",
        type: 5,
        assetable_type: "tsheets",
        name: "",
        medium: null,
        medium_type: "file",
        old_id: "",
        old_cv: ""
      },
      date: "",
      weekDisplay: "",
      parseDetails: {
        weekStartDate: "",
        weekEndDate: "",
        isParseAndDownload: false
      },
      isLoading: false,
      weekIndex: {},
      selected: 0,
      retrieveError: "",
      isUploadSuccess: false,
      parseHistoryKeys: 0,
      isValidFileFormat: true,
      tooltipHints:
        "This will process the file uploaded without saving it to the database, meant for payroll. No week required."
    };
  },
  watch: {
    date: function(val) {
      if (val) {
        const maxWeekCount = 6; // Sunday starts with 0
        let parsedDate = new Date(val);

        let interval = maxWeekCount - parsedDate.getDay();
        parsedDate.setDate(parsedDate.getDate() + interval);
        this.parseDetails.weekEndDate =
          parsedDate.getFullYear() +
          "-" +
          (parsedDate.getMonth() + 1) +
          "-" +
          parsedDate.getDate();
        parsedDate.setDate(parsedDate.getDate() - maxWeekCount);
        this.parseDetails.weekStartDate =
          parsedDate.getFullYear() +
          "-" +
          (parsedDate.getMonth() + 1) +
          "-" +
          parsedDate.getDate();

        this.weekDisplay = this.formatWeekRangeToReadableFormat({
          weekStartDate: this.parseDetails.weekStartDate,
          weekEndDate: this.parseDetails.weekEndDate
        });
        this.parseDetails.isParseAndDownload = false;
      }
    },
    parseHistory: function(val) {
      const component = this;
      if (typeof this.parseHistory != "object") {
        component.retrieveError =
          "Unable to retrieve history. Please try again.";
      } else {
        this.parseHistoryKeys = Object.keys(this.parseHistory)
      }
    },
    isUploadSuccess: function(val) {
      if (val) {
        setTimeout(() => (this.isUploadSuccess = false), 3000);
      }
    },
    dropdownIndeces: function(val) {
      this.weekIndex = val;
    },
    parseDetails: {
      handler: function(val) {
        if (val.isParseAndDownload) {
          this.parseDetails.weekStartDate = "";
          this.parseDetails.weekEndDate = "";
          this.date = "";
          this.weekDisplay = "";
        }
      },
      deep: true
    },
  },
  created: function() {
    this.getParseHistory({ query: { take: 9999, page: 0 } });
    this.weekIndex = this.dropdownIndeces;

    let component = this;
    window.onbeforeunload = function(event) {
      if(component.isLoading) {
        return true;
      }
      return;
    };
  },
  computed: {
    ...mapGetters({
      loggedInUser: "auth/data",
      parseHistory: "workLogs/formatted",
      dropdownIndeces: "workLogs/dropdownIndeces"
    }),
    disableSubmit: function() {
      return !(
        this.fileUpload.name &&
        this.isValidFileFormat &&
        (this.weekDisplay || this.parseDetails.isParseAndDownload)
      );
    }
  },
  methods: {
    ...mapActions({
      getParseHistory: "workLogs/getParseHistory"
    }),
    handleFileUpload(event) {
      let uploadedFiles = event.target.files || event.dataTransfer.files;
      if (!uploadedFiles.length || !this.isValidFile(uploadedFiles)) {
        this.fileUpload.medium = null;
        this.fileUpload.name = "";
        return;
      }
      this.fileUpload.name = uploadedFiles[0].name;

      let reader = new FileReader();
      reader.onload = event => {
        this.fileUpload.medium = event.target.result;
      };
      reader.readAsDataURL(uploadedFiles[0]);
    },
    handleDownload(filePath) {
      this.downloadFile(filePath, filePath);
    },
    updateBatchIndex(mainIndex, subIndex) {
      this.weekIndex = { ...this.weekIndex, [mainIndex]: subIndex };
    },
    currentWeekIndex(week) {
      return this.weekIndex[week];
    },
    submit() {
      this.isLoading = true;
      const component = this;
      let isAutoDownload = component.parseDetails.isParseAndDownload;
      const uploadData = {
        userId: component.loggedInUser.data.id,
        file: component.fileUpload.name,
        ...component.parseDetails,
        ...component.fileUpload,
        assetable_id: component.loggedInUser.data.id
      };

      const workLog = new WorkLog();
      workLog
        .save(uploadData)
        .then(res => {

          component.$dialogs.alert("File successfully parsed.", {
            title: "Success",
            size: "sm"
          });

          component.getParseHistory({ query: { take: 9999, page: 0 } });
          component.isUploadSuccess = true;

          if (isAutoDownload) {
            component.handleDownload(res.data.path);
          }
          component.isLoading = false;
          component.restoreDefault();
        })
        .catch(e => {
          let errMessage =
            "Something went wrong. Please check input and try again";
          if (e.response.data) {
            errMessage = e.response.data.message;
          }

          component.$dialogs.alert(errMessage, {
            title: "Save error",
            size: "sm"
          });
          component.isLoading = false;
        });
    },
    restoreDefault() {
      this.fileUpload.medium = null;
      this.fileUpload.name = "";
      this.parseDetails.weekStartDate = "";
      this.parseDetails.weekEndDate = "";
      this.date = "";
      this.weekDisplay = "";
      this.$refs.csvFileInput.value = "";
    },
    formatUploadDate(uploadDate) {
      return moment(uploadDate, "YYYY-MM-DD hh:mm:ss").format("lll");
    },
    formatWeekRangeToReadableFormat(item) {
      let startDate = moment(item.weekStartDate, "YYYY-MM-DD");
      let endDate = moment(item.weekEndDate, "YYYY-MM-DD");
      let endDateConcatenator = endDate.date();
      if (startDate.format("MMM") != endDate.format("MMM")) {
        endDateConcatenator = endDate.format("MMM") + " " + endDateConcatenator;
      }
      return (
        startDate.format("MMM") +
        " " +
        startDate.date() +
        " - " +
        endDateConcatenator +
        " " +
        endDate.year()
      );
    },
    isValidFile(file) {
      let isValid = true;
      if (!file.length) {
        this.isValidFileFormat = isValid;
        return;
      }

      const fileExtension = "csv";
      const fileName = file[0].name;
      if (fileName.split(".").pop() != fileExtension) {
        isValid = false;
      }

      this.isValidFileFormat = isValid;
      return isValid;
    }
  },
  components: {
    PageContent,
    PageHeader,
    FlatPickr,
    DataTable
  },
  mixins: [DownloadMixin, DatePickerMixin, AlertMixin]
};
</script>
