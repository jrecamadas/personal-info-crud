<template>
    <div>
        <page-header :title="title" />
        <page-content :page-class="pageClass">
            <div class="ks-nav-body">
                <loader v-show="isProcessing" />
                <div class="ks-nav-body-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link
                                    :to="{name: 'questionnaires'}"
                                    class="client-profile"
                                >
                                    {{ this.$route.params.qName }}
                                </router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link
                                    :to="{name: 'question_categories',
                                          params: {id: this.$route.params.qId, qName: this.$route.params.qName }}"
                                    class="client-profile"
                                >
                                    {{ this.$route.params.cName }}
                                </router-link>
                            </li>
                            <li
                                class="breadcrumb-item active"
                                aria-current="page"
                            >
                                Questions
                            </li>
                        </ol>
                    </nav>
                    <div class="container-fluid">
                        <Can I="add" a="questions">
                            <div class="row">
                                <div class="col-sm-12 col-md-7 pad">
                                    <div class="form-inline">
                                        <input
                                            v-model="questionFormData.question"
                                            v-validate="'required'"
                                            type="text"
                                            name="name"
                                            size="50"
                                            class="form-control mr-sm-2"
                                            :disabled="isEditing"
                                            placeholder="Add Question"
                                            @keydown.enter="createQuestion()"
                                            @keyup="resetSSError"
                                            @keydown.esc="questionFormData.question = ''"
                                        >
                                        <save-button
                                            :options="button"
                                            :disabled="!isAddValid"
                                            @action="createQuestion"
                                        >
                                            Add
                                        </save-button>
                                    </div>
                                    <span
                                        v-show="hasSSerror"
                                        class="help-block form-error"
                                    >{{ ssError }}</span>
                                </div>
                            </div>
                        </Can>
                        <data-table
                            :columns="data.columns"
                            :sort-key="sortKey"
                            :sort-order="sortOrder"
                            :pagination="config.pagination"
                            :search-placeholder="searchPlaceholder"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)"
                        >
                            <!-- BEGIN questionS DATA -->
                            <draggable
                                v-if="questions.length"
                                :element="'tbody'"
                                :options="dragOptions"
                                @end="updateDisplaySequence"
                            >
                                <tr
                                    v-for="(question, index) in questions"
                                    :key="question.id"
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                >
                                    <td>
                                        <span
                                            class="action-button la la-arrows-v cursor-pointer dragbutton2"
                                            title="Drag"
                                        />
                                    </td>
                                    <td>
                                        <div v-show="editOffset != index">
                                            {{ question.question }}
                                        </div>
                                        <div v-show="editOffset==index">
                                            <div class="form-inline">
                                                <input
                                                    :id="'item-user-'+index"
                                                    v-model="questionFormData.updateQuestion"
                                                    v-validate="'required'"
                                                    type="text"
                                                    name="name"
                                                    size="60"
                                                    class="form-control mr-sm-2"
                                                    @keyup="resetSSErrorUpdate"
                                                    @keydown.enter="updateQuestion({
                                                        id: question.id,
                                                        question: questionFormData.updateQuestion,
                                                    })"
                                                    @keydown.esc="cancelEditing()"
                                                >
                                            </div>
                                            <span
                                                v-show="hasSSerrorUpdate"
                                                class="help-block form-error"
                                            >{{ ssError }}</span>
                                        </div>
                                    </td>
                                    <td
                                        @click="updateStatus({id:question.id, index: index})"
                                    >
                                        <span
                                            v-if="question.isActive"
                                            class="badge ks-circle badge-success no_selection cursor-pointer"
                                            title="Deactivate question"
                                        >
                                            Active
                                        </span>
                                        <span
                                            v-else
                                            class="badge ks-circle badge-danger no_selection cursor-pointer"
                                            title="Activate question"
                                        >
                                            Inactive
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div v-show="editOffset != index">
                                            <Can I="update" a="questions">
                                                <span
                                                    class="action-button la la-pencil cursor-pointer"
                                                    title="Edit question"
                                                    @click="startEditing(index)"
                                                />
                                            </Can>
                                        </div>
                                        <div v-show="editOffset==index">
                                            <span
                                                class="action-button la la-check mr-sm-2 cursor-pointer"
                                                title="Save"
                                                @click="updateQuestion({
                                                    id: question.id,
                                                    question: questionFormData.updateQuestion
                                                })"
                                            />
                                            <span
                                                class="action-button la la-close cursor-pointer"
                                                title="Cancel"
                                                @click="cancelEditing()"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            </draggable>
                            <!-- END questionS DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
        </page-content>
    </div>
