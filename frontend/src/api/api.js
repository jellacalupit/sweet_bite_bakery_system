import axios from "axios";

// REACT_APP_API_URL should be the backend origin (e.g. https://sweet-bite-bakery-system.onrender.com)
const backendOrigin = (process.env.REACT_APP_API_URL || 'http://127.0.0.1:8000').replace(/\/+$/, '');
const api = axios.create({
  baseURL: `${backendOrigin}/api`,
  headers: {
    Accept: 'application/json',
  },
});

// 🔒 Attach token if it exists
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default api;
