<template>
    <div>
        <page-header :title="title" />
        <page-content :page-class="pageClass">
            <div class="ks-nav-body">
                <loader v-show="isProcessing" />
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link
                                        :to="{name: 'questionnaires'}"
                                        class="category-question"
                                    >
                                        {{ this.$route.params.qName }}
                                    </router-link>
                                </li>
                                <li
                                    class="breadcrumb-item active"
                                    aria-current="page"
                                >
                                    Category
                                </li>
                            </ol>
                        </nav>
                        <Can I="add" a="question_categories">
                            <div
                                id="create-category"
                                class="row"
                            >
                                <div class="col-sm-12 col-md-7 pad-bottom">
                                    <div class="form-inline">
                                        <input
                                            v-model="categoriesFormData.createName"
                                            type="text"
                                            class="form-control mr-sm-2"
                                            placeholder="Add Category"
                                            size="50"
                                            :disabled="isEditing"
                                            name="createName"
                                            @keydown.enter="save()"
                                            @keydown.esc="categoriesFormData.createName = ''"
                                        >
                                        <save-button
                                            :disabled="!isSaveValid"
                                            :options="button"
                                            @action="save"
                                        >
                                            Add
                                        </save-button>
                                    </div>
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
                            <draggable
                                v-if="categories.length"
                                :element="'tbody'"
                                :options="dragOptions"
                                @end="onEnd"
                            >
                                <tr
                                    v-for="category in categories"
                                    :id="category.id"
                                    :key="category.id"
                                >
                                    <td>
                                        <span
                                            class="action-button la la-arrows-v cursor-pointer categoriesDrag"
                                            title="Drag"
                                        />
                                    </td>
                                    <td :class="{ editing: category == editedCategory }">
                                        <div class="view-mode">
                                            <router-link
                                                :to="{
                                                    name: 'questions',
                                                    params: {
                                                        id: category.id.toString(),
                                                        qId: category.questionnaire.data.id,
                                                        qName: category.questionnaire.data.name,
                                                        cName: category.name.toString()
                                                    }
                                                }"
                                                class="category-question"
                                            >
                                                {{ category.name }}
                                            </router-link>
                                        </div>
                                        <div class="edit-mode">
                                            <div class="form-inline display-inline">
                                                <input
                                                    :id="category.name + category.id"
                                                    v-model="categoriesFormData.updateName"
                                                    type="text"
                                                    class="form-control mr-sm-2"
                                                    size="60"
                                                    @keydown.enter="updateCategoryNameById(category)"
                                                    @keydown.esc="cancelUpdateCategoryName()"
                                                >
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ category.questionCount }}</td>
                                    <td @click="updateCategoryStatusById(category)">
                                        <span
                                            v-if="category.isActive"
                                            class="badge ks-circle badge-success no_selection cursor-pointer"
                                            title="Deactivate category"
                                        >Active</span>
                                        <span
                                            v-else
                                            class="badge ks-circle badge-danger no_selection cursor-pointer"
                                            title="Activate category"
                                        >Inactive</span>
                                    </td>
                                    <td :class="{editing: category == editedCategory}" style="text-align: center;">
                                        <div class="edit-mode">
                                            <span
                                                class="action-button cursor-pointer la la-check"
                                                title="Update Category"
                                                @click="updateCategoryNameById(category)"
                                            />
                                            <span
                                                class="action-button cursor-pointer la la-close"
                                                title="Cancel Update"
                                                @click="cancelUpdateCategoryName()"
                                            />
                                        </div>
                                        <div class="view-mode">
                                            <Can I="update" a="question_categories">
                                                <span
                                                    class="action-button cursor-pointer la la-pencil"
                                                    title="Edit Category"
                                                    @click="startUpdateCategoryName(category)"
                                                />
                                            </Can>
                                        </div>
                                    </td>
                                </tr>
                            </draggable>
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

.cursor-pointer {
    cursor: pointer;
}

.category-question {
    color: #333;
    &:hover {
        text-decoration: underline;
    }
}

.edit-mode {
    display: none;
}

.editing .edit-mode {
    display: block;
}

.editing .view-mode {
    display: none;
}

.action-button {
    font-size: 20px;
    color: #25628F;
}

.border-none {
    border: 0px;
}

.input-bg {
    background-color : #dedbdc;
}

.display-inline {
    display: inline;
}

.show-tooltip {
    font-size: 13px;
    position: relative;
    top: -3px!important;
    padding-left: 4px!important;
}

.tooltip-indicator {
    position: absolute;
    left: 130px;
    font-size: 23px!important;
    cursor: pointer;
}
.give-space {
    margin-right: 5px;
}

.pad-bottom {
    padding-bottom: 20px;
}

.pad-right {
    padding-right: 10px;
}

</style>

<script>
import PageHeader from '@components/page-header.vue';
import PageContent from '@components/page-content.vue';
import DataTable from '@components/datatable.vue';
import SaveButton from '@components/form/button.vue';
import draggable from 'vuedraggable';
import Loader from "@components/loader.vue";

import DataTableMixin from '@common/mixin/DataTableMixin';
import StringHelperMixin from '@common/mixin/StringHelperMixin';
import AlertMixin from '@common/mixin/AlertMixin';

import { mapActions, mapGetters } from 'vuex';
import _ from 'lodash';

