import axios from "axios";
let token = localStorage.getItem("token");
    if (localStorage.getItem("token")) {
      axios.defaults.headers.common["Authorization"] = "Bearer " + token;
    } else {
      axios.defaults.headers.common["Authorization"] = null;
    }
export default axios;