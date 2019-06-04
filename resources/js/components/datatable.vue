<template>
	<div class="dataTables_wrapper container-fluid dt-bootstrap4">
		<div class="row">
			<div class="col-lg-6 col-sm-12 " v-if="showFilter">
				<div class="dataTables_length">
					<label>
						Show
						<select2 style="width: 57%;" :options="select2.options" :value="itemsFilter" @select="$emit('select', $event)">
						</select2>
                    </label>
					<slot name="filter"></slot>
                    <div v-if="showClearFilters">
                        <div v-if="isFilterPresent" class="clear-all-filter" slot="filter">                                    
                            <span class="badge-clear-all badge badge-primary" @click="clearAllFilters">Clear All Filters</span>
                        </div>
                    </div>
				</div>
			</div>
			<div class="col-lg-6 col-sm-12 " id="search-fixed">
				<div class="dataTables_filter">
					<!-- <slot name="filter"></slot> -->
                    <!-- This is only shown when showAdvancedSearch is true -->
                    <div class="flex-row advanced-search-container" v-show="showAdvancedSearch">
                        <i class="la la-info-circle info-advanced-search" :class="isAdvancedSearch ? 'info-advanced-search-filled':''" data-trigger="hover" data-toggle="popover" data-placement="left" data-popover-content="#popover-advanced-search"></i>
                        
                        <popover-dialog popoverId="popover-advanced-search">
                            <template slot="header">
                                Advanced Search
                            </template>
                            <template slot="body">
                                <div v-if="isAdvancedSearch">
                                    <div v-if="advancedSearch.names.length">
                                        <span class="popover-advanced-search-header">
                                            Name:
                                        </span>
                                        <span class="popover-advanced-search-body" v-for="row in advancedSearch.names" :key="row.id">
                                            - {{row.text}}
                                        </span>
                                    </div>
                                    <div v-if="advancedSearch.projects.length">
                                        <span class="popover-advanced-search-header">
                                            Project:
                                        </span>
                                        <span class="popover-advanced-search-body" v-for="row in advancedSearch.projects" :key="row.id">
                                            - {{row.text}}
                                        </span>
                                    </div>
                                    <div v-if="advancedSearch.skills.length">
                                        <span class="popover-advanced-search-header">
                                            Skill:
                                        </span>
                                        <span class="popover-advanced-search-body" v-for="row in advancedSearch.skills" :key="row.id">
                                            - {{row.text}}
                                        </span>
                                    </div>
                                    <div v-if="advancedSearch.locations.length">
                                        <span class="popover-advanced-search-header">
                                            Location:
                                        </span>
                                        <span class="popover-advanced-search-body" v-for="row in advancedSearch.locations" :key="row.id">
                                            - {{row.text}}
                                        </span>
                                    </div>
                                    <div v-if="advancedSearch.clients.length">
                                        <span class="popover-advanced-search-header">
                                            Client:
                                        </span>
                                        <span class="popover-advanced-search-body" v-for="row in advancedSearch.clients" :key="row.id">
                                            - {{row.text}}
                                        </span>
                                    </div>
                                </div>
                                <div v-else class="popover-no-advanced-search">
                                    No advanced search applied
                                </div>
                            </template>
                        </popover-dialog>

                        <!-- This is the clickable text for the advanced search modal -->
                        <span class="advanced-search"  :class="isAdvancedSearch ? 'is-advanced-search' : ''" @click="openModals({key: 'advanced-search', name: 'Advanced Search'})">Advanced Search</span>
                        <!-- This is the clickable x icon to remove the advance search values -->
                        <!-- <i class="la la-times-circle-o remove-advanced-search" v-show="isAdvancedSearch" @click="search()" title="Click to reset advanced search"></i> -->
                    </div>
					<div class="flex-row">
						<slot name="specific"></slot>
                        <label v-if="showSearch">
							<input type="search" class="form-control input-sm" :placeholder="searchPlaceholder" aria-controls="ks-datatable" v-model="searchInput" @input="search()" id="search-field" />
							<i class="search-icon la la-search"></i>
						</label>
                    </div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table table-striped table-bordered dataTable" width="100%" role="grid" aria-described-by="ks-datatable-info">
					<!-- BEGIN HEADER -->
					<thead>
					<tr role="role">
						<template v-for="column in columns">
							<th class="sort" v-if="column.sortable" :width="column.width" :key="'head-' + column.key">
                                <div @click="doSort(column.sortKey)" class="custom-flex">
                                    <div>{{ column.label }}</div>
                                    <div v-if="showFilters" style="flex:1;">
                                        <span v-if="!columnFilters[column.filter]" class="la la-filter" @click="doFilter(column.sortKey)">
                                        </span>
                                        <span v-else class="badge-clear badge badge-primary" @click="doFilter(column.sortKey)">
                                            CLEAR
                                        </span>
                                    </div>
                                    <div>
                                        <span :class="[sortKey == column.sortKey ? 'sorting_' + sortOrder[column.sortKey] : 'sorting', column.text_align]"></span>
                                    </div>
                                </div>
                                <slot :name="column.sortKey"></slot>
							</th>
							<th v-else :width="column.width" :key="'head-' + column.key" :class="column.text_align">{{ column.label }}</th>
						</template>
					</tr>
					</thead>
					<!-- END HEADER -->

					<!-- BEGIN DATA -->
					<tr v-if="tableLoading" class="fs-data-table-loading">
                        <td :colspan="columns.length">
                            <div class="loader"></div>
                        </td>
                    </tr>
					<slot v-else></slot>
					<!-- END DATA -->
				</table>
			</div>
		</div>

		<!-- BEGIN PAGINATION -->
        <div v-if="showPagination">
		    <pagination :pagination="pagination" @prev="$emit('prev', 'prev')" @next="$emit('next', 'next')" @page="$emit('page', $event)"></pagination>
        </div>
		<!-- END PAGINATION -->
        <!-- BEGIN ADVANCED SEARCH MODAL -->
        <advanced-search-modal
            v-if="open && form.key == 'advanced-search'"
            :openModal="open"
            :selectedNames="advancedSearch.names"
            :selectedProjects="advancedSearch.projects"
            :selectedSkills="advancedSearch.skills"
            :selectedLocations="advancedSearch.locations"
            :selectedClients="advancedSearch.clients"
            @close="open = false"
            @success="formatAdvancedSearch"
        ></advanced-search-modal>
        <!-- END ADVANCED SEARCH MODAL -->
	</div>
