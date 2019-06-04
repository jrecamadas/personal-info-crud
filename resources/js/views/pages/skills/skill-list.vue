<template>
	<div>
		<page-header :title="title"></page-header>
		<page-content :pageClass="pageClass">
			<div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-md-7">
								<Can I="add" a="skills">
									<div class="dataTable_buttons">
										<button type="button" @click="openSkillModal({key: 'create-update-skills', name: 'Add New Skill'})" tag="button" class="btn btn-primary">Add New Skills</button>
									</div>
								</Can>
                            </div>
                        </div>
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            <!-- BEGIN SKILLS DATA -->
                            <tbody v-if="skills.length">
                                <tr
                                    :class="index % 2 == 0 ? 'even' : 'odd'"
                                    style="cursor: pointer"
                                    v-for="(skill, index) in skills"
                                    :key="skill.id">

                                    <td>{{ skill.name }}</td>
                                    <td>{{ skill.description }}</td>

                                    <td align="center">
										<Can I="update" a="skills">
											<a href="#" class="action-button" title="Edit Employee" @click="showEditDialogoue({key: 'create-update-skills', name:'Update Skill', skill: skill.id})">
												<i class="la la-pencil"></i>
											</a>
										</Can>
										<Can I="delete" a="skills">
											<a href="#" class="action-button" title="Delete Employee" @click="showDeleteConfirmation(skill.id, skill.name)">
												<i class="la la-trash"></i>
											</a>
										</Can>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END SKILLS DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
            <!-- BEGIN WORK DETAIL DIALOG -->
	        <create-skills-modal v-if="form.key == 'create-update-skills' && open" :openModal="open" @success="reload" @close="open = false" :info="form"></create-skills-modal>
	        <!-- END WORK DETAIL DIALOG -->
		</page-content>
	</div>
</template>
<style scope>
	.action-button {
	    font-size: 20px;
	}
</style>

<script>

	// components
	import PageHeader from '@components/page-header.vue';
	import PageContent from '@components/page-content.vue';
	import DataTable from '@components/datatable.vue';

	import ModalDialog from '@components/modal-dialog.vue';
	import CreateSkillsModal from '@views/pages/skills/_modals/create-skills.vue';
	import Select2 from '@components/select2.vue';

	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin';
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex'

	export default {
		data() {
        	let sortOrder = {};
			let sortKey = 'name';
	        let columns = [
	            // { label: 'ID', key: 'id', sortKey: 'id', width: '10%', sortable: true },
	            { label: 'Name', key: 'name', sortKey: 'name', width: '45%', sortable: true },
	            { label: 'Description', key: 'description', sortKey: 'description', width: '45%', sortable: true },
	            { label: 'Action', key: 'action', sortKey: '', width: '10%', sortable: false },
	        ];

	        columns.forEach(function(col) {
	        	sortOrder[col.sortKey] = 'desc'
	        });

			return {
				title:'Skills Management',
				pageClass: 'ks-content-nav',
				sortKey:sortKey,
				sortOrder:sortOrder,
				limit: 10,
            	open: false,
				data: {
					columns:columns,
					rows: []
				},
				form: {
	                key: '',
	                name: '',
	                skill:{}
	            },
                applicants: []
			}
		},
		async created() {
			this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
			this.setPaginationLimit(9999);
			await this.getSkills({query: this.getParams()});
            await this.getEmployees({query: {take: 999999, include: 'skills,positions', applicants: 'all'}});
            this.applicants = this.employees;

            await this.getEmployees({query: {take: 999999, include: 'skills,positions'}});
            this.setPagination(this.meta.pagination);
		},
		computed: {
			...mapGetters({
				skills:'skills/data',
				meta:'skills/meta',
                employees: 'employees/data',
			})
		},
		methods : {
			...mapActions({
				getSkills: 'skills/getSkills',
				deleteSkill: 'skills/deleteSkill',
                getEmployees: 'employees/getEmployees',
			}),
			openSkillModal(formOptions) {
				this.form = formOptions
				this.open = true
			},
			async paginate(page) {
	            this.gotoPage(page);
	            await this.getSkills({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async search(term) {
	            this.setSearch(term);
	            await this.getSkills({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async sortList(key) {
	            this.sortKey = key;
	            this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';
	            this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
	            await this.getSkills({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
	        async updateList(limit) {
	            this.setPaginationLimit(limit);
	            await this.getSkills({query:this.getParams()});
	            this.setPagination(this.meta.pagination);
	        },
		    async reload() {
		    	await this.getSkills({query: this.getParams()});
		    	this.setPagination(this.meta.pagination);
		    	this.open = false;
		    },
		    delete(skillId) {
		    	return this.deleteSkill(skillId);
		    },
		    showEditDialogoue(options) {
		    	this.openSkillModal(options);
		    },
		    showDeleteConfirmation(skillId, skillName) {
			    let affected_employees = [];
                let affected_applicants = [];

                this.employees.filter(obj => obj.skills.data.length > 0).forEach((res) => {
                    if(res.skills.data.filter(obj2 => obj2.skill_id === parseInt(skillId)).length){
                        affected_employees.push(res);
                    }
                });
                this.applicants.filter(obj => obj.skills.data.length > 0).forEach((res) => {
                    if(res.skills.data.filter(obj2 => obj2.skill_id === parseInt(skillId)).length){
                        affected_applicants.push(res);
                    }
                });

                if(affected_employees.length || affected_applicants.length){
                    let flags = [];
                    if(affected_employees.length > 0){
                        flags.push(affected_employees.length > 1 ? affected_employees.length + ' employees' : 'an employee');
                    }
                    if(affected_applicants.length > 0){
                        flags.push(affected_applicants.length > 1 ? affected_applicants.length + ' applicants' : 'an applicant');
                    }
                    const title = 'The skill cannot be removed while it is being associated with ' + flags.join(' and ') + '.';
                    const msg = `${skillId} ${skillName}`;
                    this.confirmDialog(title, msg, 'Close', '', 'sm');

                } else {
                    const title = 'Are you sure you want to delete this record?';
                    const msg = `${skillId} ${skillName}`;
                    this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                        .then(({ok}) => {
                            if (ok) {
								this.delete(skillId).then(() => this.reload());	
								this.notifyDialog('error', 'Successfully deleted!');
							}
                        });
                }
		    }
		},
		components: {
			Select2,
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
			CreateSkillsModal,

		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin
		]
	}
</script>
