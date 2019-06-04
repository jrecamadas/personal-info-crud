<template>
	<div>
		<page-header :title="title"></page-header>
		<page-content :pageClass="pageClass">
			<div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <SmartTeamBuilderCarouselResources
							:rows="developersData" 
							:headerTitle="'Developer'"
							:loading="loading[0]"
							@action="openResourceModal({key: 'select-developer-resources', name: 'Development'})"
							@close="closeModal(0)"
						></SmartTeamBuilderCarouselResources>
                        <SmartTeamBuilderCarouselResources
							:rows="projectManagersData" 
							:headerTitle="'Project Manager'"
							:loading="loading[1]"
							@action="openResourceModal({key: 'select-pm-resources', name: 'Project Manager'})"
							@close="closeModal(1)"
						></SmartTeamBuilderCarouselResources>
                        <SmartTeamBuilderCarouselResources
							:rows="testersData" 
							:headerTitle="'Testing'"
							:loading="loading[2]"
							@action="openResourceModal({key: 'select-testing-resources', name: 'Testing'})"
							@close="closeModal(2)"
						></SmartTeamBuilderCarouselResources>
                        <SmartTeamBuilderCarouselResources
							:rows="contentsData" 
							:headerTitle="'Content'"
							:loading="loading[3]"
							@action="openResourceModal({key: 'select-content-resources', name: 'Content'})"
							@close="closeModal(3)"
						></SmartTeamBuilderCarouselResources>
                        <SmartTeamBuilderCarouselResources
							:rows="creativeServicesData" 
							:headerTitle="'Creative Services'"
							:loading="loading[4]"
							@action="openResourceModal({key: 'select-creative-resources', name: 'Creative Services'})"
							@close="closeModal(4)"
						></SmartTeamBuilderCarouselResources>
                    </div>
                </div>
            </div>
            <!-- BEGIN MODALS -->
	        <select-developer-resources-modal v-if="form.key == 'select-developer-resources' && open" :openModal="open" @close="closeModal(0)" :info="form"></select-developer-resources-modal>
	        <select-pm-resources-modal v-if="form.key == 'select-pm-resources' && open" :openModal="open" @close="closeModal(1)" :info="form"></select-pm-resources-modal>
	        <select-testing-resources-modal v-if="form.key == 'select-testing-resources' && open" :openModal="open" @close="closeModal(2)" :info="form"></select-testing-resources-modal>
	        <select-content-resources-modal v-if="form.key == 'select-content-resources' && open" :openModal="open" @close="closeModal(3)" :info="form"></select-content-resources-modal>
	        <select-creative-resources-modal v-if="form.key == 'select-creative-resources' && open" :openModal="open" @close="closeModal(4)" :info="form"></select-creative-resources-modal>
	        <!-- END MODALS -->
		</page-content>
	</div>
</template>
<style scope>
	.action-button {
	    font-size: 20px;
	}
</style>

<style lang="scss">
//Animation - Keyframes
	@mixin animation ($animationName, $animationTime) {
		-webkit-animation: #{$animationName} #{$animationTime};
		-moz-animation: #{$animationName} #{$animationTime};
		animation: #{$animationName} #{$animationTime};
	}

	@mixin keyframes ($animationName) {
		@-webkit-keyframes #{$animationName} {
			@content;
		}

		@-moz-keyframes #{$animationName} {
			@content;
		}

		@keyframes #{$animationName} {
			@content;
		}
	}
	
	@include keyframes(animateShow) {
		0% {
			visibility: hidden;
			opacity: 0;
			transform: translateY(150px);
			filter: blur(10px);
		}
		100% {
			visibility: visible;
			opacity: 1;
			transform: translateY(0);
			filter: blur(0);
		}
	}

	@include keyframes(animateHide) {
		0% {
			visibility: visible;
			opacity: 1;
			transform: translateX(0);
			filter: blur(10px);
		}
		95% {
			visibility: hidden;
			opacity: 0;
			transform: translateX(25%);
			filter: blur(0);
		}
		100% {
			visibility: hidden;
			opacity: 0;
			transform: translateY(150px);
			filter: blur(0);
		}
	}

	
	@include keyframes(animateButtonShow) {
		0% {
			visibility: hidden;
			opacity: 0;
			transform: translateX(100%);
			filter: blur(10px);
		}
		100% {
			visibility: visible;
			opacity: 1;
			transform: translateX(0);
			filter: blur(0);
		}
	}
	@include keyframes(animateButtonHide) {
		0% {
			visibility: visible;
			opacity: 1;
			transform: translateX(0);
			filter: blur(10px);
		}
		95% {
			visibility: hidden;
			opacity: 0;
			transform: translateX(100%);
			filter: blur(0);
		}
		100% {
			visibility: hidden;
			opacity: 0;
			transform: translateX(-100%);
			filter: blur(0);
		}
	}
	.smart-team-builder-modal {
		.done {
			&.show {
				@include animation(animateButtonShow, 0.5s);
				animation-fill-mode: forwards;
			}
		}
		button[type="button"].btn.btn-danger {
			@include animation(animateButtonShow, 0.5s);
			animation-fill-mode: forwards;

			&[disabled]{
				@include animation(animateButtonHide, 0.5s);
				animation-fill-mode: forwards;
			}
		}
	}
	//Show/hide questions
	.question-wrapper {
		z-index: 1;
		> div {
			> .row {
				position: absolute;
				top: 0;
				width: 100%;
				opacity: 0;
				visibility: hidden;
				
      			@include animation(animateHide, 0.5s);
				animation-fill-mode: forwards;
			}
			
			.show {
      			@include animation(animateShow, 0.5s);
				animation-fill-mode: forwards;
			}
		}
	}
