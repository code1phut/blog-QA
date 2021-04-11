import axios from "axios";

export default {
    data() {
        return {

        };
    },

    methods: {
         callApi(method, url, response_data) {
            try {
              return axios({
                   method: method,
                   url: url,
                   data: response_data
                });
            } catch (e) {
                return e.response;
            }
        },

        success (desc, title="Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        error (desc, title="Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        swr (desc="Something went wrong!  Please try again", title="Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
    }
}
