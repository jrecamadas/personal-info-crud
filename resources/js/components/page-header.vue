<template>
    <div class="ks-page-header">
        <section class="ks-title">
            <div class="ks-title-block">
                <h3 class="ks-main-title">{{ title }}</h3>
            </div>
            <slot></slot>
        </section>
    </div>
</template>

<style lang="scss" scoped>
    .ks-page-header {
        .ks-title {
            background: #dedbdc;
            padding-right: 20px;
        }
    }
</style>

<script>
    export default {
        props: {
            title: {
                type: String,
                required: true
            },
            sub: {
                type: String
            }
        }
    }
</script>
