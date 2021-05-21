<template>
	<div>
		<div class="flex flex-col" v-if="entries.length > 0" id="entries">
			<entry-group
				v-for="(group, i) in entries"
				:key="i"
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
		rebuild: {
			required: true,
		},
	},
	watch: {
		data: {
			deep: true,
			handler(val) {
				this.build(val);
			},
		},
	},
	methods: {
		build(data = null) {
			if (this.rebuild) {
				this.entries = [];
			}
			data = data || this.data;
			if (data) {
				Object.entries(data).forEach(item => {
					this.entries.push({
						date: item[0],
						subEntries: item[1].subentries,
						subtotal: item[1].subtotal,
					});
				});
			}
		},
	},
	data() {
		return {
			entries: [],
		};
	},
	created() {
		this.build();
	},
};
</script>

<style></style>