</style>
<script>

	// components
	import PageHeader from '@components/page-header.vue'	
	import PageContent from '@components/page-content.vue'
	import DataTable from '@components/datatable.vue'
	
	import ModalDialog from '@components/modal-dialog.vue'
	import Select2 from '@components/select2.vue';
	import EmployeeForm from '@views/pages/employee/_forms/employee.vue';
	import SelectDeveloperResourcesModal from '@views/pages/smart-team-builder/_modals/select-developer-resources.vue';
	import SelectPmResourcesModal from '@views/pages/smart-team-builder/_modals/select-pm-resources.vue';
	import SelectTestingResourcesModal from '@views/pages/smart-team-builder/_modals/select-testing-resources.vue';
	import SelectContentResourcesModal from '@views/pages/smart-team-builder/_modals/select-content-resources.vue';
	import SelectCreativeResourcesModal from '@views/pages/smart-team-builder/_modals/select-creative-resources.vue';
    import SmartTeamBuilderCarouselResources from '@components/smart-team-builder-carousel-resources.vue';
	// mixins
	import DataTableMixin from '@common/mixin/DataTableMixin'
	import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
	import AlertMixin from '@common/mixin/AlertMixin';

	import { mapActions, mapGetters } from 'vuex'

	export default {
		data() {
			return {
				title:'Smart Team Builder',
				pageClass: 'ks-content-nav',
				open: false,
				loading: [false,false,false,false,false],
				ll: false,
	            form: {
	                key: '',
	                name: ''
	            },
	            modal: {
	                width: '500px',
	                height: '400px'
				},
				projectManagerPosition: [6],
				testersPosition: [40,43],
				contentsPosition: [33,34,35],
				creativePosition: [30,31,49,55],
				developersData: [],
				projectManagersData: [],
				testersData: [],
				creativeServicesData: [],
				contentsData: [],
				allData: []
			}
		},
		async created() {
			this.loading = this.loading.map(x => true);
			await this.getData();
			this.loading = this.loading.map(x => false);
		},
		computed: {
			...mapGetters({
				clientPreferredTeam: 'smartTeamBuilder/data',
			})
		},
		methods : {
			...mapActions({
				getSmartTeamBuilders: 'smartTeamBuilder/getSmartTeamBuilders',
			}),

			async getData(){
				await this.getSmartTeamBuilders({
					query: { client_id: this.$route.params.id , take: 99999}
				});
				this.allData = this.clientPreferredTeam;
				this.projectManagersData = this.getCategorizeEmp(this.projectManagerPosition);
				this.testersData = this.getCategorizeEmp(this.testersPosition);
				this.contentsData = this.getCategorizeEmp(this.contentsPosition);
				this.creativeServicesData = this.getCategorizeEmp(this.creativePosition);
				this.developersData = this.allData;
			},

			getCategorizeEmp(positions){
				let empList = [];
				for(let i = 0; i < this.allData.length; ){
					if(positions.includes(this.allData[i].job_position.id)){
						empList.push(this.allData[i]);
						this.allData.splice(i,1);
					}else{
						i++;
					}
				}
				return empList;
			},
			
			openResourceModal(formOptions) {
				this.form = formOptions
				this.open = true
			},

			async closeModal(index){
				this.open = false;
				Vue.set(this.loading,index,true);
				await this.getData();
				Vue.set(this.loading,index,false);
			}
		},
		components: {
			Select2,
			DataTable,
			PageHeader,
			PageContent,
			ModalDialog,
			SmartTeamBuilderCarouselResources,
			SelectDeveloperResourcesModal,
			SelectPmResourcesModal,
			SelectTestingResourcesModal,
			SelectContentResourcesModal,
			SelectCreativeResourcesModal
		},
		mixins: [
			ModalDialogMixin,
			DataTableMixin,
			AlertMixin
		]
	}
</script>