import Point from "Root/map/Point";
import User from "Root/user/user";

import Hex from "Root/map/Hex";

export default class Attack {

    /**
     * @param {Hex|null} hexFrom
     * @param {Hex|null} hexTo
     * @param {number|null} budget
     */
    constructor( hexFrom=null , hexTo=null , budget=0 ){
        this.hexFrom = hexFrom;
        this.hexTo = hexTo;

        this.budget = budget;

        /**
         * @type {User[]}
         */
        this.users = [];
    }

    /**
     * @param {User} user
     */
    addUser( user ){
        this.users.push(user);
    }

    /**
     * @param {User} user
     * @return {User}
     */
    removeUser( user ){
        for(let key in this.users){
            if( User.equal(this.users[key] , user ) ){
                this.users.splice(key, 1);
                return user;
            }
        }
        throw new Error("No such user in this attack plan");
    }

    getJson(){
        return JSON.stringify({
            "users" : this.users,
            "hexFrom" : this.hexFrom,
            "hexTo" : this.hexTo,
        });
    }

    getFromJson(json){
        let rawData = JSON.parse(json);

        this.users = [];
        for( let user in rawData.users ){
            // noinspection JSUnfilteredForInLoop
            this.users[this.users.length] = new User(user.name, user.id);
        }
        console.log(rawData);
    }

}