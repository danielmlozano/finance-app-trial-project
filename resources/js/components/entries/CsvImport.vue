<template>
	<div class="flex flex-col">
		<form @submit.prevent="onSubmit">
			<div class="flex flex-row">
				<div class="form-item mx-2 justify-center flex-col">
					<label
						for="file"
						class="font-semibold text-sm text-gray-9000 uppercase"
						>Csv File:</label
					>
					<span
						class="text-gray-700 text-sm block my-2"
						v-if="file"
						>{{ file.name }}</span
					>
					<span
						class="text-red-500 text-sm block my-2"
						v-if="showValidationMessage"
						>Please upload a valid CSV or TXT file.</span
					>
					<label
						class="w-64 mx-auto flex flex-col items-center px-4 py-6 bg-white text-blue-500 rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-500 hover:text-white"
					>
						<svg
							class="w-8 h-8"
							fill="currentColor"
							xmlns="http://www.w3.org/2000/svg"
							viewBox="0 0 20 20"
						>
							<path
								d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"
							/>
						</svg>
						<span class="mt-2 text-base leading-normal"
							>Select file</span
						>
						<input
							type="file"
							class="hidden"
							accept=".csv, .txt"
							@change="handleInputChange"
							ref="file"
						/>
					</label>
				</div>
			</div>
			<div class="flex flex-row justify-end mt-5">
				<secondary-button @click.native="$emit('cancel')">
					Cancel
				</secondary-button>
				<app-button type="submit" :disabled="!canSubmit">
					Import files
				</app-button>
			</div>
		</form>
	</div>
</template>

<script>
import EntryManager from "@/managers/entry";
import { AppButton, SecondaryButton } from "@/components/common";

export default {
	data() {
		return {
			file: null,
			loading: false,
			showValidationMessage: false,
			errors: "",
		};
	},
	methods: {
		async onSubmit() {
			if (this.file) {
				this.loading = true;
				try {
					this.errors = "";
					const { imported_rows } = await EntryManager.importCsv(
						this.file,
					);
					this.$emit("success", imported_rows);
				} catch (e) {
					console.error(e.message);
					Object.values(e.errors).forEach(errors => {
						errors.forEach(error => (this.errors = error));
					});
				}
			}
			this.loading = false;
		},
		handleInputChange() {
			this.showValidationMessage = false;
			this.file = this.$refs.file.files[0];
			if (
				this.file.type !== "text/plain" &&
				this.file.type !== "text/csv"
			) {
				this.showValidationMessage = true;
				this.file = null;
			}
		},
	},
	computed: {
		canSubmit() {
			return !!this.file && !this.loading;
		},
	},
	components: {
		AppButton,
		SecondaryButton,
	},
};
</script>

<style></style>
