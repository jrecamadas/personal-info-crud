<template>
	<modal-dialog v-show="openModal" :options="option" :title="info.name" @close="closeModal" :closeIsDisabled="done" class="smart-team-builder-modal">
		<template slot="button">
            <save-button :options="button" @action="$emit('close')" v-if="done" class="done" :class="{'show': done}">Done</save-button>
        </template>
        <template slot="body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row question-wrapper">
                        <div class="col-sm-12" :style="{ height: activeHeight + 'px' }">
							
							<!-- SLIDE 1 -->
							<div class="row" :class="{ 'show': navigationCounter == 1 }">
								<div class="col-sm-12">
									<div class="checkbox-wrapper">
										<input type="checkbox" class="checkbox" id="manual" name="manual" value="manual" v-model="question1" @change="checkIfChecked(question1)" />
										<label for="manual"><span>Manual</span></label>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="checkbox-wrapper">
										<input type="checkbox" class="checkbox" id="automation" name="automation" value="automation" v-model="question1" @change="checkIfChecked(question1)"/>
										<label for="automation"><span>Automation</span></label>
									</div>
								</div>
							</div>

							<!-- SLIDE 2 -->
							<div class="row" :class="{ 'show': navigationCounter == 2 }">
								<div class="col-sm-12">
									<div class="checkbox-wrapper">
										<input type="checkbox" class="checkbox" id="website" name="website" value="website" v-model="question2" @change="checkIfChecked(question2)" />
										<label for="website"><span>Website</span></label>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="checkbox-wrapper">
										<input type="checkbox" class="checkbox" id="mobile" name="mobile" value="mobile" v-model="question2" @change="checkIfChecked(question2)"/>
										<label for="mobile"><span>Mobile</span></label>
									</div>
								</div>
							</div>

							<!-- SLIDE 3 -->
							<div class="row" :class="{ 'show': navigationCounter == 3 }">
								<div class="col-sm-12">
									<div v-show="loading" class="filtered-resources loader-container">
                                    	<div class="loader"></div>
									</div>
									<div v-show="!loading" class="filtered-resources">
                            			<div class="slider" v-for="(employee, index) in employees" :key="index">
											<div class="slide-wrapper">
												<div class="fs-user-photo-container">
													<div class="fs-user-photo align-self-center" :style="'background-image: url(\'' + photo(employee) + '\')'"></div>
												</div>
												<div class="emp-info">
													<div class="emp-name">
														Name: <br/>
														<div class="three-ellipsis">
															<a :href="employee.profile_url" target="_blank">
																{{ employee.last_name }}, {{employee.first_name}} {{employee.middle_name}}
															</a>
														</div>
													</div>
													<div>
														Position: <br/>
														<div class="three-ellipsis">
															<span class="testing-position" data-trigger="hover" data-toggle="popover" :data-popover-content="'#popover-testing-' + index">
																{{ position(employee.positions ? employee.positions.data : "") }}
															</span>
														</div>
													</div>
													<div>
														<span :class="setEmployeeClass(employee.id)" class="pcl">
															{{ employee.profile_url }}
														</span>
														<a
															href="javascript:;"
															class="action-button"
															title="Copy Employee Profile Link"
															@click.prevent="copyToClipboard(setEmployeeClass(employee.id))">
															<i class="la la-copy copy-url-to-clipboard"></i>
														</a>
														<a
															:href="getDownloadLink(employee.profile_url)"
															target="_blank"
															class="action-button"
															title="Download PDF">
															<i class="la la-file-pdf-o"></i>
														</a>
													</div>
													<popover-dialog :popoverId="'popover-testing-' + index">
														<template slot="header">Skills</template>
														<template slot="body">
															<div class="popover-skill-block">
																<div class="resource-details-content" v-if="employee.skills && employee.skills.data.length">
																	<div v-for="(skill,index) in employee.skills.data" :key="skill.id">
																		<div v-if="index < 5">
																			<div class="ks-controls resource-skill-placeholder">
																				<span class="resource-skill">
																					{{ skill.name}}
																				</span>
																				<span class="resource-level" style="float: right;">
																					{{ skill.proficiency }}/10
																				</span>
																			</div>
																			<div class="ks-info">
																				<div class="progress ks-progress ks-progress-xs">
																					<div class="progress-bar bg-info"
																						role="progressbar"
																						:style="'width: ' + (skill.proficiency * 10) + '%'"
																						v-bind:aria-valuenow="skill.proficiency"
																						aria-valuemin="0"
																						aria-valuemax="100"></div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div v-else class="popover-no-skill">
																	No Skills to display
																</div>
															</div>
														</template>
													</popover-dialog>
												</div>
												<div class="resource-button">
													<div class="col-sm-12">
														<button v-if="checkPreferred(employee.preferredTeams,employee.id)" @click="deleteEmp(getClientPreferredId(employee.preferredTeams), index)" type="button" tag="button" class="btn btn-primary selected" :disabled="employeesLoading[index]">
															<span class="ks-text">Selected</span>
															<span v-show="!employeesLoading[index]" class="la la-star ks-icon"></span>
															<i v-show="employeesLoading[index]" class="fa fa-spinner fa-spin selected-spinner"></i>
														</button>
														<button v-else @click="saveEmp(employee, index)" type="button" tag="button" class="btn choose" :disabled="employeesLoading[index]">
															<span class="ks-text">Choose</span>
															<i v-show="employeesLoading[index]" class="fa fa-spinner fa-spin choose-spinner"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
										<div v-if="employees.length == 0" class="no-resource">
											No Resource(s)
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
							<h5 class="navigation-text">
								<span class="prev" v-if="prev" @click="prevSlide()"><i class="la la-arrow-left"></i> Previous</span>
								<span class="next" v-if="next" :class="!isValid ? 'disabled':''" @click="nextSlide()">Next <i class="la la-arrow-right"></i></span>
							</h5>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal-dialog>
