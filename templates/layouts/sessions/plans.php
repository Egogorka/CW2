
<?=$this->insert("layouts/sessions/planTypes/attack") ?>

<div id="plans-container" style="display: none;">

    <div id="plans-adders">
        <p id="test1"> Add attack plan on the board <button>Add</button> </p>
    </div>

    <hr>

    <ul id="plans-holder" >

      <li>
        #id <button> Remove </button> <button> Highlight </button> Attack from #hexid to #hexid (direction) <br>
        Players assigned : <ol>
            <li> #1username </li>
            <li> #2username </li>
         </ol>
      </li>

    </ul>

</div>

<!-- <script>
    /**
     * @var {JSFrame} jsFrame
     */
    let frame = mainJsFrame.create({

        appearanceName : "material",
        appearanceParam: {
            border: {
                shadow: '2px 2px 10px  rgba(0, 0, 0, 0.5)',
                width: 0,
                radius: 6,
            },
            titleBar: {
                color: '#c1c1c1',
                background: '#120e18',
                leftMargin: 20,
                height: 30,
                fontSize: 14,
                buttonWidth: 36,
                buttonHeight: 16,
                buttonColor: 'white',
                buttons: [ // buttons on the right
                    {
                        //Set font-awesome fonts(https://fontawesome.com/icons?d=gallery&m=free)
                        fa: 'fas fa-times',//code of font-awesome
                        name: 'hideButton',
                        visible: true // visibility when window is created.
                    },
                ],
            },
        },
        name: "plans-window",
        title: 'Window',
        left: 200, top: 200, width: 320, height: 220,
        movable: true,//Enable to be moved by mouse
        resizable: true,//Enable to be resized by mouse
        style: {
            backgroundColor: 'rgba(22,22,22)',
            overflow : 'auto',
        },

        html: '<div style="font-size: 15em; padding: 10px">'+document.getElementById("plans-container").innerHTML+'</div>',
    });

    frame.on("hideButton", "click", function (_frame, e) {
        _frame.hide();
    });

    document.getElementById("nav-plans").addEventListener("click", function () {
        frame.show();
    });

    document.getElementById("nav-info").addEventListener("click", function () {
        mainJsFrame.getWindowByName("plans-window").hide();
    });

</script> -->
