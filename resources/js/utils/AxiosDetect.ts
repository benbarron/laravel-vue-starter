declare const window: any;

class AxiosDetect {
  static init(startCb: any, endCb: any) {
    let count = 0;

    window.axios.interceptors.request.use(
      function(config: any) {
        count++;

        if (count === 1) startCb();

        return config;
      },
      function(error: Error) {
        return Promise.reject(error);
      }
    );

    window.axios.interceptors.response.use(
      function(response: any) {
        count--;

        if (count === 0) {
          endCb();
        }

        return response;
      },
      function(error: Error) {
        count--;

        if (count === 0) {
          endCb();
        }

        return Promise.reject(error);
      }
    );
  }
}

export default AxiosDetect;
