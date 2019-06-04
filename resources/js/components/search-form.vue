<template>
    <!-- BEGIN SEARCH FORM -->
    <form class="ks-search-form">
        <!-- <a class="ks-search-open" href="#">
            <span class="la la-search"></span>
        </a> -->
        <div class="ks-wrapper">
            <div class="input-icon icon-right icon icon-lg icon-color-primary">
                <vue-tags-input
                    v-model="employee"
                    :autocomplete-items="filteredResources"
                    :add-only-from-autocomplete="true"
                    :autocomplete-always-open="displayAutoComplete"
                    :max-tags="1"
                    placeholder="Search Employee..."
                    id="input-group-icon-text"
                    @tags-changed="doSearch"
                    @before-adding-tag="checkValue"
                    @input="updateValue"
                >
                    <span
                    slot="tagCenter"
                    slot-scope="props"
                    @click="updateSearch(props)"
                    >
                        {{ props.tag.text }}
                    </span>
                    <div
                        slot="autocompleteItem"
                        slot-scope="props"
                        @click="selectValue(props)"
                    >
                    <i>
                    {{ props.item.text }}
                    </i>
  </div>
                </vue-tags-input>
                <!-- <input id="input-group-icon-text" type="text" class="form-control" @input="search($event.target.value)" placeholder="Search Employee..." /> -->
                <span class="icon-addon">
                    <span class="la la-search ks-icon"></span>
                </span>
            </div>
            <!-- <a class="ks-search-close" href="#">
                <span class="la la-close"></span>
            </a> -->
        </div>
    </form>
    <!-- END SEARCH FORM -->
</template>
<style>
    #input-group-icon-text.vue-tags-input {
        background: none;
    }
    #input-group-icon-text .new-tag-input-wrapper {
        background: rgba(0, 0, 0, 0.2);
        color: rgba(255, 255, 255, 0.6);
        padding: 0;
        margin: 0;
    }
    .ks-navbar > .ks-wrapper > .nav > .ks-navbar-menu > .ks-search-form .icon-addon > .ks-icon {
        color: #333;
    }
    #input-group-icon-text .new-tag-input-wrapper input{
        border: 1px solid transparent;
        color: rgba(255, 255, 255, 0.6);
        font-family: "Montserrat", sans-serif;
        z-index: 0;
        height: 38px;
        border-radius: 2px;
        border: solid 1px #dedede;
        font-size: 12px;
        color: #333;
        padding: 10px 15px;
        width: 200px;
    }
    #input-group-icon-text .input {
        padding: 0;
        border: none;
    }
    #input-group-icon-text .tag-center {
        width: 162px;
    }
    #input-group-icon-text .tag-center span {
        display: block;
        padding-left: 8px;
        font-size: 12px;
    }
    #input-group-icon-text .icon-close {
        display: none;
    }
    #input-group-icon-text .tag.valid {
        position: absolute;
        height: 35px;
        width: 161px;
        z-index: 100;
        background-color: #fff;
        color:#000;
    }
    .ks-search-form .ks-wrapper {
        padding-top: 0.9em;
        padding-right: 1em;
    }
</style>
<style scoped>
    #input-group-icon-text .autocomplete {
        max-height: 250px;
        overflow-y: auto;
    }
</style>
<script type="text/javascript">
    import VueTagsInput from '@johmun/vue-tags-input';
    import { mapActions, mapGetters } from 'vuex';
    export default {
        data() {
            return {
                isTyping: false,
                timeOut: null,
                term: "",
                employee: '',
                hasValue: false,
                data: {
                    resources: []
                },
                displayAutoComplete: false
            };
        },
        async created() {
            await this.getEmployees({query: {orderBy: 'last_name|asc', take: 100000}});
        },
        computed : {
            ...mapGetters({
                loggedInUser: 'auth/data',
                employees: 'employees/formatted',
            }),
            filteredResources: function() {
                return this.employees.filter(s => new RegExp(this.employee, 'i').test(s.text));
            }
        },
        methods : {
            ...mapActions({
                getEmployees: 'employees/getEmployeeNames',
            }),
            doSearch(value) {
                if(value.length && this.hasValue)
                    this.$router.push({name: 'employee', params: {id: value[0].employee_id}});
            },
            updateSearch(props) {
                props.performDelete(props.item);
                this.hasValue = false;
                //This is just use to force focus to search bar after clicking searched text
                $('input#input-group-icon-text').focus();
            },
            selectValue(props) {
                this.hasValue = true;
                props.performAdd(props.item);
            },
            updateValue(value) {
                if(value) {
                    this.displayAutoComplete = true;
                }
                else {
                    this.displayAutoComplete = false;
                }
                this.hasValue = true;
            },
            checkValue(value) {
                if(this.hasValue)
                    value.addTag();
            }
        },
        components: {
            VueTagsInput
        },
    }
</script>
