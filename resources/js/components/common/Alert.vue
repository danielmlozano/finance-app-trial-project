<template>
	<div
		class="flex flex-row w-full text-white font-bold text-sm py-3 items-center justify-center"
		:class="className"
	>
		<spinner :size="7" color="white" class="ml-auto mr-5" v-if="spinner" />
		<span
			class="block text-center"
			:class="`${spinner ? 'mr-auto' : 'mx-auto'}`"
		>
			<slot></slot>
		</span>
	</div>
</template>

<script>
import Spinner from "./Spinner.vue";

export default {
	props: {
		type: {
			default: "success",
		},
		spinner: {
			default: false,
		},
	},
	computed: {
		className() {
			const types = {
				error: "bg-red-500",
				success: "bg-green-400",
				warning: "bg-orange-400",
			};
			return types[this.type];
		},
	},
	components: {
		Spinner,
	},
};
</script>