</template>

<style lang="scss" scoped>
    .sort {
        vertical-align: top;
        padding-right: 10px!important;
    }
    div.dataTables_filter > div.flex-row > label > i.search-icon{
        z-index: 1!important;
    }
    div.row > div > div.dataTables_length{
        display: flex;
    }
    .dataTables_filter {
        .flex-row {
            display: inline-block;
        }
    }
    .search-icon {
        font-size: 20px;
        vertical-align: middle;
    }
    i.search-icon.la.la-search {
        position: relative;
        right: 4px;
        padding: 5px 0px;
        color: #888;
        cursor: text;
    }    
    //Styling for the advanced search
    .advanced-search-container {
        margin-right: 15px;
    }
    .advanced-search {
        font-size: 14px;
        position: relative;
        top: 1px;
        left: 34px;
        color: green;
        cursor: pointer;
    }
    .remove-advanced-search {
        font-size: 18px;
        position: relative;
        top: 3px;
        left: 32px;
        cursor: pointer;
        border-radius: 50%;
        color:red;
        font-weight: 600;
    }
    .info-advanced-search {
        font-size: 18px;
        position: relative;
        top: 3px;
        left: 35px;
        background-color: white;
        cursor: pointer;
    }
    .info-advanced-search-filled {
        font-weight: 600;
    }
    .is-advanced-search {
        font-weight: 450;
    }
    #popover-advanced-search {
        display: none;
    }    
    .popover-no-advanced-search {
        font-size:13px;
        text-align: center;
    }
    .popover-advanced-search-header {
        font-size: 15px;
        font-weight: 450;
        color: #007840;
        display: block;
        border-bottom: solid 2px;
    }
    .popover-advanced-search-body {
        font-size: 12px;
        display: block;
    }
    #search-field {
        height: 40px;
        position: relative;
        left: 27px;
    }
    #filter-fixed {
        padding-left: 5em;
    }
    @media (max-width: 991px) {
        div.dataTables_filter {
            text-align: left !important;
        }
        div.dataTables_wrapper .dataTables_filter .form-control {
            margin-left: 24px;
        }
    }
    @media (max-width: 767px) {
        div.dataTables_wrapper .dataTables_length {
            text-align: left !important;
        }
    }
    .la-filter {
        font-size: 15px;
        vertical-align: middle;
    }
    div.dataTables_wrapper table.dataTable.table-bordered thead th:before, div.dataTables_wrapper table.dataTable.table-bordered thead th:after {
        top: 0.3em!important;
    }
    .badge-clear{
        position: absolute;
        padding: 3px 2px 3px 2px;
        margin-top: 3px;
        margin-left: 5px;
    }
    .badge-clear-all {
        position: absolute;
        margin-top: 8px;
        padding: 6px 5px 6px 5px;
        cursor: pointer;
        text-transform: none;
        font-size: 11px;
    }
    table.dataTable thead .sorting, 
    table.dataTable thead .sorting_asc, 
    table.dataTable thead .sorting_desc, 
    table.dataTable thead .sorting_asc_disabled, 
    table.dataTable thead .sorting_desc_disabled {
        position: absolute !important;

        &:before, &:after{
            top: 0;
        }
    }
    .custom-flex {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .fs-data-table-loading {
        background-color: #f5f6fa;
    }
    .loader {
        z-index: 1!important;
    }
</style>

<style lang="scss">
    .ks-content-nav > .ks-nav-body {
        width: 100%;
    }
</style>

<script>
import Pagination from '@components/pagination.vue';
import PopoverDialog from '@components/popover-dialog.vue';
import AdvancedSearchModal from '@views/pages/employee/_modals/advanced-search.vue';
import Select2 from '@components/select2.vue';

    export default {
        components: {
            Pagination,
            PopoverDialog,
            AdvancedSearchModal,
            Select2
        },
        data() {
            return {
                select2: {
                    options: [
                        {id: 10, text: 10},
                        {id: 15, text: 15},
                        {id: 50, text: 50},
                        {id: 100, text: 100}
                    ],
                    value: [
                        50
                    ]
                },
                form: {
                    key: '',
                    name: ''
                },
                open: false,
                sort: true,
                formatInput: '',
                advancedSearch: {
                    names: [],
                    projects: [],
                    skills: [],
                    locations: [],
                    clients: []
                },
                searchInput: ''
            }
        },
        props: {
            columns: {
                type: Array,
                required: true
            },
            sortKey: {
                type: String
            },
            sortOrder: {
                type: Object,
            },
            pagination: {
                type: Object
            },
            searchPlaceholder: {
                type: String,
                default: 'Enter Name'
            },
            showSearch: {
                type: Boolean,
                default: true
            },
            showFilter: {
                type: Boolean,
                default: true
            },
            showPagination: {
                type: Boolean,
                default: true
            },
            itemsFilter: {
                type: Number,
                default: 50
            },
            //Additional prop to only show the advanced search icon when it is set to true
            showAdvancedSearch:{
                type: Boolean,
                default: false
            },
            showFilters: {
                type: Boolean,
                default: false
            },
            columnFilters: {
                type: Object
            },
            showClearFilters: {
                type: Boolean,
                default: false
            },
            tableLoading: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            //This is to set the background color of the icon to green when there is an advanced search
            isAdvancedSearch(){
                if(this.advancedSearch.names.length || this.advancedSearch.projects.length || this.advancedSearch.skills.length || this.advancedSearch.locations.length || this.advancedSearch.clients.length){
                    return true;
                }
            },
            //This is to check if there is a filter
            isFilterPresent(){
                if(this.advancedSearch.names.length || this.advancedSearch.projects.length || this.advancedSearch.skills.length || this.advancedSearch.locations.length || this.advancedSearch.clients.length || this.searchInput != '' || this.columnFilters.id || this.columnFilters.name || this.columnFilters.project || this.columnFilters.location || this.columnFilters.status || this.columnFilters.clients){
                    return true;
                }
            }
        },
        methods: {
            doFilter(value) {
                this.sort = false;
                this.$emit('displayFilter', value);
            },
            doSort(value) {
                if(this.sort)
                    this.$emit('sort', value);
                this.sort = true;
            },
            doSearch() {
                // set default event to emit
                let emit = 'search';

                //check if advance search
                if(this.isAdvancedSearch) {
                    emit = 'advanceSearch'
                }

                //emit
                this.$emit(emit, this.term);
            },
            search() {
                this.clearAdvancedSearch();
                this.term = this.searchInput;
                if (this.timeOut != null) {
                    this.isTyping = false;
                    clearTimeout(this.timeOut);
                    this.timeOut = null;
                }
                if (!this.isTyping) {
                    this.timeOut = setTimeout(this.doSearch, 300);
                }
            },
            openModals(form) {
                this.form = form;
                this.open = true;
            },
            //This function is to format the data to be searched and save the selected values so that
            //when we click again on the advanced search icon, fields are already populated
            formatAdvancedSearch(names, projects, skills, locations, clients){
                this.advancedSearch.names = names;
                this.advancedSearch.projects = projects;
                this.advancedSearch.skills = skills;
                this.advancedSearch.locations = locations;
                this.advancedSearch.clients = clients;

                this.searchInput = '';

                this.formatInput = '<name>:';
                this.formatInput += names.map(name => name.text).join('$|$');

                this.formatInput += '<project>:';
                this.formatInput += projects.map(project => project.text).join('$|$');

                this.formatInput += '<skill>:';
                this.formatInput += skills.map(skill => skill.text).join('$|$');

                this.formatInput += '<location>:';
                this.formatInput += locations.map(location => location.text).join('$|$');

                this.formatInput += '<client>:';
                this.formatInput += clients.map(client => client.text).join('$|$');
                
                this.term = this.formatInput;
                this.doSearch();
            },
            clearAdvancedSearch(){
                this.advancedSearch.names = [];
                this.advancedSearch.projects = [];
                this.advancedSearch.skills = [];
                this.advancedSearch.locations = [];
                this.advancedSearch.clients = [];
            },

            clearAllFilters(){
                this.advancedSearch.names = [];
                this.advancedSearch.projects = [];
                this.advancedSearch.skills = [];
                this.advancedSearch.locations = [];
                this.advancedSearch.clients = [];
                this.searchInput = '';
                this.$emit('clearFilters');
            },
        }
    }
</script>
