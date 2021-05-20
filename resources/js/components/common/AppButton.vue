<template>
	<button
		:type="type"
		class="flex items-center mr-4 px-3 py-2 bg-blue-700 rounded-md text-white text-xs font-bold uppercase tracking-tight"
	>
		<slot></slot>
	</button>
</template>

<script>
export default {
	props: {
		type: {
			default: "button",
		},
	},
};
</script>
