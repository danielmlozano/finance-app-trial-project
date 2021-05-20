<template>
	<form @submit.prevent="onSubmit">
		<div class="flex flex-row">
			<div class="form-item mx-2">
				<label for="label" class="font-semibold text-sm text-gray-9000"
					>Label:</label
				>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					type="text"
					required
					v-model="entry.label"
					id="label"
				/>
			</div>
			<div class="form-item mx-2">
				<label for="date" class="font-semibold text-sm text-gray-9000"
					>Date:</label
				>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					type="text"
					required
					v-model="entry.date"
					id="date"
				/>
			</div>
			<div class="form-item mx-2">
				<label for="amount" class="font-semibold text-sm text-gray-9000"
					>Label:</label
				>
				<input
					class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
					type="text"
					required
					v-model="entry.amount"
					id="amount"
				/>
			</div>
		</div>
		<div class="flex flex-row justify-end mt-5">
			<secondary-button @click.native="$emit('cancel')">
				Cancel
			</secondary-button>
			<app-button @click.native="onSubmit" :disabled="canSubmit">
				Save entry
			</app-button>
		</div>
	</form>
</template>

<script>
import { AppButton, SecondaryButton } from "@/components/common";

export default {
	props: {
		action: {
			default: "create",
		},
		entry: {
			required: true,
			type: Object,
		},
	},
	methods: {
		onSubmit() {
			return false;
		},
	},
	computed: {
		canSubmit() {
			return true;
		},
	},
	components: {
		AppButton,
		SecondaryButton,
	},
};
</script>

<style></style>
