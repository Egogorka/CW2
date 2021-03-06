import {Plan} from "Root/session/plans/plans-model";
import Attack from "Root/session/plans/attack/attack";

export default function BuildFromJson( json ) {
    let obj = JSON.parse(json);
    let type = obj.type;
    switch (type) {
        case Plan.TYPES.attack:
            obj = new Attack();
            obj.getFromJson(json);
            break;
        case Plan.TYPES.build:
            break;
        default:
            throw "BUILD FROM JSON ERROR: No such type to handle";
    }
    return obj;
}