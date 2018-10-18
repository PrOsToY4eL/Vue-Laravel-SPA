import { setAuthorization } from "./general";

export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/auth/login', credentials)
            .then((response) => {
                setAuthorization(response.data.access_token);
                res(response.data);
            })
            .catch((err) =>{
                rej("Wrong email or password");
            })
    })
}

export function registration(credentials){
    return new Promise((res, rej) => {
        axios.post('api/auth/register', credentials)
            .then((response) => {
                console.log(response.data.access_token);
                setAuthorization(response.data.access_token);
                res(response.data);
            })
            .catch((err) =>{
                console.log(err);
                rej(err);
            })
    })
}

export function profileEdit(credentials){
    return new Promise((res, rej) => {
        axios.post('api/profile/edit', credentials)
            .then((response) => {
                //console.log(response.data.access_token);
                //setAuthorization(response.data.access_token);
                res(response.data);
            })
            .catch((err) =>{
                //console.log(err);
                rej(err);
            })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem("user");

    if(!userStr) {
        return null;
    }

    return JSON.parse(userStr);
}