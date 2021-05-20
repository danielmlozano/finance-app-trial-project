<template>
	<div class="mb-8">
		<div class="flex items-center mb-4">
			<span
				class="flex-grow text-gray-500 font-bold text-sm uppercase tracking-tight"
			>
				{{ data.date | toFriendlyDate }}
			</span>
			<span class="text-lg text-gray-500 font-bold">
				<span class="text-lg text-gray-500 font-bold">
					{{ subtotal.amount }}.<span class="text-sm">{{
						subtotal.cents
					}}</span>
				</span>
			</span>
		</div>

		<div>
			<entry
				v-for="entry in data.subEntries"
				:key="entry.id"
				:data="entry"
				@refresh="$emit('refresh')"
			/>
		</div>
	</div>
</template>

<script>
import { toCurrency } from "@/utils";
import Entry from "./Entry.vue";

export default {
	components: {
		Entry,
	},
	props: {
		data: {
			required: true,
			type: Object,
		},
	},
	computed: {
		subtotal() {
			const subtotal = toCurrency(this.data.subtotal).split(".");
			return {
				amount: subtotal[0],
				cents: subtotal[1] || "00",
			};
		},
	},
};
</script>

<style></style>
