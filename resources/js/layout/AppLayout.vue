<template>
	<div>
		<app-header />
		<div class="mb-12 py-6 bg-gray-800">
			<div class="container mx-auto flex px-8">
				<div class="my-auto text-white flex flex-grow items-center">
					<h1 class="md:block hidden mr-4 text-2xl font-bold">
						Your Balance
					</h1>

					<div class="flex flex-row">
						<app-button @click.native="addNewEntry">
							Add entry
						</app-button>
						<app-button>
							Add expenses
						</app-button>
						<app-button>
							Import csv
						</app-button>
					</div>
				</div>
				<div
					class="my-auto text-right font-bold text-xs uppercase tracking-tight leading-7 text-gray-400"
				>
					Total Balance
					<span class="block text-3xl font-normal text-green-500">
						$1,725.<span class="text-xl">00</span>
					</span>
				</div>
			</div>
		</div>

		<div class="container mx-auto px-8">
			<entry-group :entries="[{}]" />
		</div>
		<modal :show="entryInModal" @close="entryInModal = null">
			<div>
				<h2 class="font-bold text-black text-lg">
					Add Balance Entry
				</h2>
				<entry-form
					:entry="entryInModal"
					class="my-8"
					@cancel="entryInModal = null"
				/>
			</div>
		</modal>
	</div>
</template>

<script>
import { apiAxios } from "@/utils";
import { AppHeader, AppButton, Modal } from "@/components/common";
import { Group, EntryForm } from "@/components/entries";
export default {
	components: {
		EntryForm,
		AppHeader,
		AppButton,
		"entry-group": Group,
		Modal,
	},
	data() {
		return {
			emptyEntry: {
				label: null,
				amount: null,
				date: null,
			},
			entryInModal: null,
		};
	},
	methods: {
		addNewEntry() {
			this.entryInModal = this.emptyEntry;
		},
	},
};
</script>

<style></style>
