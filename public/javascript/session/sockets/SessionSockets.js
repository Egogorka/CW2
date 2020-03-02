import SocketPackage from "Root/session/sockets/SocketPackage";

export default class SessionSockets {

    constructor(verificator) {
        this.handlers = {};
        console.log("handlers: ",this.handlers);
        this.ws = new WebSocket("ws://erem.sesc2018.dev.sesc-nsu.ru:8000");

        let socketPackage = new SocketPackage(SocketPackage.TYPES.verify, verificator);

        this.ws.onopen = function () {
            this.ws.send(socketPackage.getRawJson());
        }.bind(this);

        /** @param {MessageEvent} rawData */
        this.ws.onmessage = (rawData) => {
            console.log("Got a package!\n", rawData.data);
            let socketPackage = new SocketPackage();
            try {
                socketPackage.getFromRaw(rawData.data);
                if (socketPackage.getType() in this.handlers) {
                    this.handlers[socketPackage.getType()](socketPackage);
                }
            } catch (e) {
                console.log(e);
                console.log(socketPackage);
                console.log(rawData);
            }
        }

    }

    /**
     * @callback socketHandler
     * @param {SocketPackage} socketPackage
     */

    /**
     * @param {string} type
     * @param {socketHandler} func
     */
    setHandler( func, type ){
        if( type in SocketPackage.TYPES ){
            this.handlers[type] = func;
        } else
            throw "SESSION SOCKETS ERROR: Type "+type+" is not implemented/doesnt exist";
    }

    /**
     * @param {SocketPackage} socketPackage
     */
    sendPackage( socketPackage ) {
        console.log("Sent a package!\n",socketPackage);
        this.ws.send(socketPackage.getRawJson());
    }

}

