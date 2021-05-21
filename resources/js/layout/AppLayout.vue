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
						<app-button :disabled="true">
							Import csv
						</app-button>
					</div>
				</div>
				<div
					class="my-auto text-right font-bold text-xs uppercase tracking-tight leading-7 text-gray-400"
				>
					Total Balance
					<span class="block text-3xl font-normal text-green-500">
						{{ total.amount }}.<span class="text-xl">{{
							total.cents
						}}</span>
					</span>
				</div>
			</div>
		</div>

		<div class="container mx-auto px-8">
			<entries v-if="!loading" :data="entries" @refresh="getData()" />
			<spinner v-else class="mx-auto mt-5" />
		</div>
		<modal :show="entryInModal" @close="entryInModal = null">
			<div>
				<h2 class="font-bold text-black text-lg">
					Add Balance Entry
				</h2>
				<entry-form
					class="my-8 pb-40"
					action="create"
					@cancel="entryInModal = null"
					@success="getData()"
				/>
			</div>
		</modal>
	</div>
</template>

<script>
import EntryManager from "@/managers/entry";
import { AppHeader, AppButton, Modal, Spinner } from "@/components/common";
import { Entries, EntryForm } from "@/components/entries";
export default {
	components: {
		EntryForm,
		AppHeader,
		AppButton,
		Entries,
		Modal,
		Spinner,
	},
	data() {
		return {
			emptyEntry: {
				label: null,
				amount: null,
				date: null,
			},
			entryInModal: null,
			total: {
				amount: 0,
				cents: 0,
			},
			entries: [],
			loading: true,
		};
	},
	methods: {
		addNewEntry() {
			this.entryInModal = this.emptyEntry;
		},
		async getData() {
			this.loading = true;
			this.entryInModal = null;
			try {
				const {
					entries,
					total,
				} = await EntryManager.getDashboardData();
				this.total = {
					amount: total[0],
					cents: total[1],
				};
				this.entries = entries;
			} catch (e) {}
			this.loading = false;
		},
	},
	async mounted() {
		await this.getData();
	},
};
</script>

<style>
.datetime-picker .year-month-wrapper,
.datetime-picker button,
.datetime-picker .activePort {
	background-color: #4676e2 !important;
	color: #fff !important;
}
.datetime-picker .days,
.datetime-picker .port:hover {
	color: #4676e2 !important;
}
#tj-datetime-input,
#tj-datetime-input:focus {
	height: 100%;
	width: 100%;
	outline: none;
}
</style>
