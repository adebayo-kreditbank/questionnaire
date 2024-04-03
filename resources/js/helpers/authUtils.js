
class ManualAuthClass {

    constructor() {
        this.authUser = 'authUser'
        this.authToken = 'authToken'
        this.userType = 'userType'
        /** set storage item name with namespace_item as key */
        this.items = {
            name : 'fullName',
            inwards : 'inwards',
            outwards : 'outwards'
        }
    }

    /** Get any state from storage */
    getData = (item) => {
        return JSON.parse(sessionStorage.getItem(this.items[item]));
    }
    setData = (item, value) => {
        sessionStorage.setItem(this.items[item], JSON.stringify(value));
    }

    /** Get userType state from storage */
    getUserType = () => {
        return JSON.parse(sessionStorage.getItem(this.userType));
    }

    /** Set userType state in session storage */
    setUserType = (state) => {
        return sessionStorage.setItem(this.userType, JSON.stringify(state));
    }

    /** Set the currentUser state in storage */
    setAuthData = (state) => {
        return sessionStorage.setItem(this.authUser, JSON.stringify(state))
    }
    getAuthData = () => {
        return JSON.parse(sessionStorage.getItem(this.authUser))
    }

    /** Set the token state in storage */
    setAuthToken = (state) => {
        return sessionStorage.setItem(this.authToken, JSON.stringify(state))
    }

    /** Get the token state from storage */
    getAuthToken = () => {
        return JSON.parse(sessionStorage.getItem(this.authToken))
    }
    
    /** empty storage during logout */
    emptyStorage = () => { 
        sessionStorage.removeItem(this.authToken)
        sessionStorage.removeItem(this.authUser)
        sessionStorage.removeItem(this.userType)
        sessionStorage.clear()
    }

    /** Returns the authenticated user */
    getAuthenticatedUser = () => {
        if (!sessionStorage.getItem(this.authUser))
            return null;
        return JSON.parse(sessionStorage.getItem(this.authUser));
    }

    /**
     * Handle the error
     * @param {*} error 
     */
    _handleError(error) {
        var errorMessage = error.message;
        return errorMessage;
    }
}



/* eslint-disable-next-line no-unused-vars */
let _manualAuthClass = null;

/**
 * Initilize the class
 */
const initManualClass = () => {
    if (!_manualAuthClass) {
       _manualAuthClass = new ManualAuthClass();
    }
    return new ManualAuthClass();
}

export { initManualClass };