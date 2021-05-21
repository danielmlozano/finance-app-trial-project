<template>
	<button
		:type="type"
		class="flex items-center mr-4 px-3 py-2 bg-blue-200 rounded-md text-gray-400 text-xs font-bold uppercase tracking-tight"
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
