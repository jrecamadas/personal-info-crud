<template>
	<div style="margin-bottom:15px;">
		<div v-for="(num, index) in limit" :style="'width: ' + 100/limit + '%; color: '+fontColor" class="p-bar-num" :key="index">{{num}}</div>
	</div>
</template>
<style type="scss" scoped>
	.p-bar-num {
		display: inline-block;
		height: 10px;
		text-align: right;
		font-size: 11px;
		font-weight: 100;
	}
</style>
<script>
export default {
	props: {
		limit: {
			type: Number,
			required: false,
			default: function() {
				return 10;
			}
		},
		fontColor: {
			type: String,
			required: false,
			default: function() {
				return 'black';
			}
		}
	}
}
</script>