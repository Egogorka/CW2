import MapState from "Root/map/MapState";
import MapView from "Root/map/MapView";
import CellView from "Root/map/CellView";
import {CubeCoordinate} from "Root/map/HexCoordinate";
import Point from "Root/map/Point";
import Cell from "Root/map/Cell";
import Hex from "Root/map/Hex";
import Cursor from "Root/mapEditor/Cursor";

import ToolBox from "Root/mapEditor/ToolBox"

let MapRaw = "";

let map = new MapState(MapRaw);

let view = new MapView(document.getElementById("MapBoard"), {
    offsetX : -map.MapParams.minX*(MapView.OPTIONS.hexWidth) + 100,
    offsetY : -map.MapParams.minY*(MapView.OPTIONS.hexHeight - MapView.OPTIONS.hexMiddleSection) + 100,
});

let cellV = new CellView(view, {});


map.forEachCell(function (hex) {
    cellV.appendHex(hex);
});

let cursorManager = new Cursor(view);

let toolbox = new ToolBox();

toolbox.setSymmetryHandler(cursorManager.symmetryEventHandler.bind(cursorManager));