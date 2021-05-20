<template>
	<div class="mb-8">
		<div class="flex items-center mb-4">
			<span
				class="flex-grow text-gray-500 font-bold text-sm uppercase tracking-tight"
			>
				Today
			</span>
			<span class="text-lg text-gray-500 font-bold"
				>- $50.<span class="text-sm">00</span></span
			>
		</div>

		<div>
			<entry :data="{}" />
			<!-- <div
				class="flex items-center mb-4 px-4 py-2 shadow-md bg-white rounded-md"
			>
				<div class="flex-grow">
					<div class="font-bold">
						Lottery Win
					</div>
					<div class="text-xs text-gray-500">
						20 May, 2020 at 09:05 AM
					</div>
				</div>
				<div class="text-lg font-bold text-green-500">
					+ $10.<span class="text-sm">00</span>
				</div>
			</div> -->
		</div>
	</div>
</template>

<script>
import Entry from "./Entry.vue";

export default {
	components: {
		Entry,
	},
	props: {
		entries: {
			required: true,
			type: Array,
		},
	},
};
</script>

<style></style>
