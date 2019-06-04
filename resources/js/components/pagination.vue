<!--fullscale-employee\resources\js\components\pagination.vue-->
<template>
    <div class="row">
        <!-- BEGIN PAGINATION INFO -->
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" role="status" aria-live="polite">Showing {{ pageTo }}</div>
        <!-- END PAGINATION INFO -->
        </div>
        <!-- BEGIN PAGINATION LINKS -->
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination">
                    <!-- BEGIN PREVIOUS BUTTON -->
                    <li class="paginate_button page-item previous"
                        :class="!pagination.prevPageUrl ? 'disabled' : ''">
                        <a aria-controls="ks-datatable" tabindex="0" class="page-link" @click="$emit('prev')">Previous</a>
                    </li>
                    <!-- BEGIN PAGINATION LINKS -->
                    <!-- END PAGINATION LINKS -->
                    <li v-for="(link, index) in pagination.pages" class="pagination_button page-item"
                                                                  :class="pagination.currentPage == (index + 1) ? 'active' : ''">
                        <a aria-controls="ks-datatable" class="page-link" @click="$emit('page', index + 1)">{{ index + 1 }}</a>
                    </li>
                    <!-- BEGIN NEXT BUTTON -->
                    <!-- END PREVIOUS BUTTON -->
                    <li class="paginate_button page-item next"
                        :class="!pagination.nextPageUrl ? 'disabled' : ''">
                        <a aria-controls="ks-datatable" tabindex="0" class="page-link" @click="$emit('next')">Next</a>
                    </li>
                    <!-- END NEXT BUTTON -->
                </ul>
            </div>
        </div>
        <!-- END PAGINATION LINKS -->
    </div>
</template>

<script>
export default {
    computed:{
      pageTo: function() {
        let pageText = "";
        let entryText = "";
        let secondToText = "";
          entryText = this.pagination.total == '1' ? " entry" : " entries";
          secondToText = parseInt(this.pagination.total) < parseInt(this.pagination.currentPage * this.pagination.perPage) ? this.pagination.total : (this.pagination.currentPage * this.pagination.perPage);
          pageText = this.pagination.total == '0' ? " 0" + entryText : this.pagination.from + " to " + secondToText + " of " + this.pagination.total + entryText;
        return pageText;
      }
    },
    props: {
        pagination: {
            type: Object,
            required: true
        }
    }
}
</script>
