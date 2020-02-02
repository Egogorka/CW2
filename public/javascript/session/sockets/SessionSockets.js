import SocketPackage from "Root/session/sockets/SocketPackage";

const TYPE_VERIFY = SocketPackage.TYPE_VERIFY;
const TYPE_MESSAGE = SocketPackage.TYPE_MESSAGE;
const TYPE_PLAN = SocketPackage.TYPE_PLAN;

const TYPE_ERROR = SocketPackage.TYPE_ERROR;

export default class SessionSockets {

    messageHandler (socketPackage) {};

    planHandler (socketPackage) {};

    constructor(verificator) {
        this.ws = new WebSocket("ws://erem.sesc2018.dev.sesc-nsu.ru:8000");

        let socketPackage = new SocketPackage(TYPE_VERIFY, verificator);

        this.ws.onopen = function () {
            this.ws.send(socketPackage.getRawJson());
        }.bind(this);

        /** @param {MessageEvent} rawData */
        this.ws.onmessage = (rawData) => {
            let socketPackage = new SocketPackage();
            try {
                socketPackage.getFromRaw(rawData.data);
                switch (socketPackage.getType()) {
                    case TYPE_MESSAGE:
                        this.messageHandler(socketPackage);
                        break;
                    case TYPE_PLAN:
                        this.planHandler(socketPackage);
                        break;
                }
            } catch (e) {
                console.log(e);
                console.log(socketPackage);
                console.log(rawData);
            }
        }

    }

    /**
     * @param {function} func
     */
    setMessageHandler( func ) {
        this.messageHandler = func;
    }

    /**
     * @param {function} func
     */
    setPlanHandler( func ) {
        this.planHandler = func;
    }

    sendPackage( socketPackage ) {
        this.ws.send(socketPackage);
    }

}

