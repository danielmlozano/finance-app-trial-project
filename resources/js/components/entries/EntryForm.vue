<template>
	<div class="flex flex-col">
		<form @submit.prevent="onSubmit">
			<div class="flex flex-row">
				<div class="form-item mx-2">
					<label
						for="label"
						class="font-semibold text-sm text-gray-9000 uppercase"
						>Label:</label
					>
					<input
						class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
						type="text"
						required
						v-model="model.label"
						id="label"
					/>
				</div>
				<div class="form-item mx-2">
					<label
						for="date"
						class="font-semibold text-sm text-gray-9000 uppercase"
						>Date:</label
					>
					<datepicker
						class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline relative z-10"
						fprmat="YYYY-MM-DD H:i:s"
						required
						v-model="model.date"
						id="date"
					/>
				</div>
				<div class="form-item mx-2">
					<label
						for="amount"
						class="font-semibold text-sm text-gray-9000 uppercase"
						>Amount:</label
					>
					<input
						class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
						type="text"
						required
						v-model="model.amount"
						id="amount"
					/>
				</div>
			</div>
			<div class="flex flex-row justify-end mt-5">
				<secondary-button @click.native="$emit('cancel')">
					Cancel
				</secondary-button>
				<app-button type="submit" :disabled="!canSubmit">
					Save entry
				</app-button>
			</div>
		</form>
		<alert class="mt-2" type="error" v-if="errors">
			{{ errors }}
		</alert>
	</div>
</template>

<script>
import Datepicker from "vuejs-datetimepicker";
import EntryManager from "@/managers/entry";
import { Alert, AppButton, SecondaryButton } from "@/components/common";

export default {
	props: {
		action: {
			default: "create",
		},
		entry: {
			default: () => ({
				label: "",
				date: "",
				amount: 0,
			}),
		},
	},
	data() {
		return {
			nonFormattedDate: "",
			errors: "",
			model: { ...this.entry },
		};
	},
	methods: {
		async onSubmit() {
			try {
				this.errors = "";
				if (this.action === "create") {
					const response = await EntryManager.createEntry(this.model);
				} else {
					const response = await EntryManager.updateEntry(
						this.model.id,
						this.model,
					);
				}
				this.$emit("success");
			} catch (e) {
				console.error(e.message);
				Object.values(e.errors).forEach(errors => {
					errors.forEach(error => (this.errors = error));
				});
			}
		},
	},
	computed: {
		canSubmit() {
			return (
				this.model.label !== "" &&
				this.model.date !== "" &&
				this.model.amount !== 0
			);
		},
	},
	components: {
		Alert,
		AppButton,
		SecondaryButton,
		Datepicker,
	},
};
</script>

<style></style>
