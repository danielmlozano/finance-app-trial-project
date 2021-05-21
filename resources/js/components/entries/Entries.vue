<template>
	<div>
		<div class="flex flex-col" v-if="entries.length > 0">
			<entry-group
				v-for="group in entries"
				:key="group.date"
				:data="group"
				@refresh="$emit('refresh')"
			/>
		</div>
		<div class="flex flex-row h-28 items-center justify-center" v-else>
			<h2 class="text-3xl text-gray-900">
				You haven't added any entry
			</h2>
		</div>
	</div>
</template>

<script>
import { Group } from "@/components/entries";
export default {
	components: {
		"entry-group": Group,
	},
	props: {
		data: {
			required: true,
		},
	},
	data() {
		return {
			entries: [],
		};
	},
	created() {
		if (this.data) {
			Object.entries(this.data).forEach(item => {
				this.entries.push({
					date: item[0],
					subEntries: item[1].subentries,
					subtotal: item[1].subtotal,
				});
			});
		}
	},
};
</script>

<style></style>