export default {
    components: {
        PageHeader,
        PageContent,
        DataTable,
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
                label: 'Category', key: 'name', sortKey: 'name', width: '65%', sortable: false,
            },
            {
                label: 'Questions', key: 'questionCount', width: '10%', sortable: false,
            },
            {
                label: 'Status', key: 'is_active', sortKey: 'is_active', width: '10%', sortable: false,
            },
            {
                label: 'Action', key: 'action', sortKey: 'action', width: '10%', sortable: false,
            },
        ];

        columns.forEach((col) => {
            sortOrder[col.sortKey] = 'asc';
        });

        return {
            title: 'Survey Categories',
            pageClass: 'ks-content-nav',
            searchPlaceholder: 'Search Category',
            statusInstruction: 'Click to change status',
            sortKey,
            sortOrder,
            loading: false,
            isProcessing: false,
            limit: 10,
            open: false,
            isHidden: true,
            isDragDisabled: false,
            editedCategory: null,
            editedCategorySequence: null,
            isEditing: false,
            data: {
                columns,
                rows: [],
            },
            categoriesFormData: {
                questionnaireId: this.$route.params.id,
                category_id: '',
                createName: '',
                updateName: '',
                updateSequence: '',
            },
            validation: [
                { path: 'createName', name: 'createName', rule: 'required' },
            ],
            button: { class: 'btn btn-primary', type: 'button' },
        };
    },
    computed: {
        ...mapGetters({
            meta: 'questionCategories/meta',
            categories: 'questionCategories/data',
        }),
        dragOptions() {
            return {
                disabled: this.isDragDisabled,
                handle: '.categoriesDrag',
                animation: 150,
            };
        },
        isSaveValid() {
            let valid = true;

            _.each(this.validation, (form) => {
                const rules = form.rule.split('|');
                // validate accordingly
                _.each(rules, (rule) => {
                    if (rule === 'required') {
                        if (this.isEmpty(_.get(this.categoriesFormData, form.path))) {
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
            getCategories: 'questionCategories/getCategories',
            createCategory: 'questionCategories/createCategory',
            updateCategoryName: 'questionCategories/updateCategoryName',
            updateCategoryStatus: 'questionCategories/updateCategoryStatus',
            updateCategoryDisplaySequenceById: 'questionCategories/updateCategoryDisplaySequenceById',
            updateCategoryList: 'questionCategories/updateCategoryList',
        }),
        async save() {
            this.isProcessing = true;
            this.categoriesFormData.questionnaireId = this.$route.params.id;

            this.createCategory(this.categoriesFormData).then(() => {
                this.isProcessing = false;
                this.$emit('success');
                this.cancelUpdateCategoryName();
                this.reload();
                setTimeout(() => {
                    this.categoriesFormData = {};
                }, 150);
            }).catch(() => {
                this.isProcessing = false;
            });
        },
        async startUpdateCategoryName(category) {
            if(!this.isSaveValid){
                this.isDragDisabled = true;
                this.isEditing = true;
                this.editedCategory = category;
                this.categoriesFormData.updateName = category.name;
                const categoryName = category.name + category.id.toString();

                this.$nextTick(() => {
                    document.getElementById(categoryName).focus();
                });
            }
        },
        async updateCategoryNameById(category) {
            this.isDragDisabled = false;
            this.editedCategory = null;

            if (this.categoriesFormData.updateName !== '') {
                this.isProcessing = true;
                const data = {
                    id: category.id,
                    name: this.categoriesFormData.updateName,
                };
                
                this.updateCategoryName(data).then(() => {
                    this.isProcessing = false;
                    this.$emit('success');
                    this.cancelUpdateCategoryName();
                    this.reload();
                    setTimeout(() => {
                        this.categoriesFormData = {};
                    }, 150);
                }).catch(() => {
                    this.isProcessing = false;
                    this.isEditing = false;
                });
            }
        },
        async cancelUpdateCategoryName() {
            this.isDragDisabled = false;
            this.editedCategory = null;
            this.isEditing = false;
            this.categoriesFormData = {};
        },
        updateCategoryStatusById(category) {
            this.isProcessing = true;
            const index = this.categories.findIndex(x => x.id === category.id);
            this.categories[index].isActive = !category.isActive;
            const data = {
                id: category.id,
                isActive: category.isActive,
            };

            this.updateCategoryStatus(data).then(() => {
                this.isProcessing = false;
                this.$emit('success');
            }).catch(() => {
                this.isProcessing = false;
                this.loading = false;
            });
        },
        updateDisplaySequenceById(draggedId, relatedDisplaySequence) {
            const data = {
                id: draggedId,
                displaySequence: relatedDisplaySequence,
            };

            this.updateCategoryDisplaySequenceById(data).then(() => {
                this.$emit('success');
                this.reload();
                setTimeout(() => {
                    this.form = {};
                }, 150);
            });
        },
        onEnd(evt) {
            if (evt.newIndex !== evt.oldIndex) {
                this.updateDisplaySequenceById(this.categories[evt.oldIndex].id,
                    this.categories[evt.newIndex].displaySequence);
            }
        },
        async getData() {
            const qId = this.$route.params.id;
            if (qId === undefined || qId <= 0) {
                // Reverted back to Questionnaires
                this.$router.push('questionnaires');
            } else {
                const payload = {
                    query: this.getParams(),
                };
                payload.query.questionnaireId = this.$route.params.id;
                await this.getCategories(payload);
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
    },
};
</script>
