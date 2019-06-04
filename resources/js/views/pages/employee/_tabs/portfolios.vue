<template>
    <div class="fs-accordion" :class="accordionClasses">
        <div class="fs-field">
            <div class="card panel panel-default ks-information ks-light">
                <div class="card-header" @click.stop="toggleAccordion">
                    <h4 class="ks-text" id="portfolio">Portfolio</h4>
                    <Can I="add" a="employee_portfolio">
                        <a href="#portfolio" @click.stop="open = true" class="btn ks-light ks-no-text">
                            <span class="la la-plus-square ks-icon"></span>
                        </a>
                    </Can>
                </div>
                <div class="card-block fs-accordion-content" v-if="employee.portfolios">
                    <div v-for="(portfolio, index) in employee.portfolios.data" class="fs-card">
                        <div class="fs-card-block">
                            <div class="image">
                                <i class="la la-folder-o"></i>
                            </div>
                            <div class="fs-card-info portfolio-info">
                                <h5 class="card-title">{{ portfolio.name }}</h5>
                                <p v-if="portfolio.experience"> Company: {{portfolio.experience.company_name}} </p>
                                <a v-if="portfolio.url" :href="portfolio.url">{{portfolio.url}}</a>
                                <p v-if="portfolio.start_date && portfolio.end_date"> {{ formatDate(portfolio.start_date, 'MMM DD, YYYY') }} - {{ formatDate(portfolio.end_date, 'MMM DD, YYYY') }} </p>
                                <p class="card-text pre-wrap">{{ portfolio.description }}</p>
                            </div>
                        </div>
                        <div class="">
                            <Can I="update" a="employee_portfolio">
                                <a href="#portfolio" class="fs-button" @click="edit(portfolio.id)">
                                    <span class="la la-edit ks-icon"></span>
                                </a>
                            </Can>
                            <Can I="delete" a="employee_portfolio">
                                <a href="#portfolio" class="fs-button" @click="remove(portfolio.id)">
                                    <span class="la la-trash-o ks-icon"></span>
                                </a>
                            </Can>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <portfolio-modal :id="id" :openModal="open" v-if="open" @success="$emit('success')" @close="modalClose"></portfolio-modal>
    </div>
</template>
<style scoped>
.portfolio-info p {
    padding:0;
    margin:0;
}

.fs-card-block
{
    width:90%;
}

.fs-card-info
{
    width:100%;
}
</style>

<script>
import PortfolioModal from "@views/pages/employee/_modals/portfolios.vue";
import DateMixin from '@common/mixin/DateMixin';
import AlertMixin from '@common/mixin/AlertMixin';
import AccordionMixin from '@common/mixin/AccordionMixin';
import { mapGetters } from 'vuex';
import { EmployeePortfolio } from '@common/model/EmployeePortfolio';

export default {
    computed: {
        ...mapGetters({
            employee: 'employees/single'
        })
    },
    data() {
        return {
            open: false,
            id: null
        }
    },
    created() {

    },
    methods: {
        remove(id) {
            this.confirmDialog("Removing Portfolio...", "Are you sure you want to delete?", "Yes", "Cancel", "sm").then((res)=>{
                if(res.ok){
                    let employeePortfolio = new EmployeePortfolio({id: id});
                    employeePortfolio.delete();
                    this.$emit('success');
                    this.notifyDialog('error', 'Successfully deleted!');
                }
            });
        },
        edit(id) {
            this.id = id;
            this.open = true;
        },
        modalClose() {
            this.id = null;
            this.open = false;
            this.$emit('success');
        }
    },
    components: {
        PortfolioModal
    },
    mixins: [
        AlertMixin,
        DateMixin,
        AccordionMixin
    ]
}
</script>
