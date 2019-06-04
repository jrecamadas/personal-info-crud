<template>
  <input v-model='model' @focus='triggerRef'>
</template>

<script>
  export default {
    props: {
      value: [Number, String]
    },
  
    computed: {
      model: {
        get() {
          return this.value
        },
        set(v) {
          this.$emit('input', v)
        }
      }
    },
    methods: {
      isValid() {
        return Boolean(String(this.model).trim())
      },
      triggerRef() {
        this.$emit('input', this.value)
      }
    },
    async mounted() {
      this.$el.focus()
    }
  }
</script>