export default class User {

    /**
     * @param {User} user1
     * @param {User} user2
     * @return {boolean}
     */
    static equal( user1, user2 ){
        return user1.username === user2.username;
    }

    /**
     *
     * @param {string} username
     * @param {number} [id]
     */
    constructor( username = "" , id ){

        this.id = (id !== undefined) ? id : null;
        this.username = username;

    }

    getFromJson( json ){
        let temp = JSON.parse(json);
        this.id = temp.id;
        this.username = temp.username;
        this.clanId = temp.clanId;
        this.clan = temp.clan;
    }

}

/**
 * @param {string} json
 * @return {User[]}
 */
export function UserJSONParser( json ){
    let arrayIn = JSON.parse(json);
    let arrayOut = [];
    for( let i=0; i< arrayIn.length; i++) {
        arrayOut.push(new User(arrayIn[i].username, arrayIn[i].id));
    }
    return arrayOut;
}