// import { isNull } from "lodash";

export default {
    data() {
        return {
            errors: {}
        }
    },
    methods: {
        hasError(element) {
            if(Object.keys(this.errors).length === 0) return false;
            return this.errors.hasOwnProperty(element);
        },
        // loginIsValid(data) {
        //     if(typeof data == "undefined" || typeof data != "object") return false;

        //     let usr = data.username;
        //     let pwd = data.password;

        //     if(!usr || usr.length == 0 || isNull(usr) || typeof usr == "undefined"){ 
        //         this.errors = { username: [ "Username field is required" ] } 
        //         return false;
        //     }

        //     if(!pwd || pwd.length == 0 || isNull(pwd) || typeof pwd == "undefined"){ 
        //         this.errors = { password: [ "Username field is required" ] }
        //         return false;
        //     }

        //     return true;
        // }
    }
}