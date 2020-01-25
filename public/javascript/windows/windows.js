class Windows {

    static get OPTIONS() {
        return {
            className : "windows",
        }
    }

    /**
     *
     * @param {HTMLElement} node
     */
    static isWindow( node ){

        if ( Windows.OPTIONS.className in node.dataset ){
            return true;
        }
        return false;

    }


    /**
     *
     * @param {HTMLElement} node
     * @param {string} title
     */
    static makeWindow( node , title ){

        node.classList.add(Windows.OPTIONS.className);
        node.dataset[Windows.OPTIONS.className] = "true";
        node.dataset["display"] = getComputedStyle(node).display;

        node.style.top   = (document.documentElement.clientHeight - node.offsetHeight)/2 + "px";
        node.style.left  = (document.documentElement.clientWidth  - node.offsetWidth )/2 + "px";

        Windows.makeHeader(node, title);
        Windows.hide(node);
    }

    /**
     * @return {HTMLElement}
     * @param {HTMLElement} win
     * @param {string} title
     */
    static makeHeader( win, title ) {
        let header = document.createElement("div");

        header.classList.add("windowHeader");
        header.classList.add("windowHeader"+win.id);

        header.style.width = win.offsetWidth + "px";

        let titleNode = document.createElement("span");
        titleNode.className = "windowTitle";
        titleNode.innerText = title;

        let buttonNode = document.createElement("span");
        buttonNode.className = "windowCloseButton";
        buttonNode.innerText = "X";

        // let callback = function() {Windows.hide(this);};
        // callback.bind(win);

        buttonNode.addEventListener("click", function () {
            Windows.hide(win);
        });

        header.appendChild(titleNode);
        header.appendChild(buttonNode);

        document.body.appendChild(header);
    }

    /**
     *
     * @param {HTMLElement} win
     */
    static appear( win ) {
        let header = document.getElementsByClassName("windowHeader"+win.id);

        win.style.display = win.dataset["display"];
        header.style.display = "block";
    }

    /**
     *
     * @param {HTMLElement} win
     */
    static hide( win ){
        let header = document.getElementsByClassName("windowHeader"+win.id);

        win.style.display = "none";
        header.style.display = "none";
    }


}