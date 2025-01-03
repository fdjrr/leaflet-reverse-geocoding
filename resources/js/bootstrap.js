import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import "leaflet/dist/leaflet.css";
import L from "leaflet";
window.L = L;

import "leaflet-search/dist/leaflet-search.min.css";
import "leaflet-search/dist/leaflet-search.min.js";
