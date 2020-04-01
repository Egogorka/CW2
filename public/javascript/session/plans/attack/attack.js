import Point from "Root/map/Point";
import User from "Root/user/user";

import Hex from "Root/map/Hex";
import {OffsetCoordinate} from "Root/map/HexCoordinate";
import Cell from "Root/map/Cell";

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
        let obj = JSON.parse(json);
        this.budget = obj.budget;
        let rawData = JSON.parse(obj.object);

        this.users = [];

        console.log("Users: ", rawData.users);
        for( let key in rawData.users ){
            // noinspection JSUnfilteredForInLoop
            this.users[this.users.length] = new User(rawData.users[key].username, rawData.users[key].id);
        }

        let hexFrom = new Hex(
            new Cell(rawData.hexFrom.cell.color, rawData.hexFrom.cell.structure),
            new OffsetCoordinate(rawData.hexFrom.coordinate.x, rawData.hexFrom.coordinate.y)
        );

        let hexTo = new Hex(
            new Cell(rawData.hexTo.cell.color, rawData.hexTo.cell.structure),
            new OffsetCoordinate(rawData.hexTo.coordinate.x, rawData.hexTo.coordinate.y)
        );

        this.hexFrom = hexFrom;
        this.hexTo = hexTo;

        console.log(rawData);
    }

}