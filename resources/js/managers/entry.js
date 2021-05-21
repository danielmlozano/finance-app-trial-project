import { apiAxios } from "@/utils";
import { toCurrency } from "@/utils";

const endpoint = "/entries";

const EntryManager = {
	/**
	 * Get the dashboard data from the API
	 * @returns Promise Promise
	 */
	getDashboardData: async page => {
		let { entries, total } = await apiAxios.get(endpoint, {
			params: { page },
		});
		total = toCurrency(total).split(".");
		return { entries, total };
	},
	/**
	 * Get an entry by id from the API
	 * @param {number} entryId
	 * @returns Promise
	 */
	getEntry: async entryId => {
		return apiAxios.get(`${endpoint}/${entryId}`);
	},
	/**
	 * Create a new entry
	 * @param {object} data
	 * @returns Promise
	 */
	createEntry: async data => {
		return apiAxios.post(endpoint, data);
	},
	/**
	 * Update the given entry
	 * @param {number} entryId
	 * @param {object} data
	 * @returns Promise
	 */
	updateEntry: async (entryId, data) => {
		return apiAxios.put(`${endpoint}/${entryId}`, data);
	},
	/**
	 * Delete the given entry
	 * @param {number} entryId
	 * @returns Promise
	 */
	deleteEntry: async entryId => {
		return apiAxios.delete(`${endpoint}/${entryId}`);
	},

	/**
	 * Import a CSV file via API
	 * @param {file stream} file
	 * @return Promise
	 */
	importCsv: async file => {
		const formData = new FormData();
		formData.append("file", file);
		return apiAxios.post(`${endpoint}/import`, formData);
	},
};

export default EntryManager;