</template>
<style lang="scss" scoped>
.pad {
    padding-bottom: 20px;
}

.client-profile {
    color: #333;

    &:hover {
        text-decoration: underline;
    }
}

.action-button {
    font-size: 20px;
    color: #25628F;
}

.cursor-pointer {
    cursor: pointer;
}

</style>
<script>
// components
import PageHeader from '@components/page-header.vue';
import PageContent from '@components/page-content.vue';
import DataTable from '@components/datatable.vue';
import SaveButton from '@components/form/button.vue';
import draggable from 'vuedraggable';
import Loader from "@components/loader.vue";

// mixins
import DataTableMixin from '@common/mixin/DataTableMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import AlertMixin from '@common/mixin/AlertMixin';

import { mapActions, mapGetters } from 'vuex';
import _ from 'lodash';

export default {
    components: {
        DataTable,
        PageHeader,
        PageContent,
        SaveButton,
        draggable,
        Loader,
    },
    mixins: [
        DataTableMixin,
        StringHelperMixin,
        AlertMixin,
    ],
    data() {
        const sortOrder = {};
        const sortKey = 'display_sequence';
        const columns = [
            { key: 'draggable', width: '5%', sortable: false },
            {
                label: 'Question',
                key: 'question',
                sortKey: 'question',
                width: '75%',
                sortable: false,
            },
            {
                label: 'Status',
                key: 'is_active',
                sortKey: 'is_active',
                width: '10%',
                sortable: false,
            },
            { label: 'Action', width: '10%', sortable: false },
        ];

        columns.forEach((col) => {
            sortOrder[col.sortKey] = 'asc';
        });

        return {
            title: 'Survey Questions',
            pageClass: 'ks-content-nav',
            sortKey,
            sortOrder,
            searchPlaceholder: 'Search Question',
            isProcessing: false,
            isEditing: false,
            limit: 10,
            open: false,
            editOffset: -1,
            editPost: {},
            editPostOri: {},
            hasSSerror: false,
            ssError: null,
            hasSSerrorUpdate: false,
            isDragDisabled: false,
            questionFormData: {
                id: 0,
                question: '',
                questionCategoryId: this.$route.params.id,
                updateQuestion: '',
            },
            data: {
                columns,
                rows: [],
            },
            validation: [{
                path: 'question',
                name: 'question',
                rule: 'required',
                msg: { required: 'The Question field is required' },
            }],
            button: { class: 'btn btn-primary', type: 'button' },
        };
    },
    computed: {
        ...mapGetters({
            questions: 'questions/data',
            meta: 'questions/meta',
        }),
        dragOptions() {
            return {
                handle: '.dragbutton2',
                disabled: this.isDragDisabled,
            };
        },
        isAddValid() {
            let valid = true;
            _.each(this.validation, (form) => {
                const rules = form.rule.split('|');
                // validate accordingly
                _.each(rules, (rule) => {
                    if (rule === 'required') {
                        if (this.isEmpty(_.get(this.questionFormData, form.path))) {
                            valid = false;
                        }
                    }
                });
            });
            return valid;
        },
    },
    async created() {
        this.setSorting(`${this.sortKey}`);
        this.reload();
    },
    methods: {
        ...mapActions({
            getQuestions: 'questions/getQuestions',
            saveQuestion: 'questions/saveQuestion',
            updateQuestionStatus: 'questions/updateQuestionStatus',
            updateQuestionDisplaySequence: 'questions/updateQuestionDisplaySequence',
        }),

        // #region SAVING QUESTIONS
        async createQuestion() {
            this.resetSSError();
            this.errors.clear();
            this.save(this.questionFormData);
        },
        async updateQuestion(data) {
            if (data.question === '' || data.question === this.editPost.question) { this.cancelEditing(); } else {
                this.resetSSErrorUpdate();
                this.save(data);
            }
        },
        async save(questionData) {
            this.isProcessing = true;
            questionData.questionCategoryId = this.$route.params.id;
            this.saveQuestion(questionData).then(() => {
                this.isProcessing = false;
                this.$emit('success');
                this.cancelEditing();
                this.reload();
                setTimeout(() => {
                    this.questionFormData = {};
                }, 150);
            }).catch((e) => {
                this.isProcessing = false;
                this.isEditing = false;
                // Create Function
                if (questionData.id === 0) {
                    this.hasSSerror = true;
                } else {
                    this.hasSSerrorUpdate = true;
                }
                this.ssError = e.response.data.message.question[0];
            });
        },
        async updateStatus(data) {
            const newStatus = !(this.questions[data.index].isActive);
            this.questions[data.index].isActive = newStatus;
            data.isActive = newStatus;
            this.isProcessing = true;
            this.updateQuestionStatus(data).then(() => {
                this.isProcessing = false;
                this.$emit('success');
                this.reload();
            });
        },
        // #region INLINE UPDATE TRIGGERS
        async startEditing(index) {
            if(!this.isAddValid){
                this.isDragDisabled = true;
                this.isEditing = true;
                this.editOffset = index;
                this.editPost = this.questions[index];
                this.editPostOri = JSON.parse(JSON.stringify(this.editPost));
                this.questionFormData.updateQuestion = this.editPost.question;
                this.$nextTick(() => {
                    document.getElementById(`item-user-${this.editOffset}`).focus();
                });
            }  
        },
        async cancelEditing() {
            this.editOffset = -1;
            this.editPostOri = {};
            this.editPost = {};
            this.isDragDisabled = false;
            this.isEditing = false;
            this.hasSSerror = false;
            this.hasSSerrorUpdate = false;
        },
        async getData() {
            const qcId = this.$route.params.id;
            if (qcId === undefined || qcId <= 0) {
                // Reverted back to Questionnaires
                this.$router.push('questionnaires');
            } else {
                const payload = {
                    query: this.getParams(),
                };
                payload.query.categoryId = qcId;
                await this.getQuestions(payload);
                this.setPagination(this.meta.pagination);
            }
        },
        async paginate(page) {
            this.gotoPage(page);
            this.getData();
        },
        async search(term) {
            this.gotoPage();
            this.setSearch(term);
            this.getData();
        },
        async sortList(key) {
            this.sortKey = key;
            this.sortOrder[key] = this.sortOrder[key] === 'asc' ? 'desc' : 'asc';
            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
            this.getData();
        },
        async updateList(limit) {
            this.setPaginationLimit(limit);
            this.getData();
        },
        async reload() {
            this.getData();
            this.open = false;
        },
        resetSSError() {
            this.hasSSerror = false;
            this.ssError = '';
        },
        resetSSErrorUpdate() {
            this.hasSSerrorUpdate = false;
            this.ssError = '';
        },
        updateDisplaySequence(evt) {
            if (evt.newIndex !== evt.oldIndex) {
                const data = {
                    id: this.questions[evt.oldIndex].id,
                    displaySequence: this.questions[evt.newIndex].displaySequence,
                };
                this.updateQuestionDisplaySequence(data).then(() => {
                    this.$emit('success');
                    this.reload();
                    setTimeout(() => {
                        this.questionFormData = {};
                    }, 150);
                });
            }
        },
    },
};

</script>
