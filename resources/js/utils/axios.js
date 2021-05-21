import axios from "axios";

class AxiosUtils {
	static responseInterceptor(response) {
		if (response.data) {
			response.data.status_code = response.status;
		} else {
			response.data = {
				status_code: 204,
			};
		}
		return response.data;
	}

	static errorInterceptor(error) {
		if (!error.response) {
			return Promise.reject(error);
		}
		return Promise.reject(error.response.data);
	}
}

const apiAxios = axios.create({
	baseURL: "/api",
	defaults: { withCredentials: true },
});

apiAxios.interceptors.response.use(
	AxiosUtils.responseInterceptor,
	AxiosUtils.errorInterceptor,
);

export default apiAxios;
