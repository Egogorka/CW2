export default class SocketPackage{

    static get TYPE_NONE()      {return "none";};

    static get TYPE_ERROR()     {return "error";};

    static get TYPE_VERIFY()    {return "verify";};
    static get TYPE_MESSAGE()   {return "message";};
    static get TYPE_PLAN()      {return "plan";};

    static get TYPES() {
        return [
            SocketPackage.TYPE_VERIFY,
            SocketPackage.TYPE_MESSAGE,
            SocketPackage.TYPE_PLAN,

            SocketPackage.TYPE_ERROR,
        ];
    }

    /**
     * @param {String} type
     * @param data
     */
    constructor( type= SocketPackage.TYPE_NONE, data=null ) {
        this.type = type;
        this.data = data;
        this.senderName = null; // if package was received, then it has a sender, either the server itself, or some person.
    }

    /**
     * @param {String} rawJson
     */
    getFromRaw( rawJson ) {

        try {
            JSON.parse(rawJson);
        } catch (e) {
            throw "SOCKET PACKAGE ERROR: JSON parse error : "+e;
        }

        let json = JSON.parse(rawJson);

        if( !("type" in json) )
            throw "SOCKET PACKAGE ERROR: Key \"type\" do not exist, may be corrupted";

        if( !("data" in json) )
            throw "SOCKET PACKAGE ERROR: Key \"data\" do not exist, may be corrupted";


        this.setType(json["type"]);
        this.setData(json["data"]);

        this.senderName = json["senderName"];


    }

    getSenderName() {
        return this.senderName;
    }

    getType() {
        return this.type;
    }

    getData() {
        return this.data;
    }

    /**
     * @param {String} type
     */
    setType( type ) {
        if( SocketPackage.TYPES.indexOf( type ) === -1 ) {
            throw "SOCKET PACKAGE ERROR: Key " + type + " is not listed in types array";
        }
        this.type = type;
    }

    setData( data ) {
        this.data = data;
    }

    getRawJson(){
        return JSON.stringify({
            "type" : this.type,
            "data" : this.data,
        });
    }
}