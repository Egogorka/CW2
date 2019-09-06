export default class User {

    /**
     * @param {User} user1
     * @param {User} user2
     * @return {boolean}
     */
    static equal( user1, user2 ){
        return user1.name === user2.name;
    }

    /**
     *
     * @param {string} username
     * @param {number} [id]
     */
    constructor( username , id ){

        if(id !== undefined) this.id = id;

        this.name = username;

    }




}