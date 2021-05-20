<template>
	<div
		class="flex flex-col mb-4 px-4 py-2 shadow-md bg-white rounded-md entry"
	>
		<div class="flex items-center">
			<div class="flex-grow">
				<div class="font-bold">
					Groceries
				</div>
				<div class="text-xs text-gray-500">
					20 May, 2020 at 10:55 PM
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
			<div class="text-lg font-bold">
				- $60.<span class="text-sm">00</span>
			</div>
		</div>

		<entry-form
			:entry="data"
			class="my-5"
			v-if="editing"
			@cancel="editing = false"
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
		};
	},
	methods: {
		deleteEntry() {
			//
		},
	},
	components: {
		AppButton,
		EntryForm,
		ConfirmationModal,
		SecondaryButton,
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
