async function checkForExistingToken() {
    const existingToken = localStorage.getItem('auth-token');
    if (existingToken) {
        setToken(existingToken);
        try {
            let resp = await axios.get('/api/auth/me');
            if (resp.data.success) {
                return resp.data.data;
            }
        } catch (err) {}
    }

    setToken(null);

    return null;
}

function setToken(token) {
    if (token === null) {
        localStorage.removeItem('auth-token');
        axios.defaults.headers.common = {'Accept': 'application/json'};
    } else {
        localStorage.setItem('auth-token', token);
        axios.defaults.headers.common = {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
        };
    }
}

export {checkForExistingToken, setToken};