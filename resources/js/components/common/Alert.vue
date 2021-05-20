<template>
	<div
		class="flex flex-row w-full text-white font-bold text-sm text-center py-3"
		:class="className"
	>
		<span class="mx-auto block text-center">
			<slot></slot>
		</span>
	</div>
</template>

<script>
export default {
	props: {
		type: {
			default: "success",
		},
	},
	computed: {
		className() {
			if (this.type === "error") {
				return "bg-red-500";
			}
			return "bg-green-400";
		},
	},
};
</script>
