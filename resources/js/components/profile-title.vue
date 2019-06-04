<template>
    <div>
        <p class="header">
            <slot name="icon"></slot>     {{ title }}
        </p>
        <slot name="content"></slot>
    </div>
</template>
<style lang="scss" scoped>
i {
    position: absolute;
    left: -3.5rem;
    top: -.5rem;
    width: 3rem;
    height: 3rem;
    text-align: center;
    color: #58863e;
    background-color: white;
    padding: 5px;
    border-radius: 50%;
    font-size: 2rem;
    &::before {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        height: 2rem;
        width: 100%;
    }
}
img {
    position: absolute;
    width: 3rem;
    left: -60px;
    top: -10px;
}
</style>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },    
    }
}
</script>

