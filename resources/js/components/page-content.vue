<template>
    <div class="ks-page-content">
        <div class="ks-page-content-body" :class="pageClass">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        pageClass: {
            type: String
        }
    }
}
</script>
