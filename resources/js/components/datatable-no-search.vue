<template>
	<div class="dataTables_wrapper container-fluid dt-bootstrap4" :style="inlineStyles">
        <table
            class="table table-striped table-bordered dataTable"
            width="100%"
            role="grid"
            aria-described-by="ks-datatable-info"
            :class="tableClass">
            <!-- BEGIN HEADER -->
            <thead>
            <tr role="role">
                <template v-for="(column, index) in columns">
                    <th :width="column.width" :key="index">{{ column.label }}</th>
                </template>
            </tr>
            </thead>
            <!-- END HEADER -->
            <tbody>
                <!-- BEGIN DATA -->
                <slot></slot>
                <!-- END DATA -->
            </tbody>
        </table>
	</div>
</template>

<style lang="scss" scoped>
    table.dataTable tr {
        cursor: auto!important;
    }
    div.row > div > div.dataTables_length{
        display: flex;
    }
    .dataTables_filter {
        .flex-row {
            display: inline-block;
        }
    }
    div.dataTables_wrapper table.dataTable.table-bordered td,
    div.dataTables_wrapper table.dataTable.table-bordered th {
        word-break: break-word;
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
            overflow: auto;
        }
    }
    @media (max-width: 499px) {
        div.dataTables_wrapper table.dataTable.table-bordered td,
        div.dataTables_wrapper table.dataTable.table-bordered th {
            padding: 0.5rem 0.2rem;
        }
    }
</style>

<script>
    export default {
        props: {
            columns: {
                type: Array,
                required: true
            },
            inlineStyles: {
                type: Object
            },
            tableClass: {
                type: String,
                required: false
            }
        }
    }
</script>
