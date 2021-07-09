const pieces = window.pieces;

window.input = {
    canvas: document.getElementById("dragging"),
    ctx: document.getElementById("dragging").getContext("2d"),
    playerColor: 'white',
    draggingPiece: null,
    startSquare: null,

    init: function () {
        this.registerPickUpListener();
        this.registerDraggingListener();
        this.registerPlaceDownListener();
    },

    registerPickUpListener: function() {
        // start dragging a piece on mousedown
        this.canvas.addEventListener('mousedown', e => {
            this.startSquare = board.getSquare(e.offsetX, e.offsetY);

            this.draggingPiece = null;
            if (this.startSquare && this.startSquare.player === this.playerColor)
            {
                this.draggingPiece = this.startSquare.player;
                pieces.remove(this.startSquare);
            }
        });
    },

    registerDraggingListener: function() {
        // draw the dragged piece at the mouse location
        this.canvas.addEventListener('mousemove', e => {
            if (!this.draggingPiece)
            {
                return;
            }

            const x   = e.offsetX - (board.squareWidth / 2);
            const y   = e.offsetY - (board.squareHeight / 2);
            const img = this.draggingPiece === 'white' ? pieces.white : pieces.black;
            this.clearCanvas();
            pieces.draw(this.ctx, img, x, y);
        });
    },

    registerPlaceDownListener: function() {
        // place the piece on mouseup
        window.addEventListener('mouseup', e => {
            if (!this.draggingPiece)
            {
                return;
            }

            const targetSquare = board.getSquare(e.offsetX, e.offsetY);
            if (targetSquare !== null)
            {
                (async () => {
                    const config = {
                        'method': 'POST',
                        'body': JSON.stringify({grid: board.grid, start: this.startSquare, target: targetSquare})
                    };
                    await fetch('api/move', config)
                    .then(response => {
                        const move = response.json(); // TODO handle returned move
                        console.log(move);
                    })
                    .catch(error => pieces.undo(this.startSquare))
                })();
            }

            this.draggingPiece = null;
            this.startSquare   = null;
            this.clearCanvas();
        });
    },

    clearCanvas: function() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
};

window.input.init();
