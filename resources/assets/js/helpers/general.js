export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
        const currentUser = store.state.currentUser;
    
        if(requiresAuth && !currentUser) {
            next('/login');
        } else if(to.path === '/login' && currentUser) {
            next('/');
        } else {
            next();
        }
    });
    
    axios.interceptors.response.use(null, (error) => {
        if (error.response.status === 401) {
            store.commit('logout');
            router.push('/login');
        }

        return Promise.reject(error);
    });

    if (store.getters.currentUser) {
        setAuthorization(store.getters.currentUser.token);
    }
}

export function setAuthorization(token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}

export function getFormData(data, avatar) {
    let formData = new FormData();
    formData.append('email', data.form.email);
    formData.append('password', data.form.password);
    formData.append('newPassword', data.form.newPassword);
    formData.append('name', data.form.name);

    if (avatar.files[0] !== undefined) {
        formData.append('avatar', avatar.files[0]);
    }

    return formData;
}