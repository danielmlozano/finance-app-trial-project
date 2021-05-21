<template>
	<div
		class="flex flex-col mb-4 px-4 py-2 shadow-md bg-white rounded-md entry"
	>
		<div class="flex items-center">
			<div class="flex-grow">
				<div class="font-bold">
					{{ data.label }}
				</div>
				<div class="text-xs text-gray-500">
					{{ data.date | toFriendlyDate }}
				</div>
			</div>
			<div class="actions flex flex-row mr-10">
				<button
					type="button"
					@click.prevent="editing = true"
					class="action-btn text-blue-700 border-none uppercase text-sm font-bold mr-5 transition duration-500 ease-in-out"
				>
					Edit
				</button>
				<button
					type="button"
					@click="deleting = true"
					class="action-btn text-blue-700 border-none uppercase text-sm font-bold transition duration-500 ease-in-out"
				>
					Delete
				</button>
			</div>
			<div class="text-lg font-bold" :class="amountClass">
				<span v-if="data.amount >= 0">+</span>
				{{ data.amount | toCurrency }}
			</div>
		</div>

		<entry-form
			:entry="data"
			class="my-5"
			action="update"
			v-if="editing"
			@cancel="editing = false"
			@success="updated"
		/>
		<confirmation-modal :show="deleting" :closeable="true">
			<template #title>
				Are you sure you want to delete this entry?
			</template>
			<template #content>
				<div class="flex flex-row mt-5">
					<secondary-button @click.native="deleting = false">
						Cancel
					</secondary-button>
					<app-button @click.native="deleteEntry">
						Delete
					</app-button>
				</div>
			</template>
		</confirmation-modal>
	</div>
</template>

<script>
import EntryManager from "@/managers/entry";
import EntryForm from "./EntryForm.vue";
import {
	AppButton,
	ConfirmationModal,
	SecondaryButton,
} from "@/components/common";

export default {
	props: {
		data: {
			required: true,
			type: Object,
		},
	},
	data() {
		return {
			editing: false,
			deleting: false,
			model: null,
		};
	},
	methods: {
		async deleteEntry() {
			try {
				await EntryManager.deleteEntry(this.data.id);
				this.deleting = false;
				this.$emit("refresh");
			} catch (e) {
				console.error(e);
			}
		},
		updated(model) {
			this.model = model;
			this.editing = false;
			this.$emit("refresh");
		},
	},
	computed: {
		amountClass() {
			return this.data.amount >= 0 ? "text-green-500" : "";
		},
	},
	components: {
		AppButton,
		EntryForm,
		ConfirmationModal,
		SecondaryButton,
	},
	mounted() {
		this.model = { ...this.data };
	},
};
</script>
<style scoped>
.entry .actions .action-btn {
	opacity: 0;
}
.entry:hover .actions .action-btn {
	opacity: 1;
}
</style>