</template>

<style lang="scss" scoped>
	.checkbox-wrapper {
		display: flex;
		align-items: center;
		position: relative;
		margin-bottom: 15px;

		//Untick checkbox
		input.checkbox {
			z-index: 0;

			&:before {
				content: "";
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				width: 100%;
				height: 100%;
				background: white;
				border: 2px solid black;
				z-index: 1;
				transition: background 0.3s ease-in;
			}

			+ label {
				margin: 0;
				padding-left: 20px;
				font-size: 20px;
				color: black;
				padding: 15px 45px;
				width: 100%;
				height: 100%;
				z-index: 1;
				font-size: 22px;
				font-weight: 500;
				font-family: "Montserrat", sans-serif;
				cursor: pointer;

				&.small {
					padding: 10px;
					padding-left: 25px;
					font-size: 12px;

					&:before {
						width: 12px;
						height: 12px;
					}
				}

				span {
					pointer-events: none;
					user-select: none;
				}

				&:before {
					content: "";
					background-image: url(/assets/img/smart-team-builder/checkbox-empty.png);
					background-size: contain;
					position: absolute;
					top: 50%;
					left: 10px;
					-webkit-transform: translate(50%, -50%);
					transform: translate(50%, -50%);
					width: 20px;
					height: 20px;
				}
			}
		}

		//Tick checkbox
		input.checkbox:checked{
			&:before {
				background: #007840;
				border: 2px solid #007840;
			}
			+ label {
				color: white;

				span {
					pointer-events: none;
					user-select: none;
				}

				&:before {
					background-image: url(/assets/img/smart-team-builder/checkbox-checked.png);
				}
			}
		}
	}
	.navigation-text {
		// margin-top: 50px !important;
		cursor: pointer;

		span {
			font-size: 16px;
		}
		span.prev {
			float: left;
		}
		span.next {
			float: right;
		}
	}

	.disabled {
		cursor: default;
		pointer-events: none;
		color: gray;
	}

	.search-wrapper {
		display: flex;
    	width: 210px;

		.search-icon {
			position: relative;
			font-size: 20px;
			right: 30px;
			padding: 10px 0px;
			color: #888;
			cursor: text;
		}
	}

	.filtered-resources {
		display: flex;
		flex-wrap: wrap;
		flex-direction: row;
		justify-content: space-between;
		overflow-x: hidden;
		overflow-y: auto;
		height: 400px;
		margin-top: 15px;

		&:after {
			content: "";
			flex: auto;
		}
		
		.slider {
			width: 25%;

			.slide-wrapper {
				margin: 10px 15px 30px;
				box-shadow: 3px 5px 15px rgba(0,0,0,0.16);

				.fs-user-photo-container {
					background-color: #DEDBDC;
					padding: 10px 0;
				}

				.testing-position {
					font-weight: bold;
				}

				.resource-button {
					>div{
						padding: 0;

						button {
							width: 100%;
							border-radius: 0;

							&.selected {
								background: #007840;
								border-color: #007840;

								.ks-text {
									padding-right: 25px;
								}

								.ks-icon {
									margin-right: 25px;
									color: yellow;
								}
							}

							&.choose {
								background: black;
								border-color: black;
								color: white;

								.ks-text {
									padding: 0;
								}
							}
						}
					}
				}
			}
		}
	}

	.emp-info {
        padding: 8px 15px;
        text-align: left;
    }
    .emp-name {
        font-weight: bold;
    }
    .fs-user-photo {
		height: 80px !important;
    	width: 80px;
        box-sizing: border-box;
        background-color: #c1c1c1;
        height: 100%;
        background-size: cover;
        background-position: center;
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border: 2px solid #fff;
        margin: 0 auto;
    }
    h4 {
        margin: 10px 10px 15px 0px;
    }
    .no-resource {
        text-align: center;
        margin-bottom: 20px;
    }
    .popover-skill-block {
        padding: 5px 10px;
        width: 190px;
        font-family: Montserrat, sans-serif;
        color: #444;
        font-size: 8pt;
    }
    .popover-heading {
        font-family: Montserrat, sans-serif;
	}
    .popover-no-skill {
        font-size: 12px;
        text-align: center;
    }
    span.pcl {
        position: absolute;
        left: -1000px;
        top: -1000px;
    }
	.three-ellipsis {
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical; 
		overflow: hidden; 
		height: 40px;
	}
	
	.loader-container {
		display: block;
		top: 30%;
		position: relative;
	}

	.selected-spinner {
		position: absolute;
		font-size: 18px;
		margin-left: -20px;
	}

	.choose-spinner {
		position: absolute;
		font-size: 18px;
		margin-left: 5px;
	}

	.no-resource {
		left: 40%;
		position: relative;
		font-size: 20px;
	}
