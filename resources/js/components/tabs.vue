<template>
    <div class="fs-holder">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a 
                    v-for="(tab, index) in tabs"
                    class="nav-item nav-link"
                    data-toggle="tab"
                    role="tab"
                    aria-controls="nav-home"
                    aria-selected="true"
                    @click.prevent="updatePagination(tab)"
                    :id="setTabID(tab)"
                    :href="'#' + setTabContent(tab)"
                    :class="{ 'active' : index == 0 }"
                    :key="index">
                    {{ tab }}
                </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div
                v-for="(tab, i) in tabs"
                class="tab-pane fade show"
                role="tabpanel"
                :id="setTabContent(tab)"
                :aria-labelledby="setTabID(tab)"
                :class="{ 'active' : i == 0 }"
                :key="i">
                <slot :name="tab"></slot>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    .fs-holder {
        width: 100%;
    }
</style>

<script>
export default {
    props: {
        tabs: {
            type: Array,
            default: ['Content 1', 'Content 2']
        }
    },
    data () {
        return {
            randomID: 'tab'+Math.floor(Math.random() * 20)
        }
    },
    methods: {
        updatePagination(tab) {
            this.$emit('updatePagination', tab);
        },
        setTabID(label) {
            return "nav-" + label.toLowerCase() + "-tab"
        },
        setTabContent(label) {
            return "nav-" + label.toLowerCase();
        }
    }
}
</script>