</style>

<style>
	.modal-body {
		overflow: hidden !important;
	}
</style>

<script>
	import _ from 'lodash';

	//Components
	import GenerateButton from '@components/form/button.vue';
	import SaveButton from '@components/form/button.vue';
	import ModalDialog from '@components/modal-dialog.vue';
	import PopoverDialog from '@components/popover-dialog.vue';

	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import StringHelperMixin from '@common/mixin/StringHelperMixin';
	import EmployeeMixin from "@common/mixin/EmployeeMixin";

	import { mapActions, mapGetters } from 'vuex';
	import $ from 'jquery';

	export default {
		props: {
			info: { type: Object, required: true}
		},
		data() {
			return {
				valid:false,
				option: { width: '500px' },
				activeHeight: 170,
				button: { class: 'btn btn-primary',type: 'button' },
				done: false,
				loading: false,
				prev: false,
				next: true,
				isValid: false,
				question1: [],
				question2: [],
				navigationCounter: 1,
				employeesLoading: [],
				include: ['skills', 'photo', 'positions'],
			}
		},
		computed: {
			...mapGetters({
				employees: 'employees/data',
			}),
		},
		async created() {
			
		},
		methods: {
			...mapActions({
				getEmployees: 'employees/getEmployees',
				saveClientPreferredTeam: 'smartTeamBuilder/saveSmartTeamBuilder',
				deleteClientPreferredTeam: 'smartTeamBuilder/deleteSmartTeamBuilder'
			}),
			
			getDownloadLink(profileUniqueStr) {
				return profileUniqueStr ? profileUniqueStr + '/pdf' : '';
			},
			setEmployeeClass(employeeId) {
				return 'profileCardURL' + employeeId;
			},
			checkIfChecked(model) {
				if(model.length > 0){
					this.isValid = true;
				}else{
					this.isValid = false;
				}
			},
			nextSlide(){
				this.navigationCounter++;
				this.conditionalNavigation();
			},
			prevSlide(){
				this.navigationCounter--;
				this.conditionalNavigation();
			},
			async conditionalNavigation() {
				if(this.navigationCounter == 3){
					this.next = false;
					this.prev = true;
					this.done = true;
					this.option.width = '800px';
					this.activeHeight = 450;
					this.loading = true;
					await this.getData();
					this.employeesLoading = Array(this.employees.length).fill(false);
					this.initializePopover();
					this.loading = false;
				} else if(this.navigationCounter == 2) {
					this.checkIfChecked(this.question2);
					this.next = true;
					this.prev = true;
					this.done = false;
					this.activeHeight = 170;
					this.option.width = '500px';
				} else {
					this.checkIfChecked(this.question1);
					this.next = true;
					this.prev = false;
					this.done = false;
					this.activeHeight = 170;
					this.option.width = '500px';
				}
			},

			async getData(){
				await this.getEmployees({
					query: _.merge(this.getParams(),
					{ include: this.include.join(', ') },
					{ positions: this.positionsToRetrieve() },
					{ take: 999999 })
				});
			},

			positionsToRetrieve(){
				let jobId = [];
				if(this.question1.length == 2){
					jobId = ['43','40'];
				}else{
					if(this.question1 == 'manual'){
						jobId = ['43'];
					}else{
						jobId = ['40'];
					}
				}
				return jobId.join(',');
			},

			initializePopover(){
				$('.testing-position').popover({
					html : true,
					sanitize: false,
					content: function() {
						var content = $(this).attr('data-popover-content');
						return $(content).children('.popover-body').html();
					},
					title: function() {
						var title = $(this).attr('data-popover-content');
						return $(title).children('.popover-heading').html();
					}
				});
			},
			checkPreferred(clients,id){
				let client_id = this.$route.params.id;
				if(clients.filter(function(e) { return e.employee_id == id && e.client_id == client_id && e.deleted_at == null}).length > 0){
					return true;
				}
				return false;
			},

			async saveEmp(employee, index){
				Vue.set(this.employeesLoading,index,true);
				const data = {
					id: this.getClientPreferredId(employee.preferredTeams),
                    client_id: this.$route.params.id,
                    client_project_id: null,
                    employee_id: employee.id,
                    job_position_id: this.getPositionId(employee.positions.data)
                }
				this.saveClientPreferredTeam(data).then(() => {
					this.getData().then(() => {
						Vue.set(this.employeesLoading,index,false);
					});
				}).catch((e) => {
				});
			},

			getPositionId(positions){
				let id = positions.filter(function(e) { return e.position_id == '43' || e.position_id == '40'})[0].position_id;
				return id;
			},

			getClientPreferredId(clients){
				let client_id = this.$route.params.id;
				let row = clients.filter(function(e) { return e.client_id == client_id});
				return row.length ? row[0].id : '';
			},

			async deleteEmp(id, index){
				Vue.set(this.employeesLoading,index,true);
				this.deleteClientPreferredTeam(id).then(() => {
					this.getData().then(() => {
						Vue.set(this.employeesLoading,index,false);
					});
				}).catch((e) => {
				});
			}
		},
		destroyed() {
			$('.testing-position').popover('dispose');
		},
		components: {
	        GenerateButton,
	        SaveButton,
			ModalDialog,
			PopoverDialog
	    },
	    mixins: [
	    	DataTableMixin,
	        ModalDialogMixin,
			StringHelperMixin,
			EmployeeMixin
	    ]
	}
</script>
